 <!-- Bootstrap 5 y FontAwesome -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Usuario - Sidebar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap y FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --sidebar-bg: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
        }

        body {
            background: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
        }

        .sidebar {
            background: var(--sidebar-bg);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            z-index: 1000;
            transition: all 0.3s ease;
            color: white;
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            text-align: center;
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .user-avatar i {
            font-size: 2rem;
            color: white;
        }

        .user-name {
            color: white;
            font-weight: 600;
        }

        .user-welcome {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-item {
            margin: 0.5rem 1rem;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 1rem 1.5rem;
            border-radius: 10px;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transform: translateX(5px);
        }

        .nav-link i {
            margin-right: 1rem;
        }

        .main-content {
            margin-left: 280px;
            padding: 2rem;
            transition: margin-left 0.3s ease;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 100%;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 2rem;
            }

            .mobile-menu-toggle {
                display: block;
                position: fixed;
                top: 1rem;
                left: 1rem;
                z-index: 1100;
                background: var(--primary-gradient);
                color: white;
                border: none;
                padding: 0.5rem 1rem;
                border-radius: 5px;
                cursor: pointer;
            }
        }

        @media (min-width: 769px) {
            .mobile-menu-toggle {
                display: none;
            }
        }
    </style>
</head>
<body>

<!-- Botón para móviles -->
<button class="mobile-menu-toggle" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="user-avatar">
            <i class="fas fa-user"></i>
        </div>
        <div class="user-name">{{ Auth::user()->name }}</div>
        <div class="user-welcome">¡Bienvenido de nuevo!</div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-item ">
        <a href="{{ route('indexAdmin') }}" class="nav-link  active">
            <i class="fas fa-home"></i><span>Inicio</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="{{ route('admin.createuser') }}" class="nav-link">
            <i class="fas fa-users-cog"></i><span>Usuario y Roles</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="{{ route('admin.prestamos.pendientes') }}" class="nav-link">
            <i class="fas fa-file-download"></i><span>Descargar Contrato</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="{{ route('admin.configuraciones') }}" class="nav-link">
            <i class="fas fa-cogs"></i><span>Configurar</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="{{ route('admin.prestamos.crear') }}" class="nav-link">
            <i class="fas fa-file-signature"></i><span>Generar Préstamo</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="{{ route('admin.reporte.prestamos') }}" class="nav-link">
            <i class="fas fa-chart-line"></i><span>Generar Reportes</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="{{ route('admin.graficos') }}" class="nav-link">
            <i class="fas fa-chart-bar"></i><span>Gráficos</span>
        </a>
    </div>

    <!-- Más links aquí -->

        <div class="nav-item mt-auto">
            <a href="{{ route('logout') }}" class="nav-link"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i>
                <span>Cerrar sesión</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </nav>
</div>

<!-- Contenido principal -->
<div class="main-content">
   <div class="container mt-4">
    <h2>Bienvenido, {{ Auth::user()->name }}</h2>

    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

  {{-- En la vista, antes del accordion --}}
@if ($errors->has('caja'))
    <div class="alert alert-danger">
        {{ $errors->first('caja') }}
    </div>
@endif

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
 @if($hayNuevosPrestamos || $hayPrestamosPorVencer || $usuariosConCumpleanos->isNotEmpty())
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

@if($usuariosConCumpleanos->isNotEmpty())
    <hr>
    <p class="text-success fw-bold">🎉 Próximos cumpleaños:</p>
    <ul class="text-dark">
        @foreach($usuariosConCumpleanos as $user)
            <li>
                {{ $user->nombre }} — 
                Nació el <strong>{{ $user->fecha_nacimiento }}</strong> —
                Cumple <strong>{{ $user->edad }}</strong> año{{ $user->edad > 1 ? 's' : '' }} 
                @if($user->es_hoy)
                    <span class="text-danger fw-bold">🎂 ¡Hoy!</span>
                @else
                    (en {{ $user->dias_faltantes }} día{{ $user->dias_faltantes > 1 ? 's' : '' }})
                @endif
            </li>
        @endforeach
    </ul>
@endif

@if($hayQuierenPagar)
    <hr>
    <p class="text-primary fw-bold">💰 Usuarios que desean realizar un pago:</p>
    <ul class="text-dark">
        @foreach($prestamosNotificados as $prestamo)
    <li class="d-flex justify-content-between align-items-center mb-2">
        <div>
            {{ $prestamo->user->name }} {{ $prestamo->user->apellido_paterno ?? '' }} — 
            Préstamo N° <strong>{{ $prestamo->numero_prestamo }}</strong> — 
            Monto: <strong>S/. {{ number_format($prestamo->monto, 2) }}</strong>
        </div>
        <form action="{{ route('admin.marcar_leido', $prestamo->id) }}" method="POST" style="margin-left: 10px;">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-success">
                Leído
            </button>
        </form>
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
{{-- Préstamos Aprobados --}}
<h4 class="mt-5 text-success">Préstamos proximo a Vnecer</h4>

<div class="form-check mb-3">
    <input class="form-check-input" type="checkbox" id="mostrarTodosAprobados" onchange="togglePrestamosAprobados()">
    <label class="form-check-label" for="mostrarTodosAprobados">
        Mostrar todos los préstamos aprobados
    </label>
</div>

<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>N° Préstamo</th>
            <th>Item Prestamo</th>
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
    <tbody id="tbodyPrestamos">
        {{-- Se llena dinámicamente con JavaScript --}}
    </tbody>
</table>

{{-- Pasamos los datos como JSON desde Laravel --}}
<script>
    const prestamosFiltrados = @json($prestamosAprobados);
    const prestamosTodos = @json($todosPrestamosAprobados);
    const csrfToken = "{{ csrf_token() }}";
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        togglePrestamosAprobados(); // Mostrar por defecto los filtrados
    });

    function togglePrestamosAprobados() {
        const mostrarTodos = document.getElementById('mostrarTodosAprobados').checked;
        const prestamos = mostrarTodos ? prestamosTodos : prestamosFiltrados;
        renderPrestamos(prestamos);
    }

    function renderPrestamos(lista) {
        const tbody = document.getElementById('tbodyPrestamos');
        tbody.innerHTML = '';

        if (lista.length === 0) {
            tbody.innerHTML = '<tr><td colspan="12">No hay préstamos aprobados.</td></tr>';
            return;
        }

         const usuarios = {};
    lista.forEach(p => {
        if (!usuarios[p.user_id]) usuarios[p.user_id] = { user: p.user, prestamos: [] };
        usuarios[p.user_id].prestamos.push(p);
    });


       for (const userId in usuarios) {
        const { user, prestamos } = usuarios[userId];
        tbody.innerHTML += `
            <tr class="table-primary">
                <td colspan="13" class="fw-bold">
                    Usuario: ${user.name} ${user.apellido_paterno}
                </td>
            </tr>`;

        // 👉 agrupamos por número de préstamo
        const grupos = {};
        prestamos.forEach(p => {
            if (!grupos[p.numero_prestamo]) grupos[p.numero_prestamo] = [];
            grupos[p.numero_prestamo].push(p);
        });
           for (const num in grupos) {

            // 1️⃣  Ordenamos versiones: última primero
            grupos[num].sort((a, b) => b.item_prestamo - a.item_prestamo);

            grupos[num].forEach((p, idx) => {
                const esUltima = (idx === 0);                     // ← clave
               const grupoId = `prestamo_${p.user_id}_${p.numero_prestamo}`; // usado por los checks

                tbody.innerHTML += `
                    <tr ${p.descripcion === 'cancelado' ? 'class="table-secondary"' : ''}>
                        <td>${p.numero_prestamo}</td>
                        <td>${p.item_prestamo}</td>
                        <td>${user.name} ${user.apellido_paterno}</td>
                        <td>S/. ${Number(p.monto).toFixed(2)}</td>
                        <td>${p.interes}%</td>
                        <td>S/. ${Number(p.interes_pagar).toFixed(2)}</td>
                        <td>${formatDate(p.fecha_inicio)}</td>
                        <td>${formatDate(p.fecha_fin)}</td>
                        <td>${capitalize(p.estado)}</td>
                        <td>${p.descripcion ?? ''}</td>

                        <!-- Acciones, Diferencia y Cancelar SOLO para la última versión -->
                        <td>${esUltima ? acciones(p.id)              : ''}</td>
                        <td>${esUltima ? diferenciaInput(grupoId, p) : checkCancelado(grupoId, p)}</td>
                        <td>${esUltima ? botonCancelar(p.id)         : ''}</td>
                    </tr>`;
            });
        }
    }
}

    function acciones(id) {
        return `
            <form method="POST" action="/prestamos/${id}/penalidad" class="mb-1" onsubmit="return confirm('¿Aplicar penalidad a este préstamo?')">
                <input type="hidden" name="_token" value="${csrfToken}">
                <button type="submit" class="btn btn-danger btn-sm">Penalidad</button>
            </form>
            <form method="POST" action="/prestamos/${id}/renovar" class="mb-1" onsubmit="return confirm('¿Renovar este préstamo?')">
                <input type="hidden" name="_token" value="${csrfToken}">
                <button type="submit" class="btn btn-primary btn-sm">Renovar</button>
            </form>
        `;
    }

    function diferenciaInput(grupoId, p) {
    return `
        <form method="POST" action="/prestamos/${p.id}/diferencia" 
              onsubmit="guardarCancelados('${grupoId}'); return confirm('¿Aplicar esta diferencia?')">
            <input type="hidden" name="_token" value="${csrfToken}">
            <div class="input-group mb-1">
                <input type="number" 
                       name="diferencia_monto" 
                       step="0.01" 
                       max="${p.monto}" 
                       oninput="validarMonto(this)" 
                       placeholder="Máximo: S/. ${parseFloat(p.monto).toFixed(2)}"
                       class="form-control form-control-sm" required>
            </div>
            <input type="hidden" name="grupo" value="${p.numero_prestamo}">
            <input type="hidden" name="item" value="${p.item_prestamo}">
            <input type="hidden" name="filas_canceladas" id="cancelados_${grupoId}">
            <button type="submit" class="btn btn-warning btn-sm">Aplicar Diferencia</button>
        </form>
    `;
}

    function checkCancelado(grupoId, p) {
        return `
            <div class="form-check">
                <input type="checkbox" class="form-check-input check-cancelado" data-grupo="${grupoId}" value="${p.id}">
            </div>
        `;
    }

    function botonCancelar(id) {
        return `
            <form method="POST" action="/prestamos/${id}/cancelar" onsubmit="return confirm('¿Estás seguro de cancelar este préstamo completo?')">
                <input type="hidden" name="_token" value="${csrfToken}">
                <button type="submit" class="btn btn-outline-dark btn-sm">Cancelar</button>
            </form>
        `;
    }

    function formatDate(fecha) {
        const date = new Date(fecha);
        return date.toLocaleDateString('es-PE');
    }

    function capitalize(text) {
        return text.charAt(0).toUpperCase() + text.slice(1);
    }

    function guardarCancelados(grupoId) {
        let checkboxes = document.querySelectorAll('.check-cancelado[data-grupo="' + grupoId + '"]');
        let ids = [];

        checkboxes.forEach(cb => {
            if (cb.checked) {
                ids.push(cb.value);
            }
        });

        document.getElementById('cancelados_' + grupoId).value = ids.join(',');
    }
</script>

</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('show');
    }
</script>

<script>
    function validarMonto(input) {
        const max = parseFloat(input.max);
        const val = parseFloat(input.value);

        if (val > max) {
            alert('No puedes ingresar una diferencia mayor al monto disponible (S/. ' + max.toFixed(2) + ')');
            input.value = '';
        }
    }
</script>

</body>
</html>









 




