<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Prestamo;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
   public function index()
    {
        $user = Auth::user();

        // Obtener todos los préstamos del usuario logueado
        $prestamos = Prestamo::where('user_id', $user->id)->get();

        return view('home', compact('user', 'prestamos'));
    }
}
