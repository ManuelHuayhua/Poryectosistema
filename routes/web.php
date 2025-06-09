<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');
// Ruta del panel principal del usuario después de iniciar sesión


// Ruta para que el usuario pueda solicitar un préstamo
Route::post('/solicitar-prestamo', [PrestamoController::class, 'store'])->name('prestamo.store');

// Ruta para que el ADMIN vea todos los préstamos (pendientes, aprobados, rechazados)
Route::get('/admin', [PrestamoController::class, 'indexAdmin'])->middleware('auth');

// Ruta para que el ADMIN apruebe un préstamo con un interés dado (5% o 10%)
Route::post('/admin/prestamos/aprobar/{id}', [PrestamoController::class, 'aprobar'])->name('prestamo.aprobar');


// Ruta para que el ADMIN rechace un préstamo
Route::post('/admin/prestamos/rechazar/{id}', [PrestamoController::class, 'rechazar'])->name('prestamo.rechazar');


// Ruta para que el ADMIN pague un préstamo
Route::post('/prestamos/{id}/renovar', [PrestamoController::class, 'renovar'])->name('prestamos.renovar');


Route::post('/prestamos/{id}/diferencia', [PrestamoController::class, 'aplicarDiferencia'])->name('prestamos.diferencia');


