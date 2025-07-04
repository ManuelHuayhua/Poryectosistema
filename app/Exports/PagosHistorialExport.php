<?php

namespace App\Exports;

use App\Models\PagoReporte;
use App\Models\CajaPeriodo;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PagosHistorialExport implements FromView
{
    public function __construct(public int $periodoId) {}

    public function view(): View
    {
        $periodo = CajaPeriodo::findOrFail($this->periodoId);

        $pagos = PagoReporte::with('aporte', 'cajaPeriodo')
            ->whereBetween('fecha_pago', [
                $periodo->periodo_inicio,
                $periodo->periodo_fin
            ])
            ->orderBy('fecha_pago')
            ->get();

        return view('exports.periodo_excel', [
            'periodo' => $periodo,
            'pagos'   => $pagos,
        ]);
    }
}
