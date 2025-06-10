<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Si no está logueado o no es admin, redirige
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect('/home')->with('error', 'Acceso denegado. Solo para administradores.');
        }

        return $next($request); // Si es admin, continúa
    }
}
