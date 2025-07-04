<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PagoReporte;
use App\Models\CajaPeriodo;
use App\Models\Aporte;
use Illuminate\Support\Facades\Auth;
use App\Models\User;use App\Exports\PagosHistorialExport;
use Maatwebsite\Excel\Facades\Excel;
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




// Buscar usuario por DNI y devolver datos
public function buscarUsuario(Request $request)
{
    $dni = $request->dni;

    $usuario = User::where('dni', $dni)->first();

    $numeroCliente = Aporte::max('numero_cliente') + 1;

    if ($usuario) {
        return response()->json([
            'nombre' => $usuario->name,
            'apellido' => $usuario->apellido_paterno . ' ' . $usuario->apellido_materno,
            'numero_cliente' => $numeroCliente,
        ]);
    } else {
        return response()->json([
            'nombre' => null,
            'apellido' => null,
            'numero_cliente' => $numeroCliente,
        ]);
    }
}

public function filtrarUsuariosPorDni(Request $request)
{
    $query = $request->get('q');

    $usuarios = User::where('dni', 'LIKE', "%{$query}%")
        ->limit(5)
        ->get();

    return response()->json($usuarios->map(function($usuario) {
        return [
            'dni' => $usuario->dni,
            'nombre' => $usuario->name,
            'apellido' => $usuario->apellido_paterno . ' ' . $usuario->apellido_materno,
        ];
    }));
}


// Mostrar el formulario para crear cliente
public function store(Request $request)
{
    $request->validate([
        'nombre'   => 'required|string|max:100',
        'apellido' => 'required|string|max:100',
    ]);

    $nuevoNumeroCliente = Aporte::max('numero_cliente') + 1;

    Aporte::create([
        'numero_cliente' => $nuevoNumeroCliente,
        'nombre'         => $request->nombre,
        'apellido'       => $request->apellido,
    ]);

    return redirect()->route('aportes.index')->with('success', 'Cliente agregado correctamente.');
}

// Eliminar un cliente

public function destroy(Aporte $aporte)
{
    $aporte->delete();

    return back()->with('success', 'Cliente eliminado correctamente.');
}


}
