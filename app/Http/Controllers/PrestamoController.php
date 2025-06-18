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

    // Obtener el número de préstamo siguiente
    $ultimoPrestamo = Prestamo::where('user_id', $user->id)
                              ->orderBy('numero_prestamo', 'desc')
                              ->first();

    $numeroPrestamo = $ultimoPrestamo ? $ultimoPrestamo->numero_prestamo + 1 : 1;

    // Crear préstamo primero
    $prestamo = Prestamo::create([
        'user_id' => $user->id,
        'numero_prestamo' => $numeroPrestamo,
        'monto' => $request->monto,
        'estado' => 'pendiente',
    ]);

    // Crear registro en tabla_usuario
    TablaUsuario::create([
        'user_id' => $user->id,
        'prestamo_id' => $prestamo->id,
        'numero_prestamo' => $numeroPrestamo,
        'monto' => $request->monto,
        'estado' => 'pendiente',
        'fecha_prestamos' => null, // Opcional, si deseas registrar la fecha
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
    $prestamosAprobados = Prestamo::where('estado', 'aprobado')
    ->with('user')
    ->whereIn(DB::raw('(numero_prestamo, item_prestamo)'), function ($query) {
        $query->selectRaw('numero_prestamo, MAX(item_prestamo)')
              ->from('prestamos')
              ->groupBy('numero_prestamo');
    })
    ->get();

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
    $esJunta = $request->has('es_junta');
    $tipoOrigen = $request->input('tipo_origen');

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
        'n_junta' => $esJunta ? $tipoOrigen : null,
        
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

    return redirect()->back()->with('success', "Préstamo aprobado con $interes% de interés y $penalidad% de penalidad.");
}



public function rechazar(Request $request, $id)
{
    $prestamo = Prestamo::findOrFail($id);

    // Cambiar estado a "rechazado"
    $prestamo->estado = 'rechazado';
    $prestamo->save();

    return redirect()->back()->with('success', 'Préstamo rechazado correctamente.');
}


public function penalidad($id) 
{
    $prestamoBase = Prestamo::findOrFail($id);
    $porcentajePenalidad = 20;

    // Obtener el último item_prestamo del mismo número de préstamo
    $ultimoItem = Prestamo::where('numero_prestamo', $prestamoBase->numero_prestamo)
        ->max('item_prestamo');

    if (!$ultimoItem) {
        return redirect()->back()->with('error', 'No hay grupo anterior para penalizar.');
    }

    // Obtener el grupo completo (último item_prestamo)
    $grupoAnterior = Prestamo::where('numero_prestamo', $prestamoBase->numero_prestamo)
        ->where('item_prestamo', $ultimoItem)
        ->orderBy('id')
        ->get();

    if ($grupoAnterior->isEmpty()) {
        return redirect()->back()->with('error', 'No hay registros en el grupo anterior.');
    }

    // Calcular fechas
    $fechaInicio = $grupoAnterior->first()->fecha_fin;
    $fechaFin = Carbon::parse($fechaInicio)->addDays(28);

    // Nuevo item
    $nuevoItem = $ultimoItem + 1;

    // Copiar grupo anterior
    foreach ($grupoAnterior as $registro) {
        Prestamo::create([
            'user_id' => $registro->user_id,
            'numero_prestamo' => $registro->numero_prestamo,
            'item_prestamo' => $nuevoItem,
            'monto' => $registro->monto,
            'interes' => $registro->interes,
            'interes_pagar' => $registro->interes_pagar,
            'estado' => 'aprobado',
            'descripcion' => $registro->descripcion,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    // Buscar la última penalidad registrada (si existe)
    $ultimaPenalidad = $grupoAnterior->where('descripcion', 'penalidad')->last();

    if ($ultimaPenalidad) {
        // Si ya había una penalidad, sumamos monto + interes_pagar de esa penalidad
        $acumulado = $ultimaPenalidad->monto + $ultimaPenalidad->interes_pagar;
    } else {
        // Si es la primera penalidad, usamos la suma de los interes_pagar anteriores
        $acumulado = $grupoAnterior->sum('interes_pagar');
    }

    // Calcular nuevo interes_pagar
    $nuevoInteresPagar = $acumulado * ($porcentajePenalidad / 100);

    // Crear nueva penalidad
    Prestamo::create([
        'user_id' => $prestamoBase->user_id,
        'numero_prestamo' => $prestamoBase->numero_prestamo,
        'item_prestamo' => $nuevoItem,
        'monto' => $acumulado,
        'interes' => $porcentajePenalidad,
        'interes_pagar' => $nuevoInteresPagar,
        'estado' => 'aprobado',
        'descripcion' => 'penalidad',
        'fecha_inicio' => $fechaInicio,
        'fecha_fin' => $fechaFin,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->back()->with('success', 'Penalidad generada correctamente.');
}


public function renovar($id)
{
    $prestamoBase = Prestamo::findOrFail($id);

    // Obtener el último item_prestamo usado
    $ultimoItem = Prestamo::where('numero_prestamo', $prestamoBase->numero_prestamo)
        ->max('item_prestamo');

    if (!$ultimoItem) {
        return redirect()->back()->with('error', 'No hay datos para renovar.');
    }

    $nuevoItem = $ultimoItem + 1;

    // Obtener todas las filas del último item
    $grupoAnterior = Prestamo::where('numero_prestamo', $prestamoBase->numero_prestamo)
        ->where('item_prestamo', $ultimoItem)
        ->orderBy('id')
        ->get();

    // Obtener fecha_inicio desde la fecha_fin del grupo anterior
    $fechaInicio = $grupoAnterior->first()->fecha_fin;
    $fechaFin = Carbon::parse($fechaInicio)->addDays(28);

    foreach ($grupoAnterior as $index => $registro) {
        Prestamo::create([
            'user_id' => $registro->user_id,
            'numero_prestamo' => $registro->numero_prestamo,
            'item_prestamo' => $nuevoItem,
            'monto' => $registro->monto,
            'interes' => $registro->interes,
            'interes_pagar' => $registro->interes_pagar,
            'estado' => 'aprobado',
            'descripcion' => $index === 0 ? 'renovar' : $registro->descripcion,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    return redirect()->back()->with('success', 'Préstamo renovado correctamente.');
}
public function aplicarDiferencia(Request $request, $id)
{
    $request->validate([
        'diferencia' => 'required|numeric',
    ]);

    $prestamoBase = Prestamo::findOrFail($id);
    $diferencia = abs($request->input('diferencia'));

    $numeroPrestamo = $prestamoBase->numero_prestamo;
    $itemActual = $prestamoBase->item_prestamo;

    // Verificar que el préstamo base sea la primera fila del grupo
    $primerPrestamo = Prestamo::where('numero_prestamo', $numeroPrestamo)
        ->where('item_prestamo', $itemActual)
        ->orderBy('id')
        ->first();

    if ($prestamoBase->id !== $primerPrestamo->id) {
        return redirect()->back()->with('error', 'Solo puedes aplicar diferencia a la primera fila del grupo.');
    }

    // Obtener todo el grupo actual
    $grupoAnterior = Prestamo::where('numero_prestamo', $numeroPrestamo)
        ->where('item_prestamo', $itemActual)
        ->orderBy('id')
        ->get();

    $nuevoItem = Prestamo::where('numero_prestamo', $numeroPrestamo)->max('item_prestamo') + 1;

    $fechaInicio = $grupoAnterior->first()->fecha_fin;
    $fechaFin = \Carbon\Carbon::parse($fechaInicio)->addDays(28);

    foreach ($grupoAnterior as $index => $registro) {
        $nuevoMonto = $registro->monto;
        $nuevoInteresPagar = $nuevoMonto * ($registro->interes / 100);

        if ($index === 0) {
            // Aplica diferencia en el primer registro
            $nuevoMonto = $registro->monto - $diferencia;
            $nuevoInteresPagar = $nuevoMonto * ($registro->interes / 100);
        }

        Prestamo::create([
            'user_id' => $registro->user_id,
            'numero_prestamo' => $registro->numero_prestamo,
            'item_prestamo' => $nuevoItem,
            'monto' => $nuevoMonto,
            'interes' => $registro->interes,
            'interes_pagar' => $nuevoInteresPagar,
            'estado' => 'aprobado',
            'descripcion' => $index === 0 ? 'diferencia aplicada de -' . $diferencia : $registro->descripcion,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
            'fecha_pago' => $registro->fecha_pago,
            'interes_total' => $nuevoInteresPagar,
            'n_junta' => $registro->n_junta,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    return redirect()->back()->with('success', 'Diferencia aplicada correctamente.');
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