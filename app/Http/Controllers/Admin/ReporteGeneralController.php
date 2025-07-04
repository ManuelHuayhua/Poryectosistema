<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prestamo;
use App\Models\CajaPeriodo;
use Illuminate\Support\Carbon;
class ReporteGeneralController extends Controller
{
 public function index(Request $request)
{
    // 1)  Si viene ?periodo_id=…
    if ($request->filled('periodo_id')) {
        $periodo = CajaPeriodo::findOrFail($request->input('periodo_id'));

        $reporteSemanal = CajaPeriodo::reporteGeneral(
            Carbon::parse($periodo->periodo_inicio),
            Carbon::parse($periodo->periodo_fin)
        );
    } else {
        // 2)  Sin filtro => no mostramos nada aún
        $reporteSemanal = collect();
    }

    // Para poblar el <select>
    $periodos = CajaPeriodo::orderByDesc('periodo_inicio')->get();

    return view('admin.reporte_general', compact('reporteSemanal', 'periodos'));
}
}