<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Models\Prestamo;
use App\Http\Controllers\Controller;
use App\Models\CajaMovimiento;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;

class GraficoAdminController extends Controller
{
public function index(Request $request)
{

    
    /* 1️⃣ Validar fechas (opcional pero recomendable) */
    $request->validate([
        'desde' => ['nullable', 'date'],
        'hasta' => ['nullable', 'date', 'after_or_equal:desde'],
    ]);

    /* 2️⃣ Rango: lo que venga del usuario o un default */
    $hasta = $request->input('hasta')
           ? Carbon::parse($request->input('hasta'))->toDateString()
           : Carbon::today()->toDateString();              // ← default: hoy

    $desde = $request->input('desde')
           ? Carbon::parse($request->input('desde'))->toDateString()
           : Carbon::parse($hasta)->subDays(29)->toDateString(); // ← default: últimos 30 días

    /* 3️⃣ Tarjetas generales */
    $totalUsuarios = User::count();
    $totalClientes = User::where('is_admin', 0)->count();

    /* 4️⃣ Préstamos aprobados en el rango */
    $totalPrestamosAprobados = Prestamo::where('estado', 'aprobado')
        ->whereBetween('fecha_inicio', [$desde, $hasta])
        ->selectRaw('COUNT(DISTINCT CONCAT(numero_prestamo,"-",user_id)) AS total')
        ->value('total');

    /* 5️⃣ Datos para el gráfico (por semana ISO) */
    $datos = Prestamo::where('estado', 'aprobado')
        ->whereBetween('fecha_inicio', [$desde, $hasta])
        ->selectRaw('
            YEAR(fecha_inicio)            AS anio,
            WEEK(fecha_inicio, 3)         AS sem,
            COUNT(DISTINCT CONCAT(numero_prestamo,"-",user_id)) AS total_prestamos,
            COUNT(DISTINCT user_id)       AS total_usuarios
        ')
        ->groupBy('anio', 'sem')
        ->orderBy('anio')
        ->orderBy('sem')
        ->get();

    $labels = $prestamos = $usuarios = [];
    foreach ($datos as $fila) {
        $ini = Carbon::now()->setISODate($fila->anio, $fila->sem)->startOfWeek();
        $fin = $ini->copy()->endOfWeek();

        $labels[]    = $ini->isoFormat('DD/MM') . '–' . $fin->isoFormat('DD/MM');
        $prestamos[] = (int) $fila->total_prestamos;
        $usuarios[]  = (int) $fila->total_usuarios;
    }

    $desdeDT = Carbon::parse($desde)->startOfDay();
$hastaDT = Carbon::parse($hasta)->endOfDay();

$saldoFinal = CajaMovimiento::whereBetween('created_at', [$desdeDT, $hastaDT])
             ->latest('created_at')          // ORDER BY created_at DESC LIMIT 1
             ->value('saldo_resultante');    // null si no hay movimientos

$montoTotalMov = CajaMovimiento::whereBetween('created_at', [$desdeDT, $hastaDT])
                 ->sum('monto');

$usuariosConPrestamo = Prestamo::where('estado', 'aprobado')
                     ->whereBetween('fecha_inicio', [$desde, $hasta])
                     ->distinct('user_id')
                     ->count('user_id');

                     /* 6️⃣ Préstamos aprobados POR DÍA (dentro del rango) */
$prestamosPorDia = Prestamo::where('estado', 'aprobado')
    ->whereBetween('fecha_inicio', [$desde, $hasta])
    ->selectRaw('
        DATE(fecha_inicio)                                  AS dia,
        COUNT(DISTINCT CONCAT(numero_prestamo,"-",user_id)) AS total_prestamos,
        COUNT(DISTINCT user_id)                             AS total_usuarios
    ')
    ->groupBy('dia')
    ->orderBy('dia')
    ->get();
                     
    return view('admin.grafico_admin', compact(
        'totalUsuarios', 'totalClientes',
        'totalPrestamosAprobados',
        'labels', 'prestamos', 'usuarios',
        'desde', 'hasta', 'saldoFinal', 'montoTotalMov', 'usuariosConPrestamo',
          'prestamosPorDia'   // ← para que el Blade “recuerde” la selección
    ));
}
}