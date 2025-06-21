 <!-- Bootstrap 5 y FontAwesome -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">



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

    <a href="{{ route('admin.createuser') }}" class="btn btn-primary mb-4">
        <i class="fas fa-user-plus"></i> Crear nuevo usuario
    </a>

    {{-- Préstamos pendientes --}}
    <h4 class="mt-4">Solicitudes de Préstamos Pendientes</h4>

    @if($prestamosPendientes->isEmpty())
        <div class="alert alert-secondary mt-3">No hay préstamos pendientes.</div>
    @else
        <div class="accordion mt-3" id="accordionPrestamos">
            @foreach($prestamosPendientes as $prestamo)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $prestamo->id }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $prestamo->id }}" aria-expanded="false" aria-controls="collapse{{ $prestamo->id }}">
                            #{{ $prestamo->numero_prestamo }} - {{ $prestamo->user->name }} | S/. {{ number_format($prestamo->monto, 2) }} | {{ $prestamo->created_at->format('d/m/Y') }}
                        </button>
                    </h2>
                    <div id="collapse{{ $prestamo->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $prestamo->id }}" data-bs-parent="#accordionPrestamos">
                        <div class="accordion-body">
                            {{-- FORMULARIO DE APROBACIÓN --}}
                            <form action="{{ route('prestamo.aprobar', $prestamo->id) }}" method="POST" class="border rounded p-3 mb-3 bg-light">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label for="fecha_inicio_{{ $prestamo->id }}">Fecha de inicio:</label>
                                        <input type="date" name="fecha_inicio" id="fecha_inicio_{{ $prestamo->id }}" class="form-control" required>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="fecha_fin_{{ $prestamo->id }}">Fecha de fin:</label>
                                        <input type="date" name="fecha_fin" id="fecha_fin_{{ $prestamo->id }}" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label for="interes_{{ $prestamo->id }}">Interés:</label>
                                        <select name="interes" id="interes_{{ $prestamo->id }}" class="form-control" required>
                                            @foreach ($configuraciones as $config)
                                                <option value="{{ $config->interes }}">{{ $config->interes }}%</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <label for="penalidad_{{ $prestamo->id }}">Penalidad:</label>
                                        <select name="penalidad" id="penalidad_{{ $prestamo->id }}" class="form-control" required>
                                            @foreach ($configuraciones as $config)
                                                <option value="{{ $config->penalidad }}">{{ $config->penalidad }}%</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" name="es_junta" id="es_junta_{{ $prestamo->id }}" value="1" onchange="toggleJuntaSelect({{ $prestamo->id }})">
                                    <label class="form-check-label" for="es_junta_{{ $prestamo->id }}">¿Es junta?</label>
                                </div>

                                <div id="tipo_origen_container_{{ $prestamo->id }}" class="mt-2" style="display: none;">
                                    <label for="tipo_origen_{{ $prestamo->id }}">Tipo de origen:</label>
                                    <select name="tipo_origen" id="tipo_origen_{{ $prestamo->id }}" class="form-control">
                                        @foreach($configuraciones as $config)
                                            @if($config->tipo_origen)
                                                <option value="{{ $config->tipo_origen }}">{{ $config->tipo_origen }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-success btn-sm mt-3">
                                    <i class="fas fa-check-circle"></i> Aprobar
                                </button>
                            </form>

                            {{-- FORMULARIO DE RECHAZO --}}
                            <form action="{{ route('prestamo.rechazar', $prestamo->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-times-circle"></i> Rechazar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- SCRIPT para mostrar u ocultar el select tipo_origen --}}
<script>
    function toggleJuntaSelect(id) {
        const checkbox = document.getElementById('es_junta_' + id);
        const container = document.getElementById('tipo_origen_container_' + id);
        container.style.display = checkbox.checked ? 'block' : 'none';
    }
</script>


  {{-- modal para identificar nuevos prestamos --}}
 @if($hayNuevosPrestamos || $hayPrestamosPorVencer)
<!-- Modal combinado para préstamos pendientes y por vencer -->
<div class="modal fade" id="notificacionesPrestamosModal" tabindex="-1" aria-labelledby="notificacionesPrestamosLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title" id="notificacionesPrestamosLabel">
          <i class="fas fa-bell"></i> Notificaciones de Préstamos
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        @if($hayNuevosPrestamos)
            <p class="text-dark">
                Tienes <strong>{{ $prestamosPendientes->count() }}</strong> solicitud{{ $prestamosPendientes->count() > 1 ? 'es' : '' }} de préstamo pendiente{{ $prestamosPendientes->count() > 1 ? 's' : '' }} por aprobar.
            </p>
            <p>Revisa la sección <strong>"Solicitudes de Préstamos Pendientes"</strong> para aprobar o rechazar.</p>
            <hr>
        @endif

        @if($hayPrestamosPorVencer)
            <p class="text-danger fw-bold">
                Hay <strong>{{ $prestamosPorVencer->count() }}</strong> préstamo{{ $prestamosPorVencer->count() > 1 ? 's' : '' }} aprobado{{ $prestamosPorVencer->count() > 1 ? 's' : '' }} que está{{ $prestamosPorVencer->count() > 1 ? 'n' : '' }} por vencer en los próximos 10 días:
            </p>
            <ul class="text-dark">
                @foreach($prestamosPorVencer as $prestamo)
                    <li>
                        Préstamo N° <strong>{{ $prestamo->numero_prestamo }}</strong> ({{ $prestamo->user->name }}) vence el 
                        <strong>{{ \Carbon\Carbon::parse($prestamo->fecha_fin)->format('d/m/Y') }}</strong>
                    </li>
                @endforeach
            </ul>
        @endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entendido</button>
      </div>
    </div>
  </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = new bootstrap.Modal(document.getElementById('notificacionesPrestamosModal'));
        modal.show();
    });
</script>
@endif


   {{-- Préstamos Aprobados --}}
{{-- Préstamos Aprobados --}}
<h4 class="mt-5 text-success">Préstamos Aprobados</h4>

<table class="table table-bordered mt-3">
    <thead>
        <tr>
        
            <th>N° Préstamo</th>
            <th>Usuario</th>
            <th>Monto</th>
            <th>Interés (%)</th>
            <th>Interés a Pagar</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
        

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
       
            <td>{{ $prestamo->numero_prestamo }}</td>
            <td>{{ $prestamo->user->name }}</td>
            <td>S/. {{ number_format($prestamo->monto, 2) }}</td>
            <td>{{ $prestamo->interes }}%</td>
            <td>S/. {{ number_format($prestamo->interes_pagar, 2) }}</td>
            <td>{{ \Carbon\Carbon::parse($prestamo->fecha_inicio)->format('d/m/Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($prestamo->fecha_fin)->format('d/m/Y') }}</td>
        
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





