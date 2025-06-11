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

    $penalidades = Penalidad::where('numero_prestamo', $prestamoAnterior->numero_prestamo)
        ->orderBy('numero_penalizacion')
        ->get();

    $suma_interes = 0;
    $interes_debe_total = 0;

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

    // Cálculo de penalidades acumuladas desde la última diferencia
    $ultimaDiferencia = Penalidad::where('numero_prestamo', $prestamoAnterior->numero_prestamo)
        ->where('tipo_operacion', 'diferencia')
        ->orderByDesc('id')
        ->first();

    if ($ultimaDiferencia) {
        $penalidades_acumuladas = Penalidad::where('numero_prestamo', $prestamoAnterior->numero_prestamo)
            ->where('id', '>=', $ultimaDiferencia->id)
            ->sum('interes_debe');
    } else {
        $penalidades_acumuladas = Penalidad::where('numero_prestamo', $prestamoAnterior->numero_prestamo)
            ->sum('interes_debe');
    }

    // Obtener el préstamo anterior más reciente
    $prestamoAnteriorUltimo = Prestamo::where('numero_prestamo', $prestamoAnterior->numero_prestamo)
        ->orderByDesc('id')
        ->first();

    $interes_acumulado = $prestamoAnteriorUltimo
        ? $prestamoAnteriorUltimo->interes_pagar
            + $prestamoAnteriorUltimo->interes_acumulado
            + $prestamoAnteriorUltimo->interes_penalidad
        : $prestamoAnterior->interes_pagar + $prestamoAnterior->interes_penalidad;

        // Calcular nuevas fechas basadas en la fecha_fin del último préstamo
    $nueva_fecha_inicio = $prestamoAnteriorUltimo->fecha_fin;
    $nueva_fecha_fin = \Carbon\Carbon::parse($prestamoAnteriorUltimo->fecha_fin)->addDays(28);

    // Crear nuevo préstamo
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
        'interes_acumulado' => $interes_acumulado,
        'total_pagar' => $prestamoAnterior->monto + $prestamoAnterior->interes_pagar + $penalidades_acumuladas,
        'fecha_inicio' => $nueva_fecha_inicio,
        'fecha_fin' => $nueva_fecha_fin,
    ]);

    // Crear nueva penalidad
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

    return redirect()->back()->with('success', 'Préstamo renovado correctamente con penalidad progresiva y acumulada desde la última diferencia.');
}


public function diferencia(Request $request, $id)
{
    $request->validate([
        'diferencia' => 'required|numeric|min:0',
    ]);

    $prestamoAnterior = Prestamo::findOrFail($id);

    // Reducir el monto
    $nuevoMonto = $prestamoAnterior->monto - $request->diferencia;
    if ($nuevoMonto < 0) {
        $nuevoMonto = 0;
    }

    // Calcular nuevo interes_pagar
    $interesDecimal = $prestamoAnterior->interes / 100;
    $interes_pagar = $nuevoMonto * $interesDecimal;

    // Calcular monto total a pagar
    $total_pagar = $nuevoMonto + $interes_pagar;

    // Obtener el préstamo anterior más reciente
    $prestamoAnteriorUltimo = Prestamo::where('numero_prestamo', $prestamoAnterior->numero_prestamo)
        ->orderByDesc('id')
        ->first();

    // Calcular nuevas fechas basadas en la fecha_fin del último préstamo
    $nueva_fecha_inicio = $prestamoAnteriorUltimo->fecha_fin;
    $nueva_fecha_fin = Carbon::parse($prestamoAnteriorUltimo->fecha_fin)->addDays(28);

    // Crear nuevo préstamo
    $nuevoPrestamo = Prestamo::create([
        'user_id' => $prestamoAnterior->user_id,
        'numero_prestamo' => $prestamoAnterior->numero_prestamo,
        'monto' => $nuevoMonto,
        'estado' => 'aprobado',
        'interes' => $prestamoAnterior->interes,
        'porcentaje_penalidad' => $prestamoAnterior->porcentaje_penalidad,
        'interes_pagar' => $interes_pagar,
        'interes_penalidad' => 0, // Puedes dejarlo en 0 si solo se usará en la tabla penalidades
        'penalidades_acumuladas' => 0,
        'interes_acumulado' => 0,
        'total_pagar' => $total_pagar,
        'fecha_inicio' => $nueva_fecha_inicio,
        'fecha_fin' => $nueva_fecha_fin,
        'descripcion' => 'Diferencia aplicada: reducción de ' . $request->diferencia,
    ]);

    // Obtener número de penalización
    $numeroPenalizacion = Penalidad::where('user_id', $prestamoAnterior->user_id)
        ->where('numero_prestamo', $prestamoAnterior->numero_prestamo)
        ->max('numero_penalizacion');

    $numeroPenalizacion = $numeroPenalizacion ? $numeroPenalizacion + 1 : 1;

    // Registrar penalidad con el porcentaje exacto del préstamo
    Penalidad::create([
        'prestamo_id' => $nuevoPrestamo->id,
        'user_id' => $prestamoAnterior->user_id,
        'numero_prestamo' => $prestamoAnterior->numero_prestamo,
        'numero_penalizacion' => $numeroPenalizacion,
        'suma_interes' => $interes_pagar,
        'interes_penalidad' => $prestamoAnterior->porcentaje_penalidad, // <-- Aquí va el porcentaje
        'interes_debe' => $interes_pagar * ($prestamoAnterior->porcentaje_penalidad / 100), // Este sí es el monto
        'tipo_operacion' => 'diferencia',
    ]);

    return redirect()->back()->with('success', 'Diferencia aplicada y penalidad registrada correctamente.');
}


public function marcarPagado(Request $request, $id)
{
    $prestamo = Prestamo::findOrFail($id);

    $prestamo->estado = 'pagado';
    $prestamo->fecha_pago = now();
    $prestamo->descripcion = 'Préstamo marcado como pagado manualmente.';
    $prestamo->save();

    return redirect()->back()->with('success', 'Préstamo marcado como pagado correctamente.');
}


}