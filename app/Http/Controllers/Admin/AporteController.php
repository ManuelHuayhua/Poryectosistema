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
use Illuminate\Support\Facades\DB;
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
    $dni     = $request->dni;
    $usuario = User::where('dni', $dni)->first();

    // Si ya tiene aporte, muéstralo para no crear duplicados
    $codigoExistente = optional($usuario->aporte)->numero_cliente ?? null;

    if (! $codigoExistente) {
        // Mismo algoritmo que en store()
        $ultimo = Aporte::where('numero_cliente', 'LIKE', 'CLT-%')
            ->selectRaw('CAST(SUBSTRING(numero_cliente, 5) AS UNSIGNED) as num')
            ->orderByDesc('num')
            ->value('num');

        $codigoExistente = 'CLT-' . str_pad(($ultimo ?? 0) + 1, 4, '0', STR_PAD_LEFT);
    }

    return response()->json([
        'nombre'         => $usuario->name              ?? null,
        'apellido'       => $usuario
                             ? $usuario->apellido_paterno . ' ' . $usuario->apellido_materno
                             : null,
        'numero_cliente' => $codigoExistente,   // ← el que mostrarás en el input
    ]);
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

   DB::transaction(function () use ($request) {
    $ultimoCodigo = Aporte::lockForUpdate()
        ->where('numero_cliente', 'LIKE', 'CLT-%')
        ->selectRaw("CAST(SUBSTRING(numero_cliente, 5) AS UNSIGNED) as num")
        ->orderByDesc('num')
        ->value('num');

    $nuevoCodigo = 'CLT-' . str_pad(($ultimoCodigo ?? 0) + 1, 4, '0', STR_PAD_LEFT);

    Aporte::create([
        'numero_cliente' => $nuevoCodigo,
        'nombre'         => $request->nombre,
        'apellido'       => $request->apellido,
    ]);
});

    return redirect()
        ->route('aportes.index')
        ->with('success', 'Cliente agregado correctamente.');
}

// Eliminar un cliente

public function destroy(Aporte $aporte)
{
    $aporte->delete();

    return back()->with('success', 'Cliente eliminado correctamente.');
}


}
