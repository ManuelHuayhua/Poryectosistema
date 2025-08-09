<div class="container">
    <h3>Cuadre de Caja</h3>

    {{-- Selector de periodo --}}
    <form method="GET" action="{{ route('admin.cuadracaja.index') }}" class="mb-3">
        <div class="row g-2 align-items-end">
            <div class="col-md-6">
                <label for="periodo_id">Periodo</label>
                <select name="periodo_id" id="periodo_id" class="form-control">
                    @foreach($periodos as $p)
                        <option value="{{ $p->id }}" {{ (isset($periodo) && $p->id == $periodo->id) ? 'selected' : '' }}>
                            {{ $p->periodo_inicio }} - {{ $p->periodo_fin }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary">Filtrar</button>
            </div>
        </div>
    </form>

    @if(session('mensaje'))
        <div class="alert alert-info">{{ session('mensaje') }}</div>
    @endif

    @if(isset($periodo))
    <div class="mb-3">
        <strong>Periodo:</strong> {{ $periodo->periodo_inicio }} a {{ $periodo->periodo_fin }}
    </div>

    <table class="table table-bordered mb-4">
        <tr>
            <th>Cantidad de Socios (únicos)</th>
            <td>{{ $cantidadSocios }}</td>
        </tr>
        <tr>
            <th>Total Aportes (pagados)</th>
            <td>{{ number_format($totalAportes, 2) }}</td>
        </tr>
    </table>

    <h5>Aporte por Socio</h5>
    <table class="table table-striped">
       <thead>
    <tr>
        <th>Id</th>
        <th>Cliente</th>
        <th>Nombre</th>
        <th>Monto Total</th>
        <th>Total Pagado</th>
  
    </tr>
</thead>
<tbody>
    @forelse($aportesPorSocio as $fila)
        <tr>
            <td>{{ $fila->aporte_id }}</td>
            <td>{{ $fila->numero_cliente }}</td>
            <td>{{ $fila->nombre }} {{ $fila->apellido }}</td>
            <td>{{ number_format($fila->total_monto, 2) }}</td>
            <td>{{ number_format($fila->total_pagado, 2) }}</td>
            
        </tr>
    @empty
        <tr><td colspan="6">No hay aportes en este periodo.</td></tr>
    @endforelse
</tbody>

    </table>
    @endif
</div>