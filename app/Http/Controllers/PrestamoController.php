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
  public function aprobar(Request $request, $id)
{
    $interes = $request->input('interes');
    $penalidad = $request->input('penalidad');

    $prestamo = Prestamo::findOrFail($id);

    $interesDecimal = $interes / 100;
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

    return redirect()->back()->with('success', "Préstamo aprobado con $interes% de interés y $penalidad% de penalidad.");
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

    if (is_null($prestamoAnterior->interes) || is_null($prestamoAnterior->porcentaje_penalidad)) {
        return back()->with('error', 'No se puede renovar porque falta información del préstamo anterior.');
    }

    $monto = $prestamoAnterior->monto;
    $interes = $prestamoAnterior->interes;
    $porcentajePenalidad = $prestamoAnterior->porcentaje_penalidad;

    $interesPagarNuevo = $monto * ($interes / 100);
    $interesPenalidadNuevo = $prestamoAnterior->interes_pagar * ($porcentajePenalidad / 100);
    $penalidadesAcumuladas = $prestamoAnterior->penalidades_acumuladas 
                            + $prestamoAnterior->interes_pagar 
                            + $interesPenalidadNuevo;
    $totalPagar = $monto + $interesPagarNuevo + $penalidadesAcumuladas;

    // Nueva fecha de inicio = día siguiente al fin del préstamo anterior
    $fechaInicioNuevo = (clone $prestamoAnterior->fecha_fin)->addDay();
    // Nueva fecha fin = 28 días después de la nueva fecha de inicio
    $fechaFinNuevo = (clone $fechaInicioNuevo)->addDays(28);

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
        'fecha_inicio' => $fechaInicioNuevo,
        'fecha_fin' => $fechaFinNuevo,
        'estado' => 'aprobado',
        'descripcion' => 'Renovación automática del préstamo anterior ID: ' . $prestamoAnterior->id,
    ]);

    return back()->with('success', 'Préstamo renovado correctamente.');
}

public function aplicarDiferencia(Request $request, $id)
{
    $request->validate([
        'diferencia' => 'required|numeric|min:0',
    ]);

    $prestamoOriginal = Prestamo::findOrFail($id);
    $diferencia = $request->input('diferencia');

    $nuevoMonto = $prestamoOriginal->monto - $diferencia;

    if ($nuevoMonto < 0) {
        return back()->with('error', 'La diferencia no puede ser mayor al monto.');
    }

    // Nueva fecha inicio = día siguiente al fin del préstamo original
    $fechaInicioNuevo = (clone $prestamoOriginal->fecha_fin)->addDay();

    // Nueva fecha fin = 28 días después de la nueva fecha inicio
    $fechaFinNuevo = (clone $fechaInicioNuevo)->addDays(28);

    // Crear un nuevo registro con los datos del préstamo original pero con monto ajustado y fechas nuevas
    $nuevoPrestamo = Prestamo::create([
    'numero_prestamo' => $prestamoOriginal->numero_prestamo,
    'user_id' => $prestamoOriginal->user_id,
    'monto' => $nuevoMonto,
    'interes' => $prestamoOriginal->interes,
    'interes_pagar' => $nuevoMonto * ($prestamoOriginal->interes / 100),
    'porcentaje_penalidad' => $prestamoOriginal->porcentaje_penalidad,
    'interes_penalidad' => 0,
    'penalidades_acumuladas' => 0,
    'total_pagar' => $nuevoMonto + ($nuevoMonto * ($prestamoOriginal->interes / 100)),
    'fecha_inicio' => $fechaInicioNuevo,
    'fecha_fin' => $fechaFinNuevo,
    'fecha_pago' => $prestamoOriginal->fecha_pago,
    'estado' => $prestamoOriginal->estado,
    'descripcion' => 'Diferencia aplicada: Interes + S/. ' . number_format($diferencia, 2) . ' | ID: ' . $prestamoOriginal->id,
]);

    return back()->with('success', 'Diferencia aplicada creando un nuevo registro correctamente.');
}
}