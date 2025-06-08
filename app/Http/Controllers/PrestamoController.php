<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestamo;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\PrestamoDetalle;
class PrestamoController extends Controller
{
    // USUARIO - Solicita un préstamo
    public function store(Request $request)
    {
        $request->validate([
            'monto' => 'required|numeric|min:1',
        ]);

        $user = Auth::user();

        $numeroPrestamo = Prestamo::where('user_id', $user->id)->count() + 1;

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


    return view('admin.dashboard', compact('prestamosPendientes', 'prestamosAprobados', 'prestamosRechazados'));
}

    // ADMIN - Aprobar préstamo
    public function aprobar(Request $request, $id, $interes)
{
    $prestamo = Prestamo::findOrFail($id);

    $interesDecimal = $interes / 100;
    $monto = $prestamo->monto;
    $interesCalculado = $monto * $interesDecimal;
    $total = $monto + $interesCalculado;

    // 1. Actualiza el préstamo principal
    $prestamo->update([
        'interes' => $interes,
        'total_pagar' => $total,
         'interes_pagar' => $interesCalculado,
        'fecha_inicio' => Carbon::now(),
        'fecha_fin' => Carbon::now()->addDays(28),
        'estado' => 'aprobado',
    ]);

    return redirect()->back()->with('success', 'Préstamo aprobado con ' . $interes . '% de interés.');
}
    // ADMIN - Rechazar préstamo
    public function rechazar($id)
    {
        $prestamo = Prestamo::findOrFail($id);

        $prestamo->update([
            'estado' => 'rechazado',
        ]);

        return redirect()->back()->with('success', 'Préstamo rechazado.');
    }



public function renovar($id) 
{
    $prestamoAnterior = Prestamo::findOrFail($id);

    if ($prestamoAnterior->fecha_pago) {
        return back()->with('error', 'Este préstamo ya fue pagado.');
    }

    $monto = $prestamoAnterior->monto;
    $interes = $prestamoAnterior->interes;
    $porcentajePenalidad = $prestamoAnterior->porcentaje_penalidad ?? 20;

    // Interés de este mes
    $interesPagarNuevo = $monto * ($interes / 100);

    // Penaliza el interés anterior
    $interesPenalidadNuevo = $prestamoAnterior->interes_pagar * ($porcentajePenalidad / 100);

    // Penalidades acumuladas = penalidades anteriores + interés anterior + penalidad por interés anterior
    $penalidadesAcumuladas = $prestamoAnterior->penalidades_acumuladas 
                            + $prestamoAnterior->interes_pagar 
                            + $interesPenalidadNuevo;

    $totalPagar = $monto + $interesPagarNuevo + $penalidadesAcumuladas;

    Prestamo::create([
        'user_id' => $prestamoAnterior->user_id,
        'numero_prestamo' => $prestamoAnterior->numero_prestamo,
        'monto' => $monto,
        'interes' => $interes,
        'interes_pagar' => $interesPagarNuevo,
        'porcentaje_penalidad' => $porcentajePenalidad,
        'interes_penalidad' => $interesPenalidadNuevo,
        'penalidades_acumuladas' => $penalidadesAcumuladas,
        'total_pagar' => $totalPagar,
        'fecha_inicio' => Carbon::now(),
        'fecha_fin' => Carbon::now()->addDays(28),
        'estado' => 'aprobado',
        'descripcion' => 'Renovación automática del préstamo anterior ID: ' . $prestamoAnterior->id,
    ]);

    return back()->with('success', 'Préstamo renovado correctamente.');
}
}