<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prestamo;

class PrestamoPendienteController extends Controller
{
      public function index()
    {
        $prestamos = Prestamo::with('user')
            ->where('estado', 'pendiente')
            ->get();

        return view('admin.prestamos_pendientes', compact('prestamos'));
    }
}
