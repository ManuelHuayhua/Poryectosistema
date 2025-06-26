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
use App\Models\CajaPeriodo;
use Illuminate\Validation\ValidationException;
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
    if (
        ! Auth::check() ||                // no ha iniciado sesión
        ! Auth::user()->is_admin ||       // no es admin
        ! Auth::user()->inicio            // admin pero sin permiso de "inicio"
    ) {
        abort(403, 'Acceso no autorizado.');
    }

    // Fechas para el filtro de vencimiento
    $hoy = Carbon::today();
    $limite = $hoy->copy()->addDays(10);

    // Subquery para obtener el último item de cada préstamo
    $subquery = DB::table('prestamos')
    ->select('numero_prestamo', 'user_id', DB::raw('MAX(item_prestamo) as max_item'))
    ->groupBy('numero_prestamo', 'user_id');

    // Préstamos aprobados que vencen en los próximos 10 días (última versión de cada préstamo)
   $prestamosPorVencer = Prestamo::joinSub($subquery, 'ultimos', function ($join) {
    $join->on('prestamos.numero_prestamo', '=', 'ultimos.numero_prestamo')
         ->on('prestamos.item_prestamo', '=', 'ultimos.max_item')
         ->on('prestamos.user_id', '=', 'ultimos.user_id');
})
->where('prestamos.estado', 'aprobado')
->whereBetween('prestamos.fecha_fin', [$hoy, $limite])
->with('user')
->get()
->groupBy(function ($item) {
    return $item->numero_prestamo . '_' . $item->user_id; // agrupación única por préstamo y usuario
})
->map(function ($grupo) {
    return $grupo->first(); // en caso hayan varias versiones por usuario, solo la última
});

    // Otros préstamos
    $prestamosPendientes = Prestamo::where('estado', 'pendiente')->with('user')->get();
    $prestamosRechazados = Prestamo::where('estado', 'rechazado')->with('user')->get();

   // Todos los préstamos aprobados (última versión por préstamo)
$todosPrestamosAprobados = Prestamo::where('estado', 'aprobado')
    ->where(function ($q) {
        $q->whereNull('descripcion')                // sin descripción
          ->orWhereNotIn('descripcion', [           // o cualquier valor ≠ a los vetados
              'cancelado',
              'diferencia',
              'renovar',
          ]);
    })
    ->with('user')
    ->orderBy('numero_prestamo')
    ->orderByDesc('item_prestamo')
    ->get();

// Filtrar solo los que vencen en los próximos 10 días
$prestamosAprobados = Prestamo::joinSub($subquery, 'ultimos', function ($join) {
        $join->on('prestamos.numero_prestamo', '=', 'ultimos.numero_prestamo')
             ->on('prestamos.item_prestamo', '=', 'ultimos.max_item')
             ->on('prestamos.user_id', '=', 'ultimos.user_id');
    })
    ->where('prestamos.estado', 'aprobado')
    ->where(function ($q) {
        $q->whereNull('prestamos.descripcion')
          ->orWhereNotIn('prestamos.descripcion', ['cancelado', 'diferencia', 'renovar']);
    })
    ->whereBetween('prestamos.fecha_fin', [$hoy, $limite])
    ->with('user')
    ->orderBy('prestamos.numero_prestamo')
    ->orderByDesc('prestamos.item_prestamo')
    ->get();

    
    $configuraciones = DB::table('configuraciones')->get();

    // Variables para mostrar modales
    $hayNuevosPrestamos = $prestamosPendientes->isNotEmpty();
    $hayPrestamosPorVencer = $prestamosPorVencer->isNotEmpty();

    // Usuarios con cumpleaños en los próximos 10 días


    $hoy = Carbon::today();
$diasAviso = 10;

$usuariosConCumpleanos = DB::table('users')
    ->whereNotNull('fecha_nacimiento')
    ->get()
    ->map(function ($usuario) use ($hoy) {
        $cumple = Carbon::parse($usuario->fecha_nacimiento);
        $cumpleEsteAnio = Carbon::createFromDate($hoy->year, $cumple->month, $cumple->day);

        // Si ya pasó el cumpleaños este año, toma el del próximo año
        if ($cumpleEsteAnio->lt($hoy)) {
            $cumpleEsteAnio->addYear();
        }

        return (object)[
            'nombre' => $usuario->name . ' ' . $usuario->apellido_paterno,
            'fecha_nacimiento' => $cumple->format('d/m/Y'),
            'edad' => $cumpleEsteAnio->diffInYears($cumple),
            'dias_faltantes' => $hoy->diffInDays($cumpleEsteAnio),
            'es_hoy' => $cumpleEsteAnio->isSameDay($hoy),
        ];
    })
    ->filter(function ($usuario) use ($diasAviso) {
        return $usuario->dias_faltantes <= $diasAviso;
    })
    ->sortBy('dias_faltantes')
    ->values(); // reindexar colección
      
$prestamosNotificados = Prestamo::where('notificacion_pago', 1)
    ->with('user')
    ->get();

$hayQuierenPagar = $prestamosNotificados->isNotEmpty();



// ▸ Al inicio, justo después de calcular $hoy y $limite
$inicioHoy = Carbon::today();            // 2025-06-26 00:00:00
$finHoy    = Carbon::today()->endOfDay(); // 2025-06-26 23:59:59

$hoy = Carbon::today();   // 2025-06-26

// ① Sub-query: máximo item de cada préstamo
$maxItemPorPrestamo = DB::table('prestamos')
    ->select('numero_prestamo', 'user_id', DB::raw('MAX(item_prestamo) as max_item'))
    ->groupBy('numero_prestamo', 'user_id');

// ② Consulta principal
$prestamosSinIniciar = Prestamo::joinSub($maxItemPorPrestamo, 'maxi', function ($join) {
        $join->on('prestamos.numero_prestamo', '=', 'maxi.numero_prestamo')
             ->on('prestamos.user_id',         '=', 'maxi.user_id')
             ->on('prestamos.item_prestamo',   '=', 'maxi.max_item');  // solo el registro “más nuevo”
    })
    ->where('prestamos.estado', 'aprobado')
    ->where('maxi.max_item', 1)                       // ← descarta si existe item 2, 3…
    ->whereDate('prestamos.fecha_inicio', '>=', $hoy) // hoy o futuro
    ->with('user')
    ->orderBy('prestamos.fecha_inicio')               // primero los más cercanos a iniciar
    ->orderBy('prestamos.numero_prestamo')
    ->get();

    // Mostrar modal de cumpleaños si hay usuarios con cumpleaños en los próximos 10 días
    return view('admin.dashboard', compact(
        'prestamosPendientes',
        'prestamosAprobados',
          'todosPrestamosAprobados',
        'prestamosRechazados',
        'prestamosPorVencer',
        'configuraciones',
        'hayNuevosPrestamos',
        'hayPrestamosPorVencer',
       'usuariosConCumpleanos',
       'prestamosNotificados',
       'hayQuierenPagar',
       'prestamosSinIniciar',

    ));
    

    
}

public function actualizarMonto(Request $request, $id)
{
    if (!Auth::check() || !Auth::user()->is_admin) {
        abort(403, 'Acceso no autorizado.');
    }

    $datos = $request->validate([
        'monto' => ['required', 'numeric', 'min:0.01'],
    ]);

    $prestamo        = Prestamo::findOrFail($id);
    $prestamo->monto = $datos['monto'];
    $prestamo->save();

    return back()->with('success', 'Monto actualizado correctamente.');
}








    // ADMIN - Aprobar préstamo
public function aprobar(Request $request, $id)
{
    $request->validate([
        'interes'      => 'required|numeric',
        'penalidad'    => 'required|numeric',
        'fecha_inicio' => 'required|date',
        'fecha_fin'    => 'required|date|after_or_equal:fecha_inicio',
    ]);

    $prestamo = Prestamo::findOrFail($id);

    $interesDecimal   = $request->interes / 100;
    $interesCalculado = $prestamo->monto * $interesDecimal;
    $totalSolicitado  = $prestamo->monto + $interesCalculado;   // 👈  aquí

    DB::transaction(function () use (
        $prestamo, $request, $interesCalculado, $totalSolicitado
    ) {
        $hoy = Carbon::today();

        $periodo = CajaPeriodo::whereDate('periodo_inicio', '<=', $hoy)
                   ->whereDate('periodo_fin',    '>=', $hoy)
                   ->lockForUpdate()
                   ->first();

        if (!$periodo) {
            throw ValidationException::withMessages([
                'caja' => 'No hay un periodo de caja activo para hoy.',
            ]);
        }

        // 🔴 Comparamos contra el total
        if ($totalSolicitado > $periodo->saldo_actual) {
            throw ValidationException::withMessages([
                'caja' => 'No hay suficiente saldo en caja. Disponible: S/ '
                          . number_format($periodo->saldo_actual, 2),
            ]);
        }

       // 1️⃣  Restar el monto aprobado
    $periodo->decrement('saldo_actual', $prestamo->monto);

    // 2️⃣  Recargar el modelo para tener el nuevo saldo
    $periodo->refresh();   // ahora $periodo->saldo_actual es el saldo_resultante

    // 3️⃣  Registrar el movimiento
    $periodo->movimientos()->create([
        'monto'            => $prestamo->monto,          // lo que salió de caja
        'saldo_resultante' => $periodo->saldo_actual,
        'tipo'             => 'egreso',
        'descripcion'      => 'Préstamo aprobado',       // o "monto del préstamo"
    ]);

    // 4️⃣  Actualizar el préstamo
    $prestamo->update([
        'interes'              => $request->interes,
        'porcentaje_penalidad' => $request->penalidad,
        'interes_pagar'        => $interesCalculado,
        'fecha_inicio'         => $request->fecha_inicio,
        'fecha_fin'            => $request->fecha_fin,
        'estado'               => 'aprobado',
        'n_junta'              => $request->has('es_junta')
                                   ? $request->tipo_origen
                                   : null,
    ]);
});

    return back()->with('success', 'Préstamo aprobado con éxito.');
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
     $prestamoBase->update(['descripcion' => 'penalidad1']);
    
    // Obtener el porcentaje penalidad del préstamo base
    $porcentajePenalidad = $prestamoBase->porcentaje_penalidad;

    // Obtener el último item_prestamo del mismo número de préstamo
    $ultimoItem = Prestamo::where('numero_prestamo', $prestamoBase->numero_prestamo)
    ->where('user_id', $prestamoBase->user_id)    
    ->max('item_prestamo');

    if (!$ultimoItem) {
        return redirect()->back()->with('error', 'No hay grupo anterior para penalizar.');
    }

    // Obtener el último item_prestamo del mismo número de préstamo y usuario
$ultimoItem = Prestamo::where('numero_prestamo', $prestamoBase->numero_prestamo)
    ->where('user_id', $prestamoBase->user_id)
    ->max('item_prestamo');

// Obtener el grupo completo del mismo usuario
$grupoAnterior = Prestamo::where('numero_prestamo', $prestamoBase->numero_prestamo)
    ->where('user_id', $prestamoBase->user_id)
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
    /* ────────────────────── 1. Validaciones previas ────────────────────── */

    // 1️⃣ Traer el préstamo base
    $prestamoBase = Prestamo::findOrFail($id);

    // 2️⃣ Último item del mismo usuario y número de préstamo
    $ultimoItem = Prestamo::where('numero_prestamo', $prestamoBase->numero_prestamo)
                  ->where('user_id',        $prestamoBase->user_id)
                  ->max('item_prestamo');

    if (!$ultimoItem) {
        return back()->with('error', 'No hay datos para renovar.');
    }

    // 3️⃣ Grupo de registros del último item
    $grupoAnterior = Prestamo::where('numero_prestamo', $prestamoBase->numero_prestamo)
                    ->where('user_id',        $prestamoBase->user_id)
                    ->where('item_prestamo',  $ultimoItem)
                    ->orderBy('id')
                    ->get();

    if ($grupoAnterior->isEmpty()) {
        return back()->with('error', 'No se encontraron registros anteriores para renovar.');
    }

    /* ──────────────────── 2. Datos derivados para la renovación ──────────────────── */

    $fechaInicio    = $grupoAnterior->first()->fecha_fin;             // nueva fecha_inicio
    $fechaFin       = Carbon::parse($fechaInicio)->addDays(28);       // nueva fecha_fin
    $interesACobrar = $grupoAnterior->first()->interes_pagar;         // interés del grupo
    $nuevoItem      = $ultimoItem + 1;                                // siguiente item_prestamo

    /* ───────────── 3. Verificar que exista un período de caja activo ───────────── */

    $hoy     = Carbon::today();
    $periodo = CajaPeriodo::whereDate('periodo_inicio', '<=', $hoy)
               ->whereDate('periodo_fin',    '>=', $hoy)
               ->first();                         // 👈 sin “Fail”

    if (!$periodo) {
        return back()->with(
            'error',
            'No existe un período de caja activo que cubra la fecha ' . $hoy->format('d/m/Y') . '.'
        );
    }

    /* ────────────────────────── 4. Transacción ────────────────────────── */

    DB::transaction(function () use (
        $periodo,
        $grupoAnterior,
        $fechaInicio,
        $fechaFin,
        $interesACobrar,
        $nuevoItem
    ) {
        /* ---------- Caja ---------- */
        $periodo->lockForUpdate();                       // 🔒 bloquea la fila mientras dure la tx
        $periodo->increment('saldo_actual', $interesACobrar);

        $periodo->movimientos()->create([
            'monto'            => $interesACobrar,
            'saldo_resultante' => $periodo->saldo_actual,
            'tipo'             => 'ingreso',
            'descripcion'      => 'Renovación de préstamo',
        ]);

        /* ---------- Préstamos ---------- */
        $grupoAnterior->first()->update(['descripcion' => 'renovar']);

        foreach ($grupoAnterior as $index => $registro) {
            Prestamo::create([
                'user_id'             => $registro->user_id,
                'numero_prestamo'     => $registro->numero_prestamo,
                'item_prestamo'       => $nuevoItem,
                'n_junta'             => $registro->n_junta,
                'monto'               => $registro->monto,
                'interes'             => $registro->interes,
                'interes_pagar'       => $registro->interes_pagar,
                'porcentaje_penalidad'=> $registro->porcentaje_penalidad,
                'estado'              => 'aprobado',
                'descripcion'         => $index === 0 ? null : $registro->descripcion,
                'fecha_inicio'        => $fechaInicio,
                'fecha_fin'           => $fechaFin,
            ]);
        }
    });

    return back()->with('success', 'Préstamo renovado correctamente.');
}

public function aplicarDiferencia(Request $request, $id)
{
    /* ───────── 1. Datos de entrada ───────── */

    $prestamoBase     = Prestamo::findOrFail($id);
    $diferenciaMonto  = (float) $request->input('diferencia_monto');
    $grupo            = $request->input('grupo');        // número de préstamo
    $item             = (int)  $request->input('item');
    $filasCanceladas  = array_filter(                    // elimina IDs vacíos
        explode(',', $request->input('filas_canceladas')),
        fn ($v) => trim($v) !== ''
    );

    /* ───────── 2. Grupo original ───────── */

    $grupoAnterior = Prestamo::where('numero_prestamo', $grupo)
                    ->where('user_id',       $prestamoBase->user_id)
                    ->where('item_prestamo', $item)
                    ->orderBy('id')
                    ->get();

    if ($grupoAnterior->isEmpty()) {
        return back()->with('error', 'No se encontraron registros.');
    }

    $primerPrestamo = $grupoAnterior->first();

    if ($diferenciaMonto > $primerPrestamo->monto) {
        return back()->with('error', 'El monto de diferencia no puede ser mayor al monto original.');
    }

    /* ───────── 3. Verificar período de caja activo ───────── */

    $hoy     = Carbon::today();
    $periodo = CajaPeriodo::whereDate('periodo_inicio', '<=', $hoy)
               ->whereDate('periodo_fin', '>=', $hoy)
               ->first();          // 👉 sin “Fail”

    if (!$periodo) {
        return back()->with(
            'error',
            'No existe un período de caja activo para la fecha ' . $hoy->format('d/m/Y') . '.'
        );
    }

    /* ───────── 4. Transacción ───────── */

    DB::transaction(function () use (
        $periodo,
        $grupoAnterior,
        $primerPrestamo,
        $prestamoBase,
        $diferenciaMonto,
        $filasCanceladas
    ) {
        /* 4.1 — Caja */
        $periodo->lockForUpdate();           // 🔒
        $interesBase       = $primerPrestamo->interes_pagar;
        $interesCancelados = $filasCanceladas
                             ? Prestamo::whereIn('id', $filasCanceladas)
                               ->where('user_id', $prestamoBase->user_id)
                               ->sum('interes_pagar')
                             : 0;
        $totalIngresoCaja  = $diferenciaMonto + $interesBase + $interesCancelados;

        $periodo->increment('saldo_actual', $totalIngresoCaja);

        $periodo->movimientos()->create([
            'monto'            => $totalIngresoCaja,
            'saldo_resultante' => $periodo->saldo_actual,
            'tipo'             => 'ingreso',
            'descripcion'      => 'Aplicación de diferencia',
        ]);

        /* 4.2 — Préstamos */

        // a) Marcar filas canceladas
        if ($filasCanceladas) {
            Prestamo::whereIn('id', $filasCanceladas)
                ->where('user_id', $prestamoBase->user_id)
                ->update(['descripcion' => 'cancelado']);
        }

        // b) Nuevo item_prestamo
        $nuevoItem    = $primerPrestamo->item_prestamo + 1;
        $fechaInicio  = $primerPrestamo->fecha_fin;
        $fechaFin     = Carbon::parse($fechaInicio)->addDays(28);

        // Marcar la fila base
        $primerPrestamo->update(['descripcion' => 'diferencia']);

        foreach ($grupoAnterior as $index => $registro) {
            if (in_array($registro->id, $filasCanceladas)) {
                continue; // saltar filas canceladas
            }

            $nuevoMonto  = $registro->monto;
            $descripcion = $registro->descripcion;

            if ($index === 0) {                     // sólo la primera recibe la diferencia
                $nuevoMonto  = max(0, $registro->monto - $diferenciaMonto);
                $descripcion = '';                  // limpia descripción
            }

            Prestamo::create([
                'user_id'              => $registro->user_id,
                'numero_prestamo'      => $registro->numero_prestamo,
                'item_prestamo'        => $nuevoItem,
                'n_junta'              => $registro->n_junta,
                'monto'                => $nuevoMonto,
                'interes'              => $registro->interes,
                'interes_pagar'        => $nuevoMonto * ($registro->interes / 100),
                'porcentaje_penalidad' => $registro->porcentaje_penalidad,
                'estado'               => 'aprobado',
                'descripcion'          => $descripcion,
                'fecha_inicio'         => $fechaInicio,
                'fecha_fin'            => $fechaFin,
            ]);
        }
    });

    return back()->with('success', 'Diferencia aplicada correctamente.');
}

public function cancelar($id)
{
    /* ───────── 1. Datos base del préstamo ───────── */

    $prestamo = Prestamo::findOrFail($id);
    $numero   = $prestamo->numero_prestamo;
    $userId   = $prestamo->user_id;
    $fechaPago = now();

    /* ───────── 2. Verificar período de caja activo ───────── */

    $hoy     = Carbon::today();
    $periodo = CajaPeriodo::whereDate('periodo_inicio', '<=', $hoy)
               ->whereDate('periodo_fin',    '>=', $hoy)
               ->first();          // 👉 sin “Fail”

    if (!$periodo) {
        return back()->with(
            'error',
            'No existe un período de caja activo para la fecha ' . $hoy->format('d/m/Y') . '.'
        );
    }

    /* ───────── 3. Transacción ───────── */

    DB::transaction(function () use (
        $prestamo, $numero, $userId, $fechaPago, $periodo
    ) {

        /* 3.1 — Calcular montos */
$capital     = $prestamo->monto;          // monto de ESTA fila
$interesBase = $prestamo->interes_pagar;  // interés de ESTA fila

/* ► 2. Otras penalidades: solo su interes_pagar */
$interesPenalidades = Prestamo::where('numero_prestamo', $numero)
    ->where('user_id', $userId)
    ->whereIn('descripcion', ['penalidad', 'penalidad1', 'penalidad2'])
    ->where('id', '!=', $prestamo->id)   // excluye ESTA fila
    ->sum('interes_pagar');

/* ► 3. Total a ingresar en caja */
$totalIngresoCaja = $capital + $interesBase + $interesPenalidades;

        /* 3.2 — Caja */

        $periodoBloqueado = CajaPeriodo::whereKey($periodo->id)
                            ->lockForUpdate()
                            ->first();             // 🔒 bloqueado

        $periodoBloqueado->increment('saldo_actual', $totalIngresoCaja);

        $periodoBloqueado->movimientos()->create([
            'monto'            => $totalIngresoCaja,
            'saldo_resultante' => $periodoBloqueado->saldo_actual,
            'tipo'             => 'ingreso',
            'descripcion'      => 'Cancelación de préstamo',
        ]);

        /* 3.3 — Actualizar préstamos */

        // Marcar todas las filas de ese préstamo como pagadas
        Prestamo::where('numero_prestamo', $numero)
            ->where('user_id', $userId)
            ->update([
                'estado'     => 'pagado',
                'fecha_pago' => $fechaPago,
            ]);

        // Marcar la fila original como “cancelado”
        $prestamo->update(['descripcion' => 'cancelado']);
    });

    return back()->with('success', 'El préstamo fue cancelado correctamente.');
}


// generar prestamo para el cliente
public function crearDesdeAdmin()
{
    if (
        ! Auth::check() ||                // no ha iniciado sesión
        ! Auth::user()->is_admin ||       // no es admin
        ! Auth::user()->ge_prestamo      
    ) {
        abort(403, 'Acceso no autorizado.');
    }

    $usuarios = User::where('is_admin', 0)->get();

    return view('admin.generar_prestamo', compact('usuarios'));
}

public function storeDesdeAdmin(Request $request)   // ← pon el nombre que usarás en la ruta
{
    // 1. Verificación de permisos (igual que en crearDesdeAdmin)
    if (
        !Auth::check() ||
        !Auth::user()->is_admin ||
        !Auth::user()->ge_prestamo
    ) {
        abort(403, 'Acceso no autorizado.');
    }

    // 2. Validar entrada
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'monto'   => 'required|numeric|min:1',
    ]);

    // 3. Usuario al que se le generará el préstamo
    $user = User::findOrFail($request->user_id);

    // 4. Calcular número de préstamo correlativo para ese usuario
    $ultimoPrestamo = Prestamo::where('user_id', $user->id)
                              ->orderByDesc('numero_prestamo')
                              ->first();

    $numeroPrestamo = $ultimoPrestamo ? $ultimoPrestamo->numero_prestamo + 1 : 1;

    // 5. Crear el préstamo (puedes envolver en DB::transaction si registras caja)
    Prestamo::create([
        'user_id'         => $user->id,
        'numero_prestamo' => $numeroPrestamo,
        'item_prestamo'   => 1,
        'monto'           => $request->monto,
        'estado'          => 'pendiente',
    ]);

    // 6. Redirigir (usa back() si prefieres)
    return redirect()->back()    // o ->route('admin.prestamos.create')
           ->with('success', 'Préstamo generado correctamente para '.$user->name.'.');
}


public function storeCajaPeriodo(Request $request)
{
    $request->validate([
        'monto_inicial'  => 'required|numeric|min:0',
        'periodo_inicio' => 'required|date',
        'periodo_fin'    => 'required|date|after_or_equal:periodo_inicio',
    ]);

    /* ─────────────────────────────────────────────────────────────
     |  Anti-solape: se considera conflicto sólo si ambos períodos
     |  comparten al menos un día.  Ejemplo:
     |      Existente: 01-06-25 → 28-06-25
     |      Nuevo:     28-06-25 → 30-06-25   ❌  (colisión)
     |      Nuevo:     29-06-25 → 30-06-25   ✅  (sin colisión)
     * ────────────────────────────────────────────────────────────*/
    $yaExiste = CajaPeriodo::where('periodo_inicio', '<',  $request->periodo_fin)  // <  fin nuevo
                           ->where('periodo_fin',   '>',  $request->periodo_inicio) // >  inicio nuevo
                           ->exists();

    if ($yaExiste) {
        return back()->withErrors(
            'Ya existe un período que se superpone con ese rango de fechas.'
        );
    }

    DB::transaction(function () use ($request) {
        CajaPeriodo::create([
            'monto_inicial'  => $request->monto_inicial,
            'saldo_actual'   => $request->monto_inicial,
            'periodo_inicio' => $request->periodo_inicio,
            'periodo_fin'    => $request->periodo_fin,
        ]);
    });

    return back()->with('success', 'Período de caja creado correctamente.');
}


}