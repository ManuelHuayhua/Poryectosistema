 <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <h1>admin</h1>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>

                                <div class="container mt-4">
 <div class="container mt-4">
    <h2>Bienvenido, {{ Auth::user()->name }}</h2>

    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
<a href="{{ route('admin.createuser') }}" class="btn btn-primary">
    Crear nuevo usuario
</a>
    {{-- Préstamos pendientes --}}
    <h4 class="mt-5">Solicitudes de Préstamos Pendientes</h4>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Usuario</th>
                <th>Monto</th>
                <th>Fecha de solicitud</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($prestamosPendientes as $prestamo)
                <tr>
                    <td>{{ $prestamo->numero_prestamo }}</td>
                    <td>{{ $prestamo->user->name }}</td>
                    <td>S/. {{ number_format($prestamo->monto, 2) }}</td>
                    <td>{{ $prestamo->created_at->format('d/m/Y') }}</td>
                    <td>
                      <form action="{{ route('prestamo.aprobar', $prestamo->id) }}" method="POST">
    @csrf

    <!-- Selección de interés -->
    <label for="interes">Interés:</label>
    <select name="interes" required class="form-control">
        @foreach ($configuraciones as $config)
            <option value="{{ $config->interes }}">
                {{ $config->interes }}%
            </option>
        @endforeach
    </select>

    <!-- Selección de penalidad -->
    <label for="penalidad" class="mt-2">Penalidad:</label>
    <select name="penalidad" required class="form-control">
        @foreach ($configuraciones as $config)
            <option value="{{ $config->penalidad }}">
                {{ $config->penalidad }}%
            </option>
        @endforeach
    </select>

    <!-- Checkbox para indicar si es junta -->
<div class="form-check mt-2">
    <input class="form-check-input" type="checkbox" name="es_junta" id="es_junta" value="1" onchange="toggleJuntaSelect()">
    <label class="form-check-label" for="es_junta">
        ¿Es junta?
    </label>
</div>

<!-- Select de tipo_origen, oculto por defecto -->
<div id="tipo_origen_container" class="mt-2" style="display: none;">
    <label for="tipo_origen">Seleccione tipo de origen:</label>
    <select name="tipo_origen" class="form-control">
        @foreach($configuraciones as $config)
            @if($config->tipo_origen)
                <option value="{{ $config->tipo_origen }}">{{ $config->tipo_origen }}</option>
            @endif
        @endforeach
    </select>
</div>

<!-- Script para mostrar u ocultar el select -->
<script>
    function toggleJuntaSelect() {
        const checkbox = document.getElementById('es_junta');
        const container = document.getElementById('tipo_origen_container');
        container.style.display = checkbox.checked ? 'block' : 'none';
    }
</script>

    <button type="submit" class="btn btn-success mt-2">Aprobar</button>
</form>

                       <form action="{{ route('prestamo.rechazar', $prestamo->id) }}" method="POST" class="mt-2">
    @csrf
    <button type="submit" class="btn btn-danger">Rechazar</button>
</form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No hay préstamos pendientes.</td>
                </tr>
            @endforelse
        </tbody>
    </table>


   {{-- Préstamos Aprobados --}}
{{-- Préstamos Aprobados --}}
<h4 class="mt-5 text-success">Préstamos Aprobados</h4>

<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>ID</th>
            <th>N° Préstamo</th>
            <th>Usuario</th>
            <th>Monto</th>
            <th>Interés (%)</th>
            <th>Interés a Pagar</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Fecha de Pago</th>
            <th>Estado</th>
            <th>Descripción</th>
            <th>Acciones</th>
            <th>Diferencia</th>
            <th>Cancelar</th>
        </tr>
    </thead>
    <tbody>
    @php
        $grupos = $prestamosAprobados->groupBy('numero_prestamo');
    @endphp

    @forelse($grupos as $grupo)
        @foreach($grupo as $index => $prestamo)
        @php
            $grupoId = $prestamo->numero_prestamo . '_' . $prestamo->item_prestamo;
        @endphp
        <tr>
            <td>{{ $prestamo->id }}</td>
            <td>{{ $prestamo->numero_prestamo }}</td>
            <td>{{ $prestamo->user->name }}</td>
            <td>S/. {{ number_format($prestamo->monto, 2) }}</td>
            <td>{{ $prestamo->interes }}%</td>
            <td>S/. {{ number_format($prestamo->interes_pagar, 2) }}</td>
            <td>{{ \Carbon\Carbon::parse($prestamo->fecha_inicio)->format('d/m/Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($prestamo->fecha_fin)->format('d/m/Y') }}</td>
            <td>{{ optional($prestamo->fecha_pago)->format('d/m/Y') }}</td>
            <td>{{ ucfirst($prestamo->estado) }}</td>
            <td>{{ $prestamo->descripcion }}</td>
            <td>
                @if($index === 0)
                    {{-- Penalidad --}}
                    <form method="POST" action="{{ route('prestamos.penalidad', $prestamo->id) }}" class="mb-1">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">Penalidad</button>
                    </form>

                    {{-- Renovar --}}
                    <form action="{{ route('prestamos.renovar', $prestamo->id) }}" method="POST"
                        onsubmit="return confirm('¿Renovar este préstamo?')" class="mb-1">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-sm">Renovar</button>
                    </form>
                @endif
            </td>

            <td>
                @if($index === 0)
                    {{-- Aplicar Diferencia (solo en primera fila) --}}
                    <form method="POST" action="{{ route('prestamos.diferencia', $prestamo->id) }}" onsubmit="guardarCancelados('{{ $grupoId }}')">
                        @csrf
                        <div class="input-group mb-1">
                            <input type="number" name="diferencia_monto" step="0.01" placeholder="Monto a restar" class="form-control form-control-sm" required>
                        </div>

                        {{-- Hidden inputs --}}
                        <input type="hidden" name="grupo" value="{{ $prestamo->numero_prestamo }}">
                        <input type="hidden" name="item" value="{{ $prestamo->item_prestamo }}">
                        <input type="hidden" name="filas_canceladas" id="cancelados_{{ $grupoId }}">

                        <button type="submit" class="btn btn-warning btn-sm">Aplicar Diferencia</button>
                    </form>
                @else
                    {{-- Check de cancelación para otras filas --}}
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input check-cancelado" data-grupo="{{ $grupoId }}" value="{{ $prestamo->id }}">
                    </div>
                @endif
            </td>
            
            <td>
    @if($index === 0)
        {{-- Botón Cancelar --}}
        <form method="POST" action="{{ route('prestamos.cancelar', $prestamo->id) }}"
              onsubmit="return confirm('¿Estás seguro de cancelar este préstamo completo?')">
            @csrf
            <button type="submit" class="btn btn-outline-dark btn-sm">Cancelar</button>
        </form>
    @endif
</td>
        </tr>
        @endforeach
    @empty
        <tr>
            <td colspan="13">No hay préstamos aprobados.</td>
        </tr>
    @endforelse
    </tbody>
</table>

{{-- JavaScript para capturar los checkboxes marcados --}}
<script>
    function guardarCancelados(grupoId) {
        let checkboxes = document.querySelectorAll('.check-cancelado[data-grupo="' + grupoId + '"]');
        let ids = [];

        checkboxes.forEach(cb => {
            if (cb.checked) {
                ids.push(cb.value);
            }
        });

        // Asignar los valores a input hidden
        document.getElementById('cancelados_' + grupoId).value = ids.join(',');
    }
</script>





