<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ReporteUserController;
use App\Http\Controllers\Admin\PrestamoPendienteController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\Admin\ReportePrestamosController;
use App\Http\Controllers\Admin\ConfiguracionController;
use App\Http\Controllers\Admin\GraficoAdminController;
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



Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Auth::routes(['register' => false]);

// ---- Rutas protegidas ----
Route::middleware('auth')->group(function () {
  
Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('auth');

// Ruta del panel principal del usuario después de iniciar sesión
// Ruta para que el usuario pueda solicitar un préstamo
Route::post('/solicitar-prestamo', [PrestamoController::class, 'store'])->name('prestamo.store');
Route::post('/prestamos/{id}/notificar-pago', [App\Http\Controllers\HomeController::class, 'notificarPago'])->name('prestamos.notificar_pago');
Route::post('/prestamo/{id}/marcar-leido', [HomeController::class, 'marcarLeido'])->name('admin.marcar_leido');
Route::get('/reporteusuarios', [ReporteUserController::class, 'index'])->name('reporteusuarios.index');


});












// Ruta para que el ADMIN vea todos los préstamos (pendientes, aprobados, rechazados)
Route::get('/admin', [PrestamoController::class, 'indexAdmin'])->middleware('auth');

  Route::get('/perfil', [PerfilController::class, 'show'])->name('perfil');
  Route::post('/perfil/cambiar-password', [PerfilController::class, 'cambiarPassword'])->name('perfil.cambiarPassword');
 
Route::middleware('auth')->group(function () {
    Route::post('/prestamos/aprobar', [PrestamoController::class, 'aprobar']);
    
  
});

Route::middleware(['auth', 'is_admin'])->group(function () {
     Route::get('/admin', [PrestamoController::class, 'indexAdmin'])->name('indexAdmin');


     // Gestión de préstamos
    Route::post('/admin/prestamos/aprobar/{id}', [PrestamoController::class, 'aprobar'])->name('prestamo.aprobar');
    Route::put('/admin/prestamos/aprobar/{id}', [PrestamoController::class, 'aprobar'])->name('prestamo.aprobar');
    Route::post('/admin/prestamos/rechazar/{id}', [PrestamoController::class, 'rechazar'])->name('prestamo.rechazar');
    Route::get('/admin/prestamos/pendientes', [PrestamoPendienteController::class, 'index'])->name('admin.prestamos.pendientes');
// aprobados solo hoy para actulizar monto

Route::patch(
    '/admin/prestamos/{id}/monto',
    [PrestamoController::class, 'actualizarMonto']
)->name('admin.prestamos.actualizarMonto');

 
    // Gestión de usuarios
    Route::get('/admin/createuser', [UserController::class, 'create'])->name('admin.createuser');
    Route::post('/admin/createuser', [UserController::class, 'store'])->name('admin.storeuser');
    Route::post('/admin/usuarios/{id}/actualizar-password', [UserController::class, 'updatePassword'])->name('admin.password.update');
    Route::put('/admin/updateuser', [UserController::class, 'updateUser'])->name('admin.updateuser');

    Route::post('/prestamos/{id}/renovar', [PrestamoController::class, 'renovar'])->name('prestamos.renovar');

Route::post('/prestamos/{id}/pagado', [PrestamoController::class, 'marcarPagado'])->name('prestamos.pagado');


Route::post('/prestamos/{id}/penalidad', [PrestamoController::class, 'penalidad'])->name('prestamos.penalidad');

Route::post('/prestamos/{id}/diferencia', [PrestamoController::class, 'aplicarDiferencia'])->name('prestamos.diferencia');

Route::post('/prestamos/{id}/cancelar', [PrestamoController::class, 'cancelar'])->name('prestamos.cancelar');



Route::get('/reporte-prestamos', [ReportePrestamosController::class, 'index'])->name('admin.reporte.prestamos');



//configuraciones 
Route::get('/admin/configuraciones', [ConfiguracionController::class, 'index'])->name('admin.configuraciones');
  Route::post('/admin/configuraciones', [ConfiguracionController::class, 'store'])->name('admin.configuraciones.store');
  Route::post('/admin/configuraciones/{id}/actualizar', [ConfiguracionController::class, 'update'])->name('admin.configuraciones.update');
Route::delete('/admin/configuraciones/{id}/eliminar', [ConfiguracionController::class, 'destroy'])->name('admin.configuraciones.destroy');
Route::post('/admin/configuracion/caja-periodo', [ConfiguracionController::class, 'storeCajaPeriodo'])->name('admin.configuracion.caja-periodo.store');
/*  Actualizar (PUT/PATCH)  */
Route::match( ['put', 'patch'],'/admin/configuracion/caja-periodo/{id}',[ConfiguracionController::class, 'updateCajaPeriodo'])->name('admin.configuracion.caja-periodo.update');
/*  Eliminar (DELETE)  */
Route::delete('/admin/configuracion/caja-periodo/{id}',[ConfiguracionController::class, 'destroyCajaPeriodo'])->name('admin.configuracion.caja-periodo.destroy');
// Ver detalles de un período de caja
Route::post(
    '/admin/configuracion/caja-periodo/{periodo}/ingresar',
    [ConfiguracionController::class, 'ingresarFondos']
)->name('admin.configuracion.caja-periodo.ingresar');


// admin generar prestamo
Route::get('/admin/prestamos/crear', [PrestamoController::class, 'crearDesdeAdmin'])->name('admin.prestamos.crear');
Route::post('/admin/prestamos', [PrestamoController::class, 'storeDesdeAdmin'])->name('admin.prestamos.store');

//grafico-admin
Route::get('/admin/graficos', [GraficoAdminController::class, 'index'])
     ->name('admin.graficos');
});






