<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prestamo;
use Illuminate\Support\Facades\Auth;
use App\Models\CajaPeriodo;
use Illuminate\Support\Carbon;
class ReporteGeneralController extends Controller
{
public function index(Request $request)
{
    if ($request->filled('periodo_id')) {
        $periodo = CajaPeriodo::findOrFail($request->input('periodo_id'));

        $reporteSemanal = CajaPeriodo::reporteGeneral(
            Carbon::parse($periodo->periodo_inicio),
            Carbon::parse($periodo->periodo_fin)
        );

        // 🔁 Ordenamos los préstamos de cada semana
        $reporteSemanal = $reporteSemanal->map(function ($semana) {
            $prestamos = $semana['prestamos'];

            // Agrupar por numero_prestamo + nombre del usuario
            $grupos = $prestamos->groupBy(function ($p) {
                $userName = strtolower($p->user->name ?? 'sin_nombre');
                return $p->numero_prestamo . '-' . $userName;
            });

            // Ordenar cada grupo por monto descendente
            $gruposOrdenados = $grupos->map(function ($grupo) {
                return $grupo->sortByDesc('monto')->values();
            });

            // Ordenar los grupos por el monto más alto del grupo
            $gruposOrdenados = $gruposOrdenados->sortByDesc(function ($grupo) {
                return $grupo->first()->monto;
            });

            // Aplanamos la colección para poder mostrarla en Blade
            $semana['prestamos'] = $gruposOrdenados->flatten(1);

            return $semana;
        });
    } else {
        // Sin filtro => no mostramos nada aún
        $reporteSemanal = collect();
    }

    // Para poblar el <select> en el formulario
    $periodos = CajaPeriodo::orderByDesc('periodo_inicio')->get();

    return view('admin.reporte_general', compact('reporteSemanal', 'periodos'));
}
}