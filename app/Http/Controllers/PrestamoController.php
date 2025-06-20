<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Prestamo;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Penalidad;
use App\Models\TablaUsuario;
use App\Models\User;
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
        'item_prestamo' =>1,
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
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
    ]);

    $prestamo = Prestamo::findOrFail($id);

    $interes = $request->input('interes');
    $penalidad = $request->input('penalidad');
    $esJunta = $request->has('es_junta');
    $tipoOrigen = $request->input('tipo_origen');

    $interesDecimal = $interes / 100;
    $interesCalculado = $prestamo->monto * $interesDecimal;
    $total = $prestamo->monto + $interesCalculado;

    $prestamo->update([
        'interes' => $interes,
        'porcentaje_penalidad' => $penalidad,
        'interes_pagar' => $interesCalculado,
        'interes_total' => $interesCalculado,
        'total_pagar' => $total,
        'fecha_inicio' => $request->fecha_inicio,
        'fecha_fin' => $request->fecha_fin,
        'estado' => 'aprobado',
        'n_junta' => $esJunta ? $tipoOrigen : null,
    ]);

    return redirect()->back()->with('success', "Préstamo aprobado con éxito.");
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
    // Obtener el porcentaje penalidad del préstamo base
    $porcentajePenalidad = $prestamoBase->porcentaje_penalidad;

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
            'n_junta'=>$registro->n_junta,
            'monto' => $registro->monto,
            'interes' => $registro->interes,
            'interes_pagar' => $registro->interes_pagar,
             'porcentaje_penalidad' => $registro->porcentaje_penalidad,
            'estado' => 'aprobado',
            'descripcion' => 'penalidad',
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
        'n_junta'=>$registro->n_junta,
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
            'n_junta'=>$registro->n_junta,
            'monto' => $registro->monto,
            'interes' => $registro->interes,
            'interes_pagar' => $registro->interes_pagar,
            'porcentaje_penalidad' => $registro->porcentaje_penalidad,
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
    $prestamoBase = Prestamo::findOrFail($id);
    $diferenciaMonto = floatval($request->input('diferencia_monto'));
    $grupo = $request->input('grupo');
    $item = $request->input('item');
    $filasCanceladas = explode(',', $request->input('filas_canceladas'));

    $nuevoItem = $item + 1;

    $grupoAnterior = Prestamo::where('numero_prestamo', $grupo)
        ->where('item_prestamo', $item)
        ->orderBy('id')
        ->get();

    if ($grupoAnterior->isEmpty()) {
        return redirect()->back()->with('error', 'No se encontraron registros.');
    }

    // ✅ MARCAR como "cancelado" en la tabla original
    if (!empty($filasCanceladas)) {
        Prestamo::whereIn('id', $filasCanceladas)->update(['descripcion' => 'cancelado']);
    }

    $fechaInicio = $grupoAnterior->first()->fecha_fin;
    $fechaFin = Carbon::parse($fechaInicio)->addDays(28);

    foreach ($grupoAnterior as $index => $registro) {
        if (in_array($registro->id, $filasCanceladas)) {
            continue; // Saltar filas canceladas
        }

        $nuevoMonto = $registro->monto;
        $nuevaDescripcion = $registro->descripcion;

        // Solo en la primera fila: restar el monto
        if ($index === 0) {
            $nuevoMonto = max(0, $registro->monto - $diferenciaMonto);
            $nuevaDescripcion = 'diferencia';
        }

        Prestamo::create([
            'user_id' => $registro->user_id,
            'numero_prestamo' => $registro->numero_prestamo,
            'item_prestamo' => $nuevoItem,
            'n_junta'=>$registro->n_junta,
            'monto' => $nuevoMonto,
            'interes' => $registro->interes,
            'interes_pagar' => $nuevoMonto * ($registro->interes / 100),
            'porcentaje_penalidad' => $registro->porcentaje_penalidad,
            'estado' => 'aprobado',
            'descripcion' => $nuevaDescripcion,
            'fecha_inicio' => $fechaInicio,
            'fecha_fin' => $fechaFin,
        ]);
    }

    return redirect()->back()->with('success', 'Diferencia aplicada correctamente.');
}

public function cancelar($id)
{
    $prestamo = Prestamo::findOrFail($id);
    $numeroPrestamo = $prestamo->numero_prestamo;

    // Actualizar todos los préstamos con el mismo número a 'cancelado'
    Prestamo::where('numero_prestamo', $numeroPrestamo)->update(['estado' => 'pagado']);

    return redirect()->back()->with('success', 'El préstamo fue cancelado correctamente.');
}


// generar prestamo para el cliente
public function crearDesdeAdmin()
{
    $usuarios = User::where('is_admin', 0)->get();

    return view('admin.generar_prestamo', compact('usuarios'));
}

public function storeDesdeAdmin(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'monto' => 'required|numeric|min:1',
    ]);

    $user = User::findOrFail($request->user_id);

    // Obtener el número de préstamo siguiente
    $ultimoPrestamo = Prestamo::where('user_id', $user->id)
                              ->orderBy('numero_prestamo', 'desc')
                              ->first();

    $numeroPrestamo = $ultimoPrestamo ? $ultimoPrestamo->numero_prestamo + 1 : 1;

    // Crear préstamo
    Prestamo::create([
        'user_id' => $user->id,
        'numero_prestamo' => $numeroPrestamo,
        'item_prestamo' => 1,
        'monto' => $request->monto,
        'estado' => 'pendiente',
    ]);

    return redirect()->route('admin.prestamos.crear')->with('success', 'Préstamo registrado correctamente');
}


}