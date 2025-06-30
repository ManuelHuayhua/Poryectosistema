<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PagoReporte;
use App\Models\CajaPeriodo;
use App\Models\Aporte;
use Illuminate\Support\Facades\Auth;
class AporteController extends Controller

{
public function index(Request $request)
{

    if (
        ! Auth::check() ||                // no ha iniciado sesión
        ! Auth::user()->is_admin ||       // no es admin
        ! Auth::user()->aporte            // admin pero sin permiso de "inicio"
    ) {
        abort(403, 'Acceso no autorizado.');
    }

    // ① Datos base que ya tenías
    $aportes   = Aporte::all();
    $periodos  = CajaPeriodo::orderByDesc('periodo_inicio')->get();   // <-- ordenado
    $periodoActual = CajaPeriodo::where('periodo_inicio', '<=', now())
                                ->where('periodo_fin',   '>=', now())
                                ->first();

    /* ─────────────────────────────────────────────
       Pagos del período ACTUAL   (sin cambios)
    ───────────────────────────────────────────── */
    $pagos = collect();                     // por si no hay
    if ($periodoActual) {
        $pagos = PagoReporte::with('aporte', 'cajaPeriodo')
            ->whereBetween('fecha_pago', [
                $periodoActual->periodo_inicio,
                $periodoActual->periodo_fin
            ])
            ->orderBy('fecha_pago')
            ->get();
    }

    /* ─────────────────────────────────────────────
       ②  Pagos HISTÓRICOS (si el usuario selecciona uno)
    ───────────────────────────────────────────── */
    $periodoHist  = null;                   // período elegido
    $pagosHist    = collect();              // pagos de ese período

    if ($request->filled('periodo')) {      // viene del <select>
        $periodoHist = CajaPeriodo::find($request->periodo);

        if ($periodoHist) {
            $pagosHist = PagoReporte::with('aporte', 'cajaPeriodo')
                ->whereBetween('fecha_pago', [
                    $periodoHist->periodo_inicio,
                    $periodoHist->periodo_fin
                ])
                ->orderBy('fecha_pago')
                ->get();
        }
    }

    return view('admin.aportes', compact(
        'aportes',
        'periodos',
        'pagos',
        'periodoActual',
        'periodoHist',
        'pagosHist'
    ));
}


// Mostrar el formulario para crear un nuevo aporte
public function store(Request $request)
{
    $request->validate([
        'numero_cliente' => 'required|unique:aportes,numero_cliente',
        'nombre'         => 'required|string|max:100',
        'apellido'       => 'required|string|max:100',
    ]);

    Aporte::create($request->only(['numero_cliente', 'nombre', 'apellido']));

    return redirect()->route('aportes.index')->with('success', 'Cliente agregado correctamente.');
}

public function update(Request $request, Aporte $aporte)
{
    $request->validate([
        'numero_cliente' => 'required|unique:aportes,numero_cliente,' . $aporte->id,
        'nombre'         => 'required|string|max:100',
        'apellido'       => 'required|string|max:100',
    ]);

    $aporte->update($request->only(['numero_cliente', 'nombre', 'apellido']));

    return back()->with('success', 'Cliente actualizado correctamente.');
}

public function destroy(Aporte $aporte)
{
    $aporte->delete();

    return back()->with('success', 'Cliente eliminado correctamente.');
}


}
