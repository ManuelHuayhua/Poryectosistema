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
use App\Http\Controllers\Admin\AporteController;
use App\Http\Controllers\Admin\PagoReporteController;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PagosHistorialExport;
use App\Http\Controllers\Admin\ReporteGeneralController;
use App\Exports\ReporteSemanalExport;
use Illuminate\Http\Request; 

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
    if (Auth::check()) {                       // sesion iniciada
        return Auth::user()->is_admin
            ? redirect('/admin')               // is_admin = 1
            : redirect('/home');               // is_admin = 0
    }

    return redirect()->route('login');         // invitado
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

// Exportar usuarios a Excel
Route::get('/exportar-usuarios', function () {
    return Excel::download(new UsersExport, 'usuarios.xlsx');
})->name('exportar.usuarios');


//grafico-admin
Route::get('/admin/graficos', [GraficoAdminController::class, 'index'])
     ->name('admin.graficos');



     // aporte de pagos
Route::get('/admin/aportes', [AporteController::class, 'index'])
     ->name('aportes.index');
Route::post('/admin/aportes', [AporteController::class, 'store'])->name('aportes.store');
Route::get('/buscar-usuario', [AporteController::class, 'buscarUsuario'])->name('buscar.usuario');
Route::get('/buscar-usuarios-por-dni', [AporteController::class, 'filtrarUsuariosPorDni'])->name('usuarios.filtrar');




/* Guardar pago desde el mismo blade */
Route::post('/pago-reportes/generar-por-periodo',
    [PagoReporteController::class, 'generarPorPeriodo']
)->name('pago-reportes.generar-por-periodo');
Route::resource('aportes', AporteController::class);


//pagar aportes
Route::post('/admin/pago-reportes/pagar', [PagoReporteController::class, 'pagar'])
     ->name('pago-reportes.pagar');

// Exportar historial de pagos por período
     Route::get('/aportes/exportar-periodo/{periodo}', function ($periodo) {
    return Excel::download(
        new PagosHistorialExport($periodo),
        "historial_periodo_{$periodo}.xlsx"
    );
})->name('aportes.exportarPeriodo');





//
Route::get('/reporte-general', [ReporteGeneralController::class, 'index'])
     ->name('reporte.general');


// Exportar reporte semanal a Excel del reporte general
Route::get('/reporte-general/export', function (Request $request) {
    if ($request->filled('periodo_id')) {
        $periodo = \App\Models\CajaPeriodo::findOrFail($request->periodo_id);
        $reporteSemanal = \App\Models\CajaPeriodo::reporteGeneral(
            \Carbon\Carbon::parse($periodo->periodo_inicio),
            \Carbon\Carbon::parse($periodo->periodo_fin)
        );

        return Excel::download(new ReporteSemanalExport($reporteSemanal), 'reporte_general.xlsx');
    }

    return redirect()->back()->with('error', 'Debe seleccionar un período');
})->name('reporte.general.export');

});






