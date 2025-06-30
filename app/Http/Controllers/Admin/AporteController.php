<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PagoReporte;
use App\Models\CajaPeriodo;
use App\Models\Aporte;
class AporteController extends Controller
{
    public function index()
{
    $aportes  = Aporte::all();
    $periodos = CajaPeriodo::all();

  

    // Obtener el período de caja actual
    $periodoActual = CajaPeriodo::where('periodo_inicio', '<=', now())
                                ->where('periodo_fin', '>=', now())
                                ->first();

    // Si hay un período activo, filtrar los pagos dentro de ese rango
    $pagos = collect(); // Por si no hay periodo activo
    if ($periodoActual) {
       $pagos = PagoReporte::with('aporte', 'cajaPeriodo')
    ->whereBetween('fecha_pago', [
        $periodoActual->periodo_inicio,
        $periodoActual->periodo_fin
    ])
    ->orderBy('fecha_pago')        //  ←  ascendente
    // ->orderByDesc('fecha_pago') //  ←  si los quieres del más reciente al más antiguo
    ->get();
    }
    return view('admin.aportes', compact('aportes','periodos', 'pagos', 'periodoActual'));
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
}
