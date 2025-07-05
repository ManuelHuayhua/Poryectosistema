<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;    
class ReporteSemanalExport implements FromView
{
    protected $reporteSemanal;

    public function __construct($reporteSemanal)
    {
        $this->reporteSemanal = $reporteSemanal;
    }

    public function view(): View
    {
        return view('exports.reporte_semanal_excel', [
            'reporteSemanal' => $this->reporteSemanal
        ]);
    }
}
