<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prestamo;
class ReportePrestamosController extends Controller
{
     public function index()
    {
        $prestamos = Prestamo::with('user')->get(); // Trae préstamos y su relación con usuario
        return view('admin.reporte_prestamos', compact('prestamos'));
    }
}
