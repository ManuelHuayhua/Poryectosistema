<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Configuracion;
use App\Models\CajaPeriodo;
use Illuminate\Support\Facades\DB;
class ConfiguracionController extends Controller
{
    public function index()
{
    // 1) Gate rápido: ¿tiene permiso para entrar?
    if (
        ! Auth::check() ||                 // no ha iniciado sesión
        ! Auth::user()->is_admin ||        // no es admin
        ! Auth::user()->configuracion      // admin pero sin permiso
    ) {
        abort(403, 'Acceso no autorizado.');
    }

    // 2) Datos que necesita la vista
    $configuraciones = Configuracion::all();

    // Períodos de caja: el más reciente primero
    $periodos = CajaPeriodo::orderByDesc('periodo_inicio')->get();

    // 3) Enviamos TODO a la misma vista
    return view('admin.configuraciones', compact('configuraciones', 'periodos'));
}

    public function store(Request $request)
    {
        $request->validate([
            'tipo_origen' => 'required|string|max:255',
            'interes' => 'required|numeric|min:0',
            'penalidad' => 'required|numeric|min:0',
        ]);

        Configuracion::create([
            'tipo_origen' => $request->tipo_origen,
            'interes' => $request->interes,
            'penalidad' => $request->penalidad,
        ]);

        return redirect()->route('admin.configuraciones')->with('success', 'Configuración registrada correctamente.');
    }
    public function update(Request $request, $id)
{
    $request->validate([
        'tipo_origen' => 'required|string|max:255',
        'interes' => 'required|numeric|min:0',
        'penalidad' => 'required|numeric|min:0',
    ]);

    $config = Configuracion::findOrFail($id);
    $config->update([
        'tipo_origen' => $request->tipo_origen,
        'interes' => $request->interes,
        'penalidad' => $request->penalidad,
    ]);

    return redirect()->route('admin.configuraciones')->with('success', 'Configuración actualizada.');
}

public function destroy($id)
{
    Configuracion::findOrFail($id)->delete();
    return redirect()->route('admin.configuraciones')->with('success', 'Configuración eliminada.');
}


public function storeCajaPeriodo(Request $request)
{
    $request->validate([
        'monto_inicial'  => 'required|numeric|min:0',
        'periodo_inicio' => 'required|date',
        'periodo_fin'    => 'required|date|after_or_equal:periodo_inicio',
    ]);

    // ✔️ Evitar solapes reales (sin contar bordes)
    $yaExiste = CajaPeriodo::where('periodo_inicio', '<', $request->periodo_fin)
                       ->where('periodo_fin',   '>', $request->periodo_inicio)
                       ->exists();

    if ($yaExiste) {
        return back()->withErrors('Ya existe un período que se superpone con ese rango de fechas.');
    }

    DB::transaction(function () use ($request) {
        CajaPeriodo::create([
            'monto_inicial'  => $request->monto_inicial,
            'saldo_actual'   => $request->monto_inicial,
            'periodo_inicio' => $request->periodo_inicio,
            'periodo_fin'    => $request->periodo_fin,
        ]);
    });

    return back()->with('success', 'Período de caja creado correctamente.');
}

public function updateCajaPeriodo(Request $request, $id)
{
    $request->validate([
        'monto_inicial'  => 'required|numeric|min:0',
        'periodo_inicio' => 'required|date',
        'periodo_fin'    => 'required|date|after_or_equal:periodo_inicio',
    ]);

    $periodo = CajaPeriodo::findOrFail($id);

    $yaExiste = CajaPeriodo::where('id', '!=', $id)
        ->where('periodo_inicio', '<', $request->periodo_fin)
        ->where('periodo_fin', '>', $request->periodo_inicio)
        ->exists();

    if ($yaExiste) {
        return back()->withErrors('Ya existe un período que se superpone con ese rango de fechas.');
    }

    $periodo->update([
        'monto_inicial'  => $request->monto_inicial,
        'periodo_inicio' => $request->periodo_inicio,
        'periodo_fin'    => $request->periodo_fin,
    ]);

    return back()->with('success', 'Período actualizado correctamente.');
}


public function destroyCajaPeriodo($id)
{
    $periodo = CajaPeriodo::findOrFail($id);
    $periodo->delete();

    return back()->with('success', 'Período eliminado correctamente.');
}


public function ingresarFondos(Request $request, CajaPeriodo $periodo)
{
    $request->validate([
        'monto'       => 'required|numeric|min:0.01',
        'descripcion' => 'nullable|string|max:255',
    ]);

    // (Opcional) bloquear si el periodo ya terminó
    if (! now()->between($periodo->periodo_inicio, $periodo->periodo_fin)) {
        return back()->withErrors('El período ya está cerrado.');
    }

    $periodo->registrarMovimiento(
        $request->monto,
        'ingreso',
        $request->descripcion ?: 'Ingreso desde caja'
    );

    return back()->with('success', 'Ingreso registrado correctamente.');
}
}