<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CajaPeriodo;
class CuadraCajaController extends Controller
{
  public function index(Request $request)
    {
       // Obtener periodos para el select
    $periodos = CajaPeriodo::orderBy('periodo_inicio', 'desc')->get();

    // Si no se envía periodo_id, buscar el que contenga la fecha actual
    if ($request->filled('periodo_id')) {
        $periodoId = $request->get('periodo_id');
    } else {
        $hoy = now()->toDateString();
        $periodoActual = CajaPeriodo::where('periodo_inicio', '<=', $hoy)
            ->where('periodo_fin', '>=', $hoy)
            ->first();

        $periodoId = $periodoActual ? $periodoActual->id : optional($periodos->first())->id;
    }

    if (!$periodoId) {
        return view('admin.cuadracaja', compact('periodos'))
            ->with('mensaje', 'No hay periodos creados.');
    }

        // 1) Cantidad de socios (distinct aporte_id) en ese periodo (independiente de estado)
        $cantidadSocios = DB::table('pago_reportes')
            ->where('caja_periodo_id', $periodoId)
            ->distinct()
            ->count('aporte_id');

        // 2) Aporte por socio (sumas agrupadas, mostramos total y total pagado)
       $aportesPorSocio = DB::table('pago_reportes')
    ->select(
        'aportes.id as aporte_id',
        'aportes.numero_cliente',
        'aportes.nombre',
        'aportes.apellido',
        DB::raw('SUM(pago_reportes.monto) as total_monto'),
        DB::raw("SUM(CASE WHEN pago_reportes.estado = 'pagado' THEN pago_reportes.monto ELSE 0 END) as total_pagado"),
        DB::raw("MAX(pago_reportes.fecha_pago) as ultima_fecha_pago")
    )
    ->join('aportes', 'pago_reportes.aporte_id', '=', 'aportes.id')
    ->where('pago_reportes.caja_periodo_id', $periodoId)
    ->groupBy('aportes.id','aportes.numero_cliente','aportes.nombre','aportes.apellido')
    ->orderBy('aporte_id', 'asc')
    ->get();

        // 3) Total aportes (solo pagados) en ese periodo
        $totalAportes = DB::table('pago_reportes')
            ->where('caja_periodo_id', $periodoId)
            ->where('estado', 'pagado')
            ->sum('monto');

        // pasar el periodo seleccionado para mostrar fechas
        $periodo = CajaPeriodo::find($periodoId);


        // 4) Interés ganado en el periodo
$interesGanado = DB::table('prestamos')
    ->whereBetween('fecha_inicio', [$periodo->periodo_inicio, $periodo->periodo_fin])
    ->sum('interes_pagar');


        return view('admin.cuadracaja', compact(
            'periodos',
            'periodo',
            'cantidadSocios',
            'aportesPorSocio',
            'totalAportes',
            'interesGanado'
        ));
    }
}
