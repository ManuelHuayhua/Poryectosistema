<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prestamo;
class ReportePrestamosController extends Controller
{
    public function index()
    {
        // ——— Autorización ———
        if (
            !Auth::check() ||             // no ha iniciado sesión
            !Auth::user()->is_admin ||    // no es admin
            !Auth::user()->ge_reportes    // no tiene permiso de reportes
        ) {
            abort(403, 'Acceso no autorizado.');
        }

        // ——— Consulta sin filtros ———
        $prestamosAgrupados = Prestamo::with('user')
            ->orderBy('numero_prestamo')
            ->orderBy('item_prestamo')
            ->get()
            ->groupBy('user_id')
            ->map(fn ($c) => $c->groupBy('numero_prestamo'));

        // ——— Vista ———
        return view('admin.reporte_prestamos', [
            'prestamosAgrupados' => $prestamosAgrupados,
        ]);
    }
}
