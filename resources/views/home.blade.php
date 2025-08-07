<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Usuario - Sidebar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="https://static.vecteezy.com/system/resources/previews/006/695/460/non_2x/money-dollar-bill-cartoon-illustration-free-vector.jpg" type="image/png">
    
    <!-- Bootstrap y FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --sidebar-bg: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
            --card-shadow: 0 8px 25px rgba(0,0,0,0.1);
            --border-radius: 12px;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            min-height: 100vh;
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

        /* Estilos mejorados para el contenido */
        .welcome-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: var(--border-radius);
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
        }

        .form-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
            border: none;
        }

        .form-control {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            border-radius: 8px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .table-container {
            background: white;
            border-radius: var(--border-radius);
            padding: 2rem;
            box-shadow: var(--card-shadow);
            overflow-x: auto;
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 1rem 0.75rem;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .table td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
        }

        .badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .btn-sm {
            padding: 0.4rem 1rem;
            border-radius: 6px;
            font-size: 0.8rem;
        }

        /* Modales mejorados */
        .modal-content {
            border-radius: var(--border-radius);
            border: none;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        .modal-header {
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            border-bottom: none;
            padding: 1.5rem 2rem;
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-footer {
            border-top: none;
            padding: 1.5rem 2rem;
        }

        .birthday-modal {
            background: linear-gradient(135deg, #ff6b6b 0%, #ffa726 100%);
        }

        .warning-modal {
            background: linear-gradient(135deg, #ffd54f 0%, #ff9800 100%);
        }

        .list-group-item {
            border-radius: 8px;
            border: 1px solid #e9ecef;
            margin-bottom: 0.5rem;
        }

        .alert {
            border-radius: var(--border-radius);
            border: none;
            padding: 1rem 1.5rem;
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
                padding: 1rem;
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
                box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            }

            .table-container {
                padding: 1rem;
            }

            .table th, .table td {
                padding: 0.5rem;
                font-size: 0.8rem;
            }

            .welcome-card {
                padding: 1.5rem;
            }

            .form-card {
                padding: 1.5rem;
            }
        }

        @media (min-width: 769px) {
            .mobile-menu-toggle {
                display: none;
            }
        }

        /* Animaciones */
        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .table-hover tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.05);
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
        <div class="nav-item">
            <a href="{{ route('home') }}" class="nav-link active"><i class="fas fa-home"></i><span>Inicio</span></a>
        </div>
        <div class="nav-item">
            <a href="{{ route('perfil') }}" class="nav-link "><i class="fas fa-user-circle"></i><span>Perfil</span></a>
        </div>
        <div class="nav-item">
            <a href="{{ route('reporteusuarios.index') }}" class="nav-link"><i class="fas fa-download"></i><span>Reporte</span></a>
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

@php
    use Carbon\Carbon;

    // Ordenar del préstamo más nuevo al más antiguo (por número)
    $prestamosOrdenados = $prestamos->sortByDesc('numero_prestamo');

    // ¿Es su cumpleaños hoy?
    $cumpleaniosHoy = $user->fecha_nacimiento
        ? Carbon::parse($user->fecha_nacimiento)->isSameDay(Carbon::today())
        : false;

    // Préstamos por vencer en los próximos 10 días
    $proximosVencer = $prestamosOrdenados->filter(function ($p) {
        return $p->fecha_fin && Carbon::parse($p->fecha_fin)
            ->between(Carbon::today(), Carbon::today()->addDays(10));
    });
@endphp

<!-- Contenido principal -->
<div class="main-content">
    <!-- Tarjeta de bienvenida -->
    <div class="welcome-card fade-in">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="mb-2">¡Hola, {{ Auth::user()->name }}!</h2>
                <p class="mb-0 opacity-75">Gestiona tus préstamos de manera fácil y segura</p>
            </div>
            <div class="col-md-4 text-end">
                <i class="fas fa-handshake fa-3x opacity-50"></i>
            </div>
        </div>
    </div>

    <!-- Alertas de éxito -->
    @if(session('success'))
        <div class="alert alert-success fade-in">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulario de solicitud -->
    <div class="form-card fade-in">
        <div class="row">
            <div class="col-md-8">
                <h4 class="mb-4">
                    <i class="fas fa-money-bill-wave text-primary me-2"></i>
                    Solicitar Préstamo
                </h4>
                
                <form action="{{ route('prestamo.store') }}" method="POST" id="prestamoForm">
                    @csrf
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="monto" class="form-label fw-semibold">¿Cuánto deseas solicitar?</label>
                                <div class="input-group">
                                    <span class="input-group-text">S/</span>
                                    <input type="number"
                                           name="monto"
                                           id="monto"
                                           class="form-control"
                                           required
                                           min="1"
                                           step="0.01"
                                           placeholder="0.00">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="button" class="btn btn-primary w-100" id="btnAbrirModal">
                                <i class="fas fa-paper-plane me-2"></i>
                                Solicitar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4 text-center d-none d-md-block">
                <i class="fas fa-coins fa-4x text-primary opacity-25"></i>
            </div>
        </div>
    </div>

        <!-- Tabla de préstamos -->
    <div class="table-container fade-in">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4">
            <h4 class="mb-2 mb-md-0">
                <i class="fas fa-list-alt text-primary me-2"></i>
                Historial de Préstamos
            </h4>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-info">{{ $prestamosOrdenados->count() }} préstamos</span>
                <button onclick="location.reload()" class="btn btn-sm btn-outline-primary" title="Actualizar página">
                    Actualizar <i class="fas fa-sync-alt"></i>
                </button>
            </div>
    


                
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag me-1"></i>N° Préstamo</th>
                            <th><i class="fas fa-tag me-1"></i>Último Ítem</th>
                            <th><i class="fas fa-money-bill me-1"></i>Monto</th>
                            <th><i class="fas fa-percentage me-1"></i>Interés</th>
                            <th><i class="fas fa-calculator me-1"></i>Interés a Pagar</th>
                            <th><i class="fas fa-info-circle me-1"></i>Estado</th>
                            <th><i class="fas fa-calendar-alt me-1"></i>Fecha Inicio</th>
                            <th><i class="fas fa-calendar-times me-1"></i>Fecha Fin</th>
                            <th><i class="fas fa-calendar-check me-1"></i>Fecha Pago</th>
                            <th><i class="fas fa-bell me-1"></i>Notificar</th>
                        </tr>
                    </thead>
                    <tbody>
                  @forelse($prestamos as $prestamo)
<tr class="{{ $prestamo->estado === 'cancelado' ? 'table-light' : '' }}">
    <td>
        <strong class="text-primary">#{{ $prestamo->numero_prestamo }}</strong><br>
        <button class="btn btn-sm btn-link text-decoration-underline" onclick="toggleDetalle('{{ $prestamo->numero_prestamo }}')">
            Ver detalle
        </button>
    </td>
    {{-- CAMBIO: usar item --}}
    <td>{{ $prestamo->item_prestamo }}</td>
    
    <td><strong>S/ {{ number_format($prestamo->monto, 2) }}</strong></td>
    <td>{{ $prestamo->interes }}%</td>
    <td><strong class="text-danger">S/ {{ number_format($prestamo->interes_pagar, 2) }}</strong></td>
    <td>
        <span class="badge bg-{{ $prestamo->estado == 'pendiente' ? 'warning' : ($prestamo->estado == 'cancelado' ? 'danger' : 'success') }}">
            {{ ucfirst($prestamo->estado) }}
        </span>
    </td>
    <td><small>{{ optional($prestamo->fecha_inicio)->format('d/m/Y') ?? '-' }}</small></td>
    <td><small>{{ optional($prestamo->fecha_fin)->format('d/m/Y') ?? '-' }}</small></td>
    <td>
        @if($prestamo->fecha_pago)
            <small class="text-success">
                <i class="fas fa-check me-1"></i>
                {{ \Carbon\Carbon::parse($prestamo->fecha_pago)->format('d/m/Y') }}
            </small>
        @else
            <small class="text-danger">
                <i class="fas fa-times me-1"></i>
                Sin pagar
            </small>
        @endif
    </td>
    <td>
        @if(!$prestamo->notificacion_pago)
            <form method="POST" action="{{ route('prestamos.notificar_pago', $prestamo->id) }}">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-bell me-1"></i>
                    Notificar
                </button>
            </form>
        @else
            <span class="badge bg-success">
                <i class="fas fa-check me-1"></i>
                Notificado
            </span>
        @endif
    </td>
</tr>
                       {{-- Fila oculta con el historial --}}
{{-- Fila oculta con historial --}}
<tr id="detalle-{{ $prestamo->numero_prestamo }}" style="display: none;">
    <td colspan="10">
        <div class="table-responsive">
            <table class="table table-bordered table-hover mt-2">
                <thead class="table-secondary">
                    <tr>
                        <th>Ítem</th>
                        <th>Monto</th>
                        <th>Interés</th>
                        <th>Interés a pagar</th>
                        <th>Fecha inicio</th>
                        <th>Fecha fin</th>
                        <th>Por pagar</th> <!-- NUEVA COLUMNA -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($historialPorNumero[$prestamo->numero_prestamo] ?? [] as $detalle)
                    <tr>
                        {{-- CAMBIO: usar item y formatear fechas --}}
                        <td>{{ $detalle->item_prestamo }}</td>
                        <td>S/. {{ number_format($detalle->monto, 2) }}</td>
                        <td>{{ $detalle->interes }}%</td>
                        <td>S/. {{ number_format($detalle->interes_pagar, 2) }}</td>
                        <td>{{ \Carbon\Carbon::parse($detalle->fecha_inicio)->format('d/m/Y') }}</td>
                        <td>{{ $detalle->fecha_fin ? \Carbon\Carbon::parse($detalle->fecha_fin)->format('d/m/Y') : '-' }}</td>
                        <td style="color: red; font-weight: bold;">Falta pagar</td> <!-- NUEVA COLUMNA -->
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </td>
</tr>
@empty



                            <tr>
                                <td colspan="10" class="text-center py-5">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No tienes préstamos registrados</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <script>
    function toggleDetalle(numero) {
        const fila = document.getElementById('detalle-' + numero);
        fila.style.display = fila.style.display === 'none' ? 'table-row' : 'none';
    }
</script>
<!-- Modal de confirmación -->
<div class="modal fade" id="confirmarPrestamoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="fas fa-question-circle me-2"></i>
                    Confirmar Solicitud
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-money-bill-wave fa-3x text-primary mb-3"></i>
                <h5>¿Estás seguro de solicitar este préstamo?</h5>
                <p class="text-muted">Monto solicitado:</p>
                <h4 class="text-primary">S/ <span id="montoConfirm">0.00</span></h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancelar
                </button>
                <button type="button" class="btn btn-primary" id="btnConfirmar">
                    <i class="fas fa-check me-2"></i>Confirmar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de cumpleaños -->
@if($cumpleaniosHoy)
    <div class="modal fade" id="cumpleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header birthday-modal text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-birthday-cake me-2"></i>
                        ¡Feliz Cumpleaños!
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <i class="fas fa-gift fa-4x text-warning mb-3"></i>
                    <h4>{{ $user->name }} {{ $user->apellido_paterno }}</h4>
                    <p class="text-muted">Todo el equipo te desea un día extraordinario lleno de alegría y éxitos</p>
                    <div class="mt-3">
                        <i class="fas fa-star text-warning mx-1"></i>
                        <i class="fas fa-star text-warning mx-1"></i>
                        <i class="fas fa-star text-warning mx-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Modal de préstamos por vencer -->
@if($proximosVencer->count())
    <div class="modal fade" id="vencimientoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header warning-modal text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Préstamos por Vencer
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <i class="fas fa-clock fa-3x text-warning"></i>
                    </div>
                    <p class="text-center">Tienes préstamos que vencen en los próximos 10 días:</p>
                    <div class="list-group list-group-flush">
                        @foreach($proximosVencer as $p)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Préstamo #{{ $p->numero_prestamo }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $p->item_prestamo }}</small>
                                </div>
                                <span class="badge bg-warning">
                                    {{ \Carbon\Carbon::parse($p->fecha_fin)->format('d/m/Y') }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('show');
}

document.getElementById('btnAbrirModal').addEventListener('click', () => {
    const monto = document.getElementById('monto').value.trim();

    if (!monto || parseFloat(monto) <= 0) {
        document.getElementById('monto').focus();
        return;
    }

    document.getElementById('montoConfirm').textContent = parseFloat(monto).toFixed(2);
    new bootstrap.Modal('#confirmarPrestamoModal').show();
});

document.getElementById('btnConfirmar').addEventListener('click', () => {
    document.getElementById('prestamoForm').submit();
});

document.addEventListener('DOMContentLoaded', () => {
    @if($cumpleaniosHoy)
        new bootstrap.Modal('#cumpleModal').show();
    @endif
    @if($proximosVencer->count())
        new bootstrap.Modal('#vencimientoModal').show();
    @endif
});
</script>

</body>
</html>