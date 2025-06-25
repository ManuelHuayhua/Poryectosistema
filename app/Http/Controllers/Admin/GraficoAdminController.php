<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Models\Prestamo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class GraficoAdminController extends Controller
{
    public function index()
    {
        // ① Cajas resumen
        $totalUsuarios  = User::count();               // incluye admins
        $totalClientes  = User::where('is_admin', 0)->count();
        $totalPrestamos = Prestamo::count();

        // ② Préstamos por mes (solo aprobados/pagados)
        $prestamos = Prestamo::selectRaw("DATE_FORMAT(fecha_inicio, '%Y-%m') AS mes, COUNT(*) AS total")
            ->whereIn('estado', ['aprobado', 'pagado'])
            ->groupBy('mes')
            ->orderBy('mes')
            ->get()
            ->map(function ($item) {
                $item->mes_legible = Carbon::createFromFormat('Y-m', $item->mes)
                                           ->translatedFormat('M Y');
                return $item;
            });

        return view('admin.grafico_admin', [
            'totalUsuarios'  => $totalUsuarios,
            'totalClientes'  => $totalClientes,
            'totalPrestamos' => $totalPrestamos,
            'labels'         => $prestamos->pluck('mes_legible'),
            'datos'          => $prestamos->pluck('total'),
        ]);
    }
}