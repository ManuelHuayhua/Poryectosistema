<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Aportes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="p-4">

{{-- Éxito --}}
@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

{{-- Error general --}}
@if ($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <div>• {{ $error }}</div>
        @endforeach
    </div>
@endif


<h2>Clientes (tabla APORTES)</h2>

                    <!-- Botón -->
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalAgregarCliente">
    + Agregar cliente
</button>

<table class="table table-bordered">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Número cliente</th>
            <th>Nombre</th>
            <th>Apellido</th>

        </tr>
    </thead>
    <tbody>
        @forelse ($aportes as $cliente)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $cliente->numero_cliente }}</td>
                <td>{{ $cliente->nombre }}</td>
                <td>{{ $cliente->apellido }}</td>
            
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">No hay registros en la tabla aportes.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<hr>

<!-- Modal -->
<div class="modal fade" id="modalAgregarCliente" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('aportes.store') }}">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Nuevo Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="numero_cliente" class="form-label">Número de cliente</label>
                    <input type="text" name="numero_cliente" id="numero_cliente" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input type="text" name="apellido" id="apellido" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Guardar</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </form>
  </div>
</div>


<h3>Crear aportes por período</h3>

@if ($periodos->isEmpty())
    <div class="alert alert-warning">
        No hay un período de caja activo.
    </div>
@else
    {{-- 🔖 Muestra un badge con el período activo (opcional, pero fiable en todos los navegadores) --}}
    @isset($periodoActual)
        <span class="badge bg-success mb-2">
            Período actual:
            {{ $periodoActual->periodo_inicio->format('d/m/Y') }} –
            {{ $periodoActual->periodo_fin->format('d/m/Y') }}
        </span>
    @endisset

    <form action="{{ route('pago-reportes.generar-por-periodo') }}"
          method="POST"
          class="row g-3">
        @csrf

        <div class="col-md-6">
            <label class="form-label" for="caja_periodo_id">Período de caja</label>

            <select name="caja_periodo_id"
                    id="caja_periodo_id"
                    class="form-select"
                    required>

                {{-- Placeholder si no hay período activo --}}
                <option value=""
                        disabled
                        @empty($periodoActual) selected @endempty>
                    — Selecciona el período vigente —
                </option>

                @foreach ($periodos as $p)
                    <option value="{{ $p->id }}"
                            {{-- Queda pre‑seleccionado si coincide con el período actual --}}
                            @selected(isset($periodoActual) && $periodoActual->id === $p->id)
                            {{-- Pinta de verde ese <option> (Bootstrap 5) --}}
                            class="{{ isset($periodoActual) && $periodoActual->id === $p->id
                                        ? 'bg-success text-white fw-bold'
                                        : '' }}">
                        {{ $p->periodo_inicio->format('d/m/Y') }} –
                        {{ $p->periodo_fin->format('d/m/Y') }}
                        @if (isset($periodoActual) && $periodoActual->id === $p->id)
                            (actual)
                        @endif
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-success">
                Generar pagos vacíos
            </button>
        </div>
    </form>
@endif

<hr>
@php
$pagosAgrupados = $pagos
    ->sortBy('fecha_pago')         //  ordena primero
    ->groupBy(fn ($p) => \Carbon\Carbon::parse($p->fecha_pago)->toDateString());
@endphp

<h3 class="mt-5">Historial de Pagos Registrados por Semana</h3>

@forelse ($pagosAgrupados as $fecha => $grupo)
    @php
        /* -----------------------------------------------
           Datos auxiliares para obtener nº de semana
        ----------------------------------------------- */
        $fechaCarbon   = \Carbon\Carbon::parse($fecha);
        $cajaPeriodo   = $grupo->first()->cajaPeriodo;
        $inicioPeriodo = \Carbon\Carbon::parse($cajaPeriodo->periodo_inicio)
                        ->startOfWeek(\Carbon\Carbon::SUNDAY);
        $semana        = $inicioPeriodo->diffInWeeks($fechaCarbon) + 1;
    @endphp

    <h4 class="mt-4 text-primary">
        Semana {{ $semana }} — ({{ $fechaCarbon->format('d/m/Y') }})
    </h4>

    {{-- ╔════════════════════════════════════════════╗
       ║  FORMULARIO ESPECÍFICO PARA ESTA SEMANA   ║
       ╚════════════════════════════════════════════╝ --}}
    <form action="{{ route('pago-reportes.pagar') }}" method="POST" class="mb-4">
        @csrf
        <input type="hidden" name="semana_desde" value="{{ $fechaCarbon->toDateString() }}">
        {{-- Si necesitas el periodo, envíalo también --}}
        {{-- <input type="hidden" name="caja_periodo_id" value="{{ $cajaPeriodo->id }}"> --}}

        {{-- ▸ Monto a aplicar a todas las filas seleccionadas --}}
        <div class="row g-2 align-items-end mb-2">
            <div class="col-auto">
                <label for="monto-{{ $loop->index }}"
                       class="col-form-label fw-semibold">
                    Monto a pagar (S/)
                </label>
            </div>
            <div class="col-auto">
                <input type="number"
                       step="0.01"
                       min="0"
                       class="form-control"
                       id="monto-{{ $loop->index }}"
                       name="monto"
                       placeholder="0.00"
                       required>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-cash-coin me-1"></i>Pagar seleccionados
                </button>
            </div>
        </div>

        {{-- ▸ Tabla de la semana --}}
        <table class="table table-sm table-bordered align-middle">
            <thead class="table-secondary text-center">
                <tr>
                    <th>
                        {{-- Checkbox “seleccionar todo” solo de esta tabla --}}
                        <input type="checkbox"
                               class="form-check-input"
                               id="check-all-{{ $loop->index }}">
                    </th>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Período</th>
                    <th>Monto (S/)</th>
                    <th>Fecha de pago</th>
                    <th>Estado</th>
                    <th>Registrado el</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupo->sortBy('aporte.numero_cliente') as $i => $pago)
                    <tr class="{{ $pago->estado === 'PAGADO' ? 'table-success' : '' }}">
                        <td class="text-center">
                            <input  type="checkbox"
                                    class="form-check-input fila-{{ $loop->parent->index }}"
                                    name="pagos[]"
                                    value="{{ $pago->id }}"
                                    {{ $pago->estado === 'PAGADO' ? 'disabled' : '' }}>
                        </td>
                        <td>{{ $i + 1 }}</td>
                        <td>
                            {{ $pago->aporte->numero_cliente ?? '—' }}<br>
                            <small>{{ $pago->aporte->nombre }} {{ $pago->aporte->apellido }}</small>
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($pago->cajaPeriodo->periodo_inicio)->format('d/m/Y') }}
                            -
                            {{ \Carbon\Carbon::parse($pago->cajaPeriodo->periodo_fin)->format('d/m/Y') }}
                        </td>
                        <td>{{ number_format($pago->monto, 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }}</td>
                        <td>{{ $pago->estado }}</td>
                        <td>{{ $pago->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </form>

    {{-- ▸ Script para el “seleccionar todo” (aislado por semana) --}}
    @push('scripts')
    <script>
        document.getElementById('check-all-{{ $loop->index }}')
            .addEventListener('change', e => {
                const checked = e.target.checked;
                document.querySelectorAll('.fila-{{ $loop->index }}')
                    .forEach(cb => cb.checked = checked && !cb.disabled);
            });
    </script>
    @endpush

@empty
    <p>No hay pagos registrados.</p>
@endforelse


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
