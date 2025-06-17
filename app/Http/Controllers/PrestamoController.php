<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Prestamo;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Penalidad;
use App\Models\TablaUsuario;
class PrestamoController extends Controller
{
    // USUARIO - Solicita un préstamo
    public function store(Request $request)
{
    $request->validate([
        'monto' => 'required|numeric|min:1',
    ]);

    $user = Auth::user();

    $ultimoPrestamo = Prestamo::where('user_id', $user->id)
                              ->orderBy('numero_prestamo', 'desc')
                              ->first();

    $numeroPrestamo = $ultimoPrestamo ? $ultimoPrestamo->numero_prestamo + 1 : 1;

    Prestamo::create([
        'user_id' => $user->id,
        'numero_prestamo' => $numeroPrestamo,
        'monto' => $request->monto,
        'estado' => 'pendiente',
    ]);

    return redirect()->back()->with('success', 'Solicitud de préstamo enviada con éxito.');
}

    // ADMIN - Ver préstamos pendientes
 public function indexAdmin()
{
    if (!Auth::user()->is_admin) {
        abort(403, 'Acceso no autorizado.');
    }

    $prestamosPendientes = Prestamo::where('estado', 'pendiente')->with('user')->get();
    $prestamosRechazados = Prestamo::where('estado', 'rechazado')->with('user')->get();
    $prestamosAprobados = Prestamo::where('estado', 'aprobado')->with('user')->get();

    // 🔄 Traer todas las configuraciones sin filtrar por tipo
    $configuraciones = DB::table('configuraciones')->get();

    return view('admin.dashboard', compact('prestamosPendientes', 'prestamosAprobados', 'prestamosRechazados', 'configuraciones'));
}

    // ADMIN - Aprobar préstamo
public function aprobar(Request $request, $id)
{
    $request->validate([
        'interes' => 'required|numeric',
        'penalidad' => 'required|numeric',
    ]);

    $interes = $request->input('interes');
    $penalidad = $request->input('penalidad');

    $prestamo = Prestamo::findOrFail($id);

    $interesDecimal = $interes / 100;
    $penalidadDecimal = $penalidad / 100;

    $monto = $prestamo->monto;
    $interesCalculado = $monto * $interesDecimal;
    $total = $monto + $interesCalculado;

    $interesTotal = $interesCalculado;
    $prestamo->update([
        'interes' => $interes,
        'porcentaje_penalidad' => $penalidad,
        'total_pagar' => $total,
        'interes_pagar' => $interesCalculado,
        'fecha_inicio' => Carbon::now(),
        'fecha_fin' => Carbon::now()->addDays(28),
        'estado' => 'aprobado',
        'interes_total' => $interesTotal,
        
    ]);

    $numeroPenalizacion = $prestamo->penalidades()->count() + 1;
    $interesDebe = $interesCalculado * $penalidadDecimal;

    Penalidad::create([
        'prestamo_id' => $prestamo->id,
        'numero_prestamo' => $prestamo->numero_prestamo,
        'numero_penalizacion' => $numeroPenalizacion,
        'suma_interes' => $interesCalculado,
        'interes_penalidad' => $penalidad,
        'interes_debe' => $interesDebe,
        'user_id' => $prestamo->user_id,
        'tipo_operacion' => 'penalidad',

    ]);

    // 🔥 Aquí creamos el registro en tabla_usuario
    TablaUsuario::create([
    'user_id' => $prestamo->user_id,
    'prestamo_id' => $prestamo->id, // 👈 AQUI ESTA EL QUE TE FALTABA
    'numero_prestamo' => $prestamo->numero_prestamo,
    'item' => 'SERIAL-' . $prestamo->id,
    'renovacion' => null,
    'junta' => null,
    'fecha_prestamos' => $prestamo->fecha_inicio,
    'fecha_pago' => $prestamo->fecha_fin,
    'monto' => $prestamo->monto,
    'interes' => $prestamo->interes_pagar,
    'interes_porcentaje' => $interes,
    'descripcion' => '',
    'estado' => 'aprobado',
]);


    return redirect()->back()->with('success', "Préstamo aprobado con $interes% de interés y $penalidad% de penalidad.");
}



public function penalidad($id)
{
    $prestamoAnterior = Prestamo::findOrFail($id);

    $penalidades = Penalidad::where('numero_prestamo', $prestamoAnterior->numero_prestamo)
    ->where('tipo_operacion', '!=', 'renovacion')
    ->orderBy('numero_penalizacion')
    ->get();

    $suma_interes = 0;
    $interes_debe_total = 0;

    foreach ($penalidades as $penalidad) {
        if ($suma_interes == 0) {
            $suma_interes = $penalidad->suma_interes;
        } else {
            $suma_interes += $penalidad->interes_debe;
        }

        $interes_penalidad_decimal = $penalidad->interes_penalidad / 100;
        $interes_debe = $suma_interes * $interes_penalidad_decimal;
        $interes_debe_total += $interes_debe;
    }

    // Cálculo de penalidades acumuladas desde la última diferencia
    $ultimaDiferencia = Penalidad::where('numero_prestamo', $prestamoAnterior->numero_prestamo)
        ->where('tipo_operacion', 'diferencia')
        ->orderByDesc('id')
        ->first();

    if ($ultimaDiferencia) {
        $penalidades_acumuladas = Penalidad::where('numero_prestamo', $prestamoAnterior->numero_prestamo)
    ->where('id', '>=', $ultimaDiferencia->id)
    ->where('tipo_operacion', '!=', 'renovacion')
    ->sum('interes_debe');
    } else {
        $penalidades_acumuladas = Penalidad::where('numero_prestamo', $prestamoAnterior->numero_prestamo)
    ->where('tipo_operacion', '!=', 'renovacion')
    ->sum('interes_debe');
    }

    $prestamoAnteriorUltimo = Prestamo::where('numero_prestamo', $prestamoAnterior->numero_prestamo)
        ->orderByDesc('id')
        ->first();

    $interes_acumulado = $prestamoAnteriorUltimo
        ? $prestamoAnteriorUltimo->interes_pagar
            + $prestamoAnteriorUltimo->interes_acumulado
            + $prestamoAnteriorUltimo->penalidades_acumuladas
        : $prestamoAnterior->interes_pagar + $prestamoAnterior->interes_penalidad;

    $nueva_fecha_inicio = $prestamoAnteriorUltimo->fecha_fin;
    $nueva_fecha_fin = \Carbon\Carbon::parse($prestamoAnteriorUltimo->fecha_fin)->addDays(28);
    $interesTotal =  $interes_acumulado + $penalidades_acumuladas + $prestamoAnterior->interes_pagar;

    // Crear nuevo préstamo
    $nuevoPrestamo = Prestamo::create([
        'user_id' => $prestamoAnterior->user_id,
        'numero_prestamo' => $prestamoAnterior->numero_prestamo,
        'monto' => $prestamoAnterior->monto,
        'estado' => 'aprobado',
        'interes' => $prestamoAnterior->interes,
        'porcentaje_penalidad' => $prestamoAnterior->porcentaje_penalidad,
        'interes_pagar' => $prestamoAnterior->interes_pagar,
        'interes_penalidad' => $prestamoAnterior->interes_pagar * ($prestamoAnterior->porcentaje_penalidad / 100),
        'penalidades_acumuladas' => $penalidades_acumuladas,
        'interes_acumulado' => $interes_acumulado,
        'total_pagar' => $prestamoAnterior->monto + $interesTotal,
        'fecha_inicio' => $nueva_fecha_inicio,
        'fecha_fin' => $nueva_fecha_fin,
        'interes_total' => $interesTotal,
        'descripcion' => 'Penalidad',
    ]);

    // Crear nueva penalidad
    $numeroPenalizacion = Penalidad::where('numero_prestamo', $nuevoPrestamo->numero_prestamo)
    ->max('numero_penalizacion') + 1;
    $ultima_penalidad = $penalidades->last();
    $ultima_suma = $ultima_penalidad->suma_interes + $ultima_penalidad->interes_debe;
    $penalidad_decimal = $ultima_penalidad->interes_penalidad / 100;
    $nuevo_interes_debe = $ultima_suma * $penalidad_decimal;

    $nuevaPenalidad = Penalidad::create([
        'prestamo_id' => $nuevoPrestamo->id,
        'numero_prestamo' => $nuevoPrestamo->numero_prestamo,
        'numero_penalizacion' => $numeroPenalizacion,
        'suma_interes' => $ultima_suma,
        'interes_penalidad' => $ultima_penalidad->interes_penalidad,
        'interes_debe' => $nuevo_interes_debe,
        'user_id' => $nuevoPrestamo->user_id,
        'tipo_operacion' => 'penalidad'
    ]);

    // Insertar el nuevo préstamo en tabla_usuario
    DB::table('tabla_usuario')->insert([
        'user_id' => $nuevoPrestamo->user_id,
        'prestamo_id' => $nuevoPrestamo->id,
        'numero_prestamo' => $nuevoPrestamo->numero_prestamo,
        'item' => null,
        'renovacion' => null,
        'junta' => null,
        'fecha_prestamos' => $nuevoPrestamo->fecha_inicio,
        'fecha_pago' => $nuevoPrestamo->fecha_fin,
        'monto' => $nuevoPrestamo->monto,
        'interes' => $nuevoPrestamo->interes_pagar,
        'interes_porcentaje' => $nuevoPrestamo->interes,
        'descripcion' => null,
        'estado' => 'aprobado',
        'created_at' => now(),
        'updated_at' => now(),
       
    ]);

    // Ahora calculamos la cantidad de penalidades antiguas correctamente
    if ($ultimaDiferencia) {
        $conteoPenalidadesAnteriores = Penalidad::where('numero_prestamo', $nuevoPrestamo->numero_prestamo)
            ->where('id', '>=', $ultimaDiferencia->id)
            ->where('id', '<', $nuevaPenalidad->id)
            ->count();
    } else {
        $conteoPenalidadesAnteriores = $penalidades->count();
    }

    // Obtenemos las penalidades anteriores para insertar en tabla_usuario
    if ($ultimaDiferencia) {
    $penalidades_anteriores = Penalidad::where('numero_prestamo', $nuevoPrestamo->numero_prestamo)
    ->where('id', '>=', $ultimaDiferencia->id)
    ->where('id', '<', $nuevaPenalidad->id)
    ->where('tipo_operacion', '!=', 'renovacion')
    ->orderBy('numero_penalizacion')
    ->get();
} else {
    $penalidades_anteriores = Penalidad::where('numero_prestamo', $nuevoPrestamo->numero_prestamo)
    ->where('id', '<', $nuevaPenalidad->id)
    ->where('tipo_operacion', '!=', 'renovacion')
    ->orderBy('numero_penalizacion')
    ->get();
}
    foreach ($penalidades_anteriores as $penalidad_item) {
        DB::table('tabla_usuario')->insert([
            'user_id' => $nuevoPrestamo->user_id,
            'prestamo_id' => $nuevoPrestamo->id,
            'numero_prestamo' => $nuevoPrestamo->numero_prestamo,
            'item' => null,
            'renovacion' => null,
            'junta' => null,
            'fecha_prestamos' => $nuevoPrestamo->fecha_inicio,
            'fecha_pago' => $nuevoPrestamo->fecha_fin,
            'monto' => $penalidad_item->suma_interes,
            'interes' => $penalidad_item->interes_debe,
            'interes_porcentaje' => $penalidad_item->interes_penalidad,
            'descripcion' => 'Penalidad',
            'estado' => 'aprobado',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    return redirect()->back()->with('success', 'Préstamo renovado correctamente con penalidad progresiva y acumulada desde la última diferencia.');
}





    // ⛔ SE ELIMINA ESTA SECCIÓN DE PENALIDAD que estaba antes en renovar ⛔
    /*
    $numeroPenalizacion = Penalidad::where('user_id', $prestamoAnterior->user_id)
        ->where('numero_prestamo', $prestamoAnterior->numero_prestamo)
        ->max('numero_penalizacion');

    $numeroPenalizacion = $numeroPenalizacion ? $numeroPenalizacion + 1 : 1;

    Penalidad::create([
        'prestamo_id' => $nuevoPrestamo->id,
        'user_id' => $prestamoAnterior->user_id,
        'numero_prestamo' => $prestamoAnterior->numero_prestamo,
        'numero_penalizacion' => $numeroPenalizacion,
        'suma_interes' => $interes_pagar,
        'interes_penalidad' => $prestamoAnterior->porcentaje_penalidad,
        'interes_debe' => $interes_pagar * ($prestamoAnterior->porcentaje_penalidad / 100),
        'tipo_operacion' => 'diferencia',
    ]);
    */
public function renovar(Request $request, $id)
{
    $prestamoAnterior = Prestamo::findOrFail($id);

    $penalidades = Penalidad::where('numero_prestamo', $prestamoAnterior->numero_prestamo)
        ->orderBy('numero_penalizacion')
        ->get();

    // Obtener última penalidad (que NO se usará)
    $ultimaPenalidad = $penalidades->last();

    // Penalidades válidas para insertar (todas menos la última)
    $penalidadesValidas = $penalidades->count() > 1 ? $penalidades->slice(0, -1) : collect();

    // Acumulados
    $penalidadesNuevas = $penalidadesValidas->sum('interes_debe');
    $penalidades_acumuladas = $prestamoAnterior->penalidades_acumuladas + ($penalidadesNuevas);

$interes_acumulado = $prestamoAnterior->interes_pagar
    + $prestamoAnterior->interes_acumulado
    + $penalidades_acumuladas;

    $interesTotal = $interes_acumulado;

    $nueva_fecha_inicio = $prestamoAnterior->fecha_fin;
    $nueva_fecha_fin = \Carbon\Carbon::parse($nueva_fecha_inicio)->addDays(28);

    // Crear el nuevo préstamo (renovado)
    $nuevoPrestamo = Prestamo::create([
        'user_id' => $prestamoAnterior->user_id,
        'numero_prestamo' => $prestamoAnterior->numero_prestamo,
        'monto' => $prestamoAnterior->monto,
        'estado' => 'aprobado',
        'interes' => $prestamoAnterior->interes,
        'porcentaje_penalidad' => $prestamoAnterior->porcentaje_penalidad,
        'interes_pagar' => $prestamoAnterior->interes_pagar,
        'interes_penalidad' => $prestamoAnterior->interes_pagar * ($prestamoAnterior->porcentaje_penalidad / 100),
        'penalidades_acumuladas' => $penalidades_acumuladas,
        'interes_acumulado' => $prestamoAnterior->interes_acumulado,
        'total_pagar' => $prestamoAnterior->monto + $interesTotal,
        'fecha_inicio' => $nueva_fecha_inicio,
        'fecha_fin' => $nueva_fecha_fin,
        'interes_total' => $interesTotal,
        'descripcion' => 'Renovación automática del préstamo',
    ]);

     // Insertar una fila adicional por el préstamo renovado en sí
    DB::table('tabla_usuario')->insert([
        'user_id' => $nuevoPrestamo->user_id,
        'prestamo_id' => $nuevoPrestamo->id,
        'numero_prestamo' => $nuevoPrestamo->numero_prestamo,
        'item' => null,
        'renovacion' => null,
        'junta' => null,
        'fecha_prestamos' => $nuevoPrestamo->fecha_inicio,
        'fecha_pago' => $nuevoPrestamo->fecha_fin,
        'monto' => $nuevoPrestamo->monto,
        'interes' => $nuevoPrestamo->interes_pagar,
        'interes_porcentaje' => $nuevoPrestamo->interes,
        'descripcion' => 'Renovación automática del préstamo',
        'estado' => 'aprobado',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    foreach ($penalidadesValidas as $penalidad) {
    // Obtener el último número penalización del nuevo préstamo
    $ultimoNumero = Penalidad::where('numero_prestamo', $nuevoPrestamo->numero_prestamo)
        ->max('numero_penalizacion');

    $siguienteNumero = $ultimoNumero ? $ultimoNumero + 1 : 1;

    Penalidad::create([
        'user_id' => $nuevoPrestamo->user_id,
        'prestamo_id' => $nuevoPrestamo->id,
        'numero_prestamo' => $nuevoPrestamo->numero_prestamo,
        'numero_penalizacion' => $siguienteNumero,
        'interes_debe' => $penalidad->interes_debe,
        'interes_penalidad' => $penalidad->interes_penalidad,
        'suma_interes' => $penalidad->suma_interes,
        'tipo_operacion' => 'renovacion',
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}



    // Insertar filas en tabla_usuario por cada penalidad anterior
    foreach ($penalidadesValidas as $penalidad) {
        DB::table('tabla_usuario')->insert([
            'user_id' => $nuevoPrestamo->user_id,
            'prestamo_id' => $nuevoPrestamo->id,
            'numero_prestamo' => $nuevoPrestamo->numero_prestamo,
            'item' => null,
            'renovacion' => null,
            'junta' => null,
            'fecha_prestamos' => $nuevoPrestamo->fecha_inicio,
            'fecha_pago' => $nuevoPrestamo->fecha_fin,
            'monto' => $penalidad->suma_interes,
            'interes' => $penalidad->interes_debe,
            'interes_porcentaje' => $penalidad->interes_penalidad,
            'descripcion' => 'penalidad',
            'estado' => 'aprobado',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

   

    return redirect()->back()->with('success', 'Préstamo renovado correctamente con penalidades anteriores reflejadas.');
}



public function diferencia(Request $request, $id)
{
    $prestamoAnterior = Prestamo::findOrFail($id);

    // Validamos que el monto que se pagará como diferencia sea válido
    $request->validate([
        'nuevo_monto' => 'required|numeric|min:0.01|max:' . $prestamoAnterior->monto,
    ]);

    // Monto que el usuario pagó como diferencia
    $montoPagado = $request->nuevo_monto;

    // El capital restante luego de pagar esa diferencia
    $capitalRestante = $prestamoAnterior->monto - $montoPagado;

    // Recalculamos el interés solo sobre el capital restante
    $interesDecimal = $prestamoAnterior->interes / 100;
    $interesPagar = $capitalRestante * $interesDecimal;

    // Calculamos el nuevo interés total a pagar sumando lo que ya venía acumulado
    $interesTotal = $prestamoAnterior->interes_acumulado + $prestamoAnterior->penalidades_acumuladas + $interesPagar;

    // Monto total a pagar (capital restante + intereses totales)
    $totalPagar = $capitalRestante + $interesTotal;

    // Las fechas continúan como si fuera una renovación
    $prestamoAnteriorUltimo = Prestamo::where('numero_prestamo', $prestamoAnterior->numero_prestamo)
        ->orderByDesc('id')
        ->first();

    $nuevaFechaInicio = $prestamoAnteriorUltimo->fecha_fin;
    $nuevaFechaFin = Carbon::parse($prestamoAnteriorUltimo->fecha_fin)->addDays(28);

    // Creamos un nuevo préstamo con el capital reducido y el nuevo interés calculado
    $nuevoPrestamo = Prestamo::create([
        'user_id' => $prestamoAnterior->user_id,
        'numero_prestamo' => $prestamoAnterior->numero_prestamo,
        'monto' => $capitalRestante,
        'estado' => 'aprobado',
        'interes' => $prestamoAnterior->interes,
        'porcentaje_penalidad' => $prestamoAnterior->porcentaje_penalidad,
        'interes_pagar' => $interesPagar,
        'interes_penalidad' => 0,
        'penalidades_acumuladas' => $prestamoAnterior->penalidades_acumuladas,
        'interes_acumulado' => $prestamoAnterior->interes_acumulado,
        'total_pagar' => $totalPagar,
        'fecha_inicio' => $nuevaFechaInicio,
        'fecha_fin' => $nuevaFechaFin,
        'descripcion' => 'Ajuste por diferencia aplicado',
        'interes_total' => $interesTotal,
    ]);

    // Buscamos el número de penalización actual
    $numeroPenalizacion = Penalidad::where('user_id', $prestamoAnterior->user_id)
        ->where('numero_prestamo', $prestamoAnterior->numero_prestamo)
        ->max('numero_penalizacion');
    $numeroPenalizacion = $numeroPenalizacion ? $numeroPenalizacion + 1 : 1;
    // Calculamos penalidad aplicable al nuevo interés generado
        $porcentajePenalidad = $prestamoAnterior->porcentaje_penalidad;
        $interesDebe = $interesPagar * ($porcentajePenalidad / 100);
    // Registramos en la tabla de penalidades pero como tipo "diferencia"
    Penalidad::create([
        'prestamo_id' => $nuevoPrestamo->id,
        'user_id' => $prestamoAnterior->user_id,
        'numero_prestamo' => $prestamoAnterior->numero_prestamo,
        'numero_penalizacion' => $numeroPenalizacion,
        'suma_interes' => $interesPagar,
         'interes_penalidad' => $porcentajePenalidad,
         'interes_debe' => $interesDebe,
        'tipo_operacion' => 'diferencia',
    ]);

    // Registramos en la tabla_usuario
    DB::table('tabla_usuario')->insert([
        'user_id' => $prestamoAnterior->user_id,
        'prestamo_id' => $nuevoPrestamo->id,
        'numero_prestamo' => $prestamoAnterior->numero_prestamo,
        'item' => null,
        'renovacion' => null,
        'junta' => null,
        'fecha_prestamos' => $nuevaFechaInicio,
        'fecha_pago' => $nuevaFechaFin,
        'monto' => $capitalRestante,
        'interes' => $interesPagar,
        'interes_porcentaje' => $prestamoAnterior->interes,

        'descripcion' => 'Ajuste por diferencia aplicado',
        'estado' => 'aprobado',
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->back()->with('success', 'Se aplicó correctamente la diferencia al préstamo.');
}


public function marcarPagado(Request $request, $id)
{
    $prestamo = Prestamo::findOrFail($id);

    // Actualizar el préstamo principal
    $prestamo->estado = 'pagado';
    $prestamo->fecha_pago = now();
    $prestamo->descripcion = 'Préstamo marcado como pagado manualmente.';
    $prestamo->save();

    // Actualizar la tabla_usuario relacionada
    DB::table('tabla_usuario')
        ->where('prestamo_id', $prestamo->id)
        ->update([
            'estado' => 'pagado',
            'fecha_pago' => now(),
        ]);

    return redirect()->back()->with('success', 'Préstamo marcado como pagado correctamente.');
}


}