<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Configuracion;

class ConfiguracionController extends Controller
{
    public function index()
    {
        $configuraciones = Configuracion::all();
        return view('admin.configuraciones', compact('configuraciones'));
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
}