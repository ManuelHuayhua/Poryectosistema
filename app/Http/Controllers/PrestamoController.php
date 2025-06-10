<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Prestamo;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Penalidad;
class PrestamoController extends Controller
{
    // USUARIO - Solicita un préstamo
    public function store(Request $request)
{
    $request->validate([
        'monto' => 'required|numeric|min:1',
    ]);

    $user = Auth::user();

    $ultimoPrestamo = Prestamo::where('user_id', $user->id)
                              ->orderBy('numero_prestamo', 'desc')
                              ->first();

    $numeroPrestamo = $ultimoPrestamo ? $ultimoPrestamo->numero_prestamo + 1 : 1;

    Prestamo::create([
        'user_id' => $user->id,
        'numero_prestamo' => $numeroPrestamo,
        'monto' => $request->monto,
        'estado' => 'pendiente',
    ]);

    return redirect()->back()->with('success', 'Solicitud de préstamo enviada con éxito.');
}

    // ADMIN - Ver préstamos pendientes
 public function indexAdmin()
{
    if (!Auth::user()->is_admin) {
        abort(403, 'Acceso no autorizado.');
    }

    $prestamosPendientes = Prestamo::where('estado', 'pendiente')->with('user')->get();
    $prestamosRechazados = Prestamo::where('estado', 'rechazado')->with('user')->get();
    $prestamosAprobados = Prestamo::where('estado', 'aprobado')->with('user')->get();

    // 🔄 Traer todas las configuraciones sin filtrar por tipo
    $configuraciones = DB::table('configuraciones')->get();

    return view('admin.dashboard', compact('prestamosPendientes', 'prestamosAprobados', 'prestamosRechazados', 'configuraciones'));
}

    // ADMIN - Aprobar préstamo
public function aprobar(Request $request, $id)
{
    $request->validate([
        'interes' => 'required|numeric',
        'penalidad' => 'required|numeric',
    ]);

    $interes = $request->input('interes');
    $penalidad = $request->input('penalidad');

    $prestamo = Prestamo::findOrFail($id);

    $interesDecimal = $interes / 100;
    $penalidadDecimal = $penalidad / 100;

    $monto = $prestamo->monto;
    $interesCalculado = $monto * $interesDecimal;
    $total = $monto + $interesCalculado;

    $prestamo->update([
        'interes' => $interes,
        'porcentaje_penalidad' => $penalidad,
        'total_pagar' => $total,
        'interes_pagar' => $interesCalculado,
        'fecha_inicio' => Carbon::now(),
        'fecha_fin' => Carbon::now()->addDays(28),
        'estado' => 'aprobado',
    ]);

    $numeroPenalizacion = $prestamo->penalidades()->count() + 1;
    $interesDebe = $interesCalculado * $penalidadDecimal;

    Penalidad::create([
        'prestamo_id' => $prestamo->id,
        'numero_prestamo' => $prestamo->numero_prestamo,
        'numero_penalizacion' => $numeroPenalizacion,
        'suma_interes' => $interesCalculado,
        'interes_penalidad' => $penalidad,
        'interes_debe' => $interesDebe,
        'user_id' => $prestamo->user_id,
    ]);

    return redirect()->back()->with('success', "Préstamo aprobado con $interes% de interés y $penalidad% de penalidad.");
}


public function renovar($id)
{
    $prestamoAnterior = Prestamo::findOrFail($id);

    // Obtener penalidades anteriores del mismo numero_prestamo
    $penalidades = Penalidad::where('numero_prestamo', $prestamoAnterior->numero_prestamo)
        ->orderBy('numero_penalizacion')
        ->get();

    $suma_interes = 0;
    $interes_debe_total = 0;

    // Recalculamos progresivamente
    foreach ($penalidades as $penalidad) {
        if ($suma_interes == 0) {
            $suma_interes = $penalidad->suma_interes;
        } else {
            $suma_interes += $penalidad->interes_debe;
        }

        $interes_penalidad_decimal = $penalidad->interes_penalidad / 100;
        $interes_debe = $suma_interes * $interes_penalidad_decimal;

        $interes_debe_total += $interes_debe;
    }

    // 👇 Cálculo de penalidades acumuladas
    $penalidades_acumuladas = Penalidad::where('numero_prestamo', $prestamoAnterior->numero_prestamo)
        ->sum('interes_debe');

    // 👇 NUEVO: Cálculo de interes_acumulado
    $interes_acumulado = Prestamo::where('numero_prestamo', $prestamoAnterior->numero_prestamo)
        ->sum(DB::raw('interes_pagar + penalidades_acumuladas'));

    // Crear nuevo préstamo renovado
    $nuevoPrestamo = Prestamo::create([
        'user_id' => $prestamoAnterior->user_id,
        'numero_prestamo' => $prestamoAnterior->numero_prestamo,
        'monto' => $prestamoAnterior->monto,
        'estado' => 'aprobado',
        'interes' => $prestamoAnterior->interes,
        'porcentaje_penalidad' => $prestamoAnterior->porcentaje_penalidad,
        'interes_pagar' => $prestamoAnterior->interes_pagar,
        'interes_penalidad' => $prestamoAnterior->interes_pagar * ($prestamoAnterior->porcentaje_penalidad / 100), 
        'penalidades_acumuladas' => $penalidades_acumuladas,
        'interes_acumulado' => $interes_acumulado, // ✅ Línea añadida
        'total_pagar' => $prestamoAnterior->monto + $prestamoAnterior->interes_pagar + $penalidades_acumuladas,
        'fecha_inicio' => now(),
        'fecha_fin' => now()->addDays(28),
    ]);

    $numeroPenalizacion = $penalidades->count() + 1;

    $ultima_penalidad = $penalidades->last();
    $ultima_suma = $ultima_penalidad->suma_interes + $ultima_penalidad->interes_debe;
    $penalidad_decimal = $ultima_penalidad->interes_penalidad / 100;
    $nuevo_interes_debe = $ultima_suma * $penalidad_decimal;

    Penalidad::create([
        'prestamo_id' => $nuevoPrestamo->id,
        'numero_prestamo' => $nuevoPrestamo->numero_prestamo,
        'numero_penalizacion' => $numeroPenalizacion,
        'suma_interes' => $ultima_suma,
        'interes_penalidad' => $ultima_penalidad->interes_penalidad,
        'interes_debe' => $nuevo_interes_debe,
        'user_id' => $nuevoPrestamo->user_id,
    ]);

    return redirect()->back()->with('success', 'Préstamo renovado correctamente con penalidad progresiva, acumulada y nuevo interés acumulado.');
}

}