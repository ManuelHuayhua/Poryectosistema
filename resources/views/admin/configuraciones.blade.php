<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Usuario - Configuraciones</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap y FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>

           

        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --sidebar-bg: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
            --success-gradient: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
            --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --danger-gradient: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            --card-shadow: 0 10px 30px rgba(0,0,0,0.1);
            --hover-shadow: 0 15px 40px rgba(0,0,0,0.15);
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
            box-shadow: 2px 0 20px rgba(0,0,0,0.1);
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
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
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }

        .user-avatar i {
            font-size: 2rem;
            color: white;
        }

        .user-name {
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
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
            border-radius: 12px;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s;
        }

        .nav-link:hover::before {
            left: 100%;
        }

        .nav-link:hover, .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            transform: translateX(8px) scale(1.02);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .nav-link i {
            margin-right: 1rem;
            font-size: 1.1rem;
        }

        .main-content {
            margin-left: 280px;
            padding: 2rem;
            transition: margin-left 0.3s ease;
            min-height: 100vh;
        }

        .page-header {
            background: white;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
        }

        .page-title {
            margin: 0;
            color: #2c3e50;
            font-weight: 700;
            font-size: 2rem;
        }

        .page-subtitle {
            color: #7f8c8d;
            margin: 0.5rem 0 0 0;
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .card:hover {
            box-shadow: var(--hover-shadow);
            transform: translateY(-5px);
        }

        .card-header {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 1.5rem 2rem;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .card-body {
            padding: 2rem;
        }

        .btn {
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            transition: all 0.5s;
            transform: translate(-50%, -50%);
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-primary {
            background: var(--primary-gradient);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }

        .btn-success {
            background: var(--success-gradient);
            box-shadow: 0 4px 15px rgba(86, 171, 47, 0.4);
        }

        .btn-warning {
            background: var(--warning-gradient);
            box-shadow: 0 4px 15px rgba(240, 147, 251, 0.4);
        }

        .btn-danger {
            background: var(--danger-gradient);
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
        }

        .form-control {
            border-radius: 12px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            transform: scale(1.02);
        }

        .table {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
        }

        .table thead th {
            background: var(--primary-gradient);
            color: white;
            border: none;
            padding: 1rem;
            font-weight: 600;
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-color: #f8f9fa;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
            transform: scale(1.01);
        }

        .alert {
            border-radius: 15px;
            padding: 1rem 1.5rem;
            border: none;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
        }

        .stats-card {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
            text-align: center;
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            font-size: 1.5rem;
            color: white;
        }

        .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        .modal-header {
            background: var(--primary-gradient);
            color: white;
            border: none;
            border-radius: 20px 20px 0 0;
        }

        .modal-body {
            padding: 2rem;
        }

        .form-floating label {
            color: #6c757d;
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

             /* funciona para que el menu se despligue en movile */
               .sidebar {
    overflow-y: auto;            /* permite el scroll vertical */
    -webkit-overflow-scrolling: touch; /* scroll suave en iOS */
}

/* Opción 2: fija el header y desplaza solo los enlaces */
.sidebar-nav {
    max-height: calc(100vh - 200px); /* ajusta 160 px al alto real del header */
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
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
                padding: 0.75rem 1rem;
                border-radius: 12px;
                cursor: pointer;
                box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            }

            .page-title {
                font-size: 1.5rem;
            }

            .card-body {
                padding: 1.5rem;
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
         <div class="nav-item">
        <a href="{{ route('indexAdmin') }}" class="nav-link">
            <i class="fas fa-home"></i><span>Inicio</span>
        </a>
    </div>
     <div class="nav-item">
        <a href="{{ route('admin.graficos') }}" class="nav-link">
            <i class="fas fa-chart-bar"></i><span>Gráficos</span>
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
        <a href="{{ route('admin.configuraciones') }}" class="nav-link active">
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
            <a href="{{ route('reporte.general') }}" class="nav-link">
                <i class="fas fa-chart-line"></i><span>Reporte General</span>
        </a>
        </div>


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
    <div class="container-fluid">
        <!-- Header de la página -->
        <div class="page-header animate-fade-in">
  <div class="row align-items-center">
    <!-- Título -->
    <div class="col-12 col-md-8 mb-3 mb-md-0">
      <h1 class="page-title">
        <i class="fas fa-cogs me-2"></i>Configuraciones
      </h1>
      <p class="page-subtitle">Gestiona las configuraciones del sistema</p>
    </div>

    <!-- Botón -->
    <div class="col-12 col-md-4 text-md-end">
      <button class="btn btn-primary btn-lg w-100 w-md-auto" data-bs-toggle="modal" data-bs-target="#configModal">
        <i class="fas fa-plus me-2"></i>Nueva Configuración
      </button>
    </div>
  </div>
</div>

        <!-- Estadísticas -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stats-card animate-fade-in">
                    <div class="stats-icon" style="background: var(--success-gradient);">
                        <i class="fas fa-list"></i>
                    </div>
                    <h3>{{ count($configuraciones ?? []) }}</h3>
                    <p class="text-muted">Total Configuraciones</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card animate-fade-in">
                    <div class="stats-icon" style="background: var(--warning-gradient);">
                        <i class="fas fa-percentage"></i>
                    </div>
                    <h3>{{ number_format($configuraciones->avg('interes') ?? 0, 2) }}%</h3>
                    <p class="text-muted">Interés Promedio</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card animate-fade-in">
                    <div class="stats-icon" style="background: var(--danger-gradient);">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h3>{{ number_format($configuraciones->avg('penalidad') ?? 0, 2) }}%</h3>
                    <p class="text-muted">Penalidad Promedio</p>
                </div>
            </div>
        </div>

        <!-- Mensajes -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show animate-fade-in" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show animate-fade-in" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong>¡Error!</strong> Por favor corrige los siguientes errores:
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Tabla de configuraciones -->
        <div class="card animate-fade-in">
            <div class="card-header">
                <i class="fas fa-table me-2"></i>Configuraciones Registradas
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag me-1"></i>ID</th>
                                <th><i class="fas fa-tag me-1"></i>Tipo Origen</th>
                                <th><i class="fas fa-percentage me-1"></i>Interés (%)</th>
                                <th><i class="fas fa-exclamation-triangle me-1"></i>Penalidad (%)</th>
                                <th><i class="fas fa-calendar me-1"></i>Fecha</th>
                                <th><i class="fas fa-tools me-1"></i>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($configuraciones as $config)
                                <tr>
                                    <td><span class="badge bg-primary">{{ $config->id }}</span></td>
                                    <td><strong>{{ $config->tipo_origen }}</strong></td>
                                    <td><span class="badge bg-success">{{ $config->interes }}%</span></td>
                                    <td><span class="badge bg-warning">{{ $config->penalidad }}%</span></td>
                                    <td><i class="fas fa-clock me-1"></i>{{ $config->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-warning" onclick="editConfig({{ $config->id }}, '{{ $config->tipo_origen }}', {{ $config->interes }}, {{ $config->penalidad }})" data-bs-toggle="modal" data-bs-target="#editModal">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" onclick="deleteConfig({{ $config->id }}, '{{ $config->tipo_origen }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">No hay configuraciones registradas.</p>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#configModal">
                                            <i class="fas fa-plus me-2"></i>Crear Primera Configuración
                                        </button>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

{{-- Alertas --}}
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $e) <div>{{ $e }}</div> @endforeach
    </div>
@endif

        {{-- Periodos de Caja --}}
{{-- Header de Caja --}}
{{-- Header de Caja --}}
{{-- Burbuja principal: Gestión de Períodos de Caja --}}
<div class="card mb-4">
  <div class="card-body">
    <div class="row align-items-center">
      <!-- Título -->
      <div class="col-12 col-md-8 mb-3 mb-md-0">
        <h4 class="mb-0">
          <i class="fas fa-cash-register me-2 text-primary"></i>
          Gestión de Períodos de Caja
        </h4>
      </div>

      <!-- Botón -->
      <div class="col-12 col-md-4 text-md-end">
        <button type="button" class="btn btn-primary w-100 w-md-auto" data-bs-toggle="modal" data-bs-target="#periodoModal">
          <i class="fas fa-plus me-1"></i> Configurar Período
        </button>
      </div>
    </div>
  </div>
</div>

{{-- 3 Burbujas informativas debajo --}}
@php
    $periodoActivo = $periodos->first(function($p) {
        return now()->between($p->periodo_inicio, $p->periodo_fin);
    });
    $ultimoPeriodo   = $periodos->sortByDesc('periodo_fin')->first();

    // Sugerir el día siguiente (si no hay períodos, queda vacío)
    $sugerido_inicio = $ultimoPeriodo
        ? \Carbon\Carbon::parse($ultimoPeriodo->periodo_fin)->addDay()->format('Y-m-d')
        : '';
@endphp

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card border-primary">
            <div class="card-body text-center py-3">
                <i class="fas fa-list-ol text-primary mb-2" style="font-size: 1.5rem;"></i>
                <h6 class="card-title mb-1">Total Períodos</h6>
                <span class="badge bg-primary fs-6">{{ $periodos->count() }}</span>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-success">
            <div class="card-body text-center py-3">
                <i class="fas fa-calendar-check text-success mb-2" style="font-size: 1.5rem;"></i>
                <h6 class="card-title mb-1">Período Actual</h6>
                @if($periodoActivo)
                    <small class="text-success fw-semibold">
                        {{ \Carbon\Carbon::parse($periodoActivo->periodo_inicio)->format('d/m/Y') }} - 
                        {{ \Carbon\Carbon::parse($periodoActivo->periodo_fin)->format('d/m/Y') }}
                    </small>
                @else
                    <span class="badge bg-warning">Sin período activo</span>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card border-info">
            <div class="card-body text-center py-3">
                <i class="fas fa-wallet text-info mb-2" style="font-size: 1.5rem;"></i>
                <h6 class="card-title mb-1">Saldo Actual</h6>
                @if($periodoActivo)
                    <span class="badge bg-info fs-6">S/ {{ number_format($periodoActivo->saldo_actual, 2) }}</span>
                @else
                    <span class="badge bg-secondary fs-6">S/ 0.00</span>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Alertas --}}
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $e) <div>{{ $e }}</div> @endforeach
    </div>
@endif

{{-- Tabla de Períodos --}}
@if($periodos->isEmpty())
    <div class="alert alert-info mt-4">Aún no se ha creado ningún período de caja.</div>
@else
    <div class="card mt-4">
        <div class="card-header fw-semibold">
            Períodos de Caja
        </div>

        <div class="table-responsive">
            <table class="table table-striped align-middle mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Período</th>
                        <th>Monto inicial (S/)</th>
                        <th>Saldo actual (S/)</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                        <th>Ingresar</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($periodos as $i => $p)
                        @php
                            $activo = now()->between($p->periodo_inicio, $p->periodo_fin);
                        @endphp
                        <tr class="{{ $activo ? 'table-success' : '' }}">
                            <td>{{ $i + 1 }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($p->periodo_inicio)->format('d/m/Y') }}
                                –
                                {{ \Carbon\Carbon::parse($p->periodo_fin)->format('d/m/Y') }}
                            </td>
                            <td>{{ number_format($p->monto_inicial, 2) }}</td>
                            <td>{{ number_format($p->saldo_actual, 2) }}</td>
                            <td>
                                <span class="badge {{ $activo ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $activo ? 'Activo' : 'Cerrado' }}
                                </span>
                            </td>
                            <td class="text-nowrap">
    <!-- Botón Editar -->
    <button class="btn btn-sm btn-warning"
        data-bs-toggle="modal"
        data-bs-target="#editarPeriodoModal"
        onclick="cargarDatosPeriodo({
            id: {{ $p->id }},
            monto_inicial: '{{ $p->monto_inicial }}',
            saldo_actual: '{{ $p->saldo_actual }}',
            periodo_inicio: '{{ \Carbon\Carbon::parse($p->periodo_inicio)->format('Y-m-d') }}',
            periodo_fin: '{{ \Carbon\Carbon::parse($p->periodo_fin)->format('Y-m-d') }}'
        })">
    <i class="fas fa-edit"></i>
</button>

    <!-- Botón Eliminar -->
    <button  class="btn btn-sm btn-danger"
         data-bs-toggle="modal"
         data-bs-target="#eliminarPeriodoModal"
         onclick="prepararEliminar({{ $p }})">
    <i class="fas fa-trash"></i>
</button>
    </form>
</td>
<td class="text-nowrap">
    {{-- Botones que ya tenías … --}}

    {{-- Nuevo botón: Ingresar fondos (sólo si el período está activo) --}}
    @if($activo)
<button class="btn btn-sm btn-success"
        data-bs-toggle="modal"
        data-bs-target="#ingresoModal"
        onclick="prepararIngreso({{ $p->id }})">
    <i class="fas fa-plus-circle"></i>
</button>
@endif
</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

{{-- Modal para crear período --}}
<div class="modal fade" id="periodoModal" tabindex="-1" aria-labelledby="periodoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="periodoModalLabel">
                    <i class="fas fa-cog me-2"></i>Configurar Período de Caja
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.configuracion.caja-periodo.store') }}" method="POST" id="periodoForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Monto inicial (S/)</label>
                        <input type="number" step="0.01" name="monto_inicial" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Período inicio</label>
                        <input type="date" name="periodo_inicio" class="form-control" required value="{{ $sugerido_inicio }}" @if($sugerido_inicio) min="{{ $sugerido_inicio }}" @endif>

                    </div>

                    <div class="mb-3">
                        <label class="form-label">Período fin</label>
                        <input type="date" name="periodo_fin" class="form-control" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="periodoForm" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Crear Período
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal editar periodo -->
<div class="modal fade" id="editarPeriodoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="editarPeriodoForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Editar Período</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="editar_id">

                    <div class="mb-3">
    <label class="form-label">Monto inicial (S/)</label>
    <input type="number" step="0.01"
           name="monto_inicial" id="editar_monto_inicial"
           class="form-control" required>
</div>

<div class="mb-3"><!-- NUEVO -->
    <label class="form-label">Saldo actual (S/)</label>
    <input type="number" step="0.01"
           name="saldo_actual" id="editar_saldo_actual"
           class="form-control" required>
</div>
                    <div class="mb-3">
                        <label class="form-label">Inicio</label>
                        <input type="date" name="periodo_inicio" id="editar_periodo_inicio" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Fin</label>
                        <input type="date" name="periodo_fin" id="editar_periodo_fin" class="form-control" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    function cargarDatosPeriodo(periodo) {
        document.getElementById('editar_id').value = periodo.id;
        document.getElementById('editar_monto_inicial').value = periodo.monto_inicial;
        document.getElementById('editar_saldo_actual').value  = periodo.saldo_actual;  
        document.getElementById('editar_periodo_inicio').value = periodo.periodo_inicio;
        document.getElementById('editar_periodo_fin').value = periodo.periodo_fin;

        // Cambiar acción del formulario
        document.getElementById('editarPeriodoForm').action = '/admin/configuracion/caja-periodo/' + periodo.id;
    }
</script>



<!-- Modal  ingresar mas monto -->
<div class="modal fade" id="ingresoModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="ingresoForm" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            <i class="fas fa-hand-holding-usd me-2"></i>Registrar ingreso
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Monto (S/)</label>
            <input id="ingreso_monto" name="monto" type="number"
                   step="0.01" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Descripción</label>
            <input id="ingreso_descripcion" name="descripcion"
                   class="form-control" placeholder="Ingreso desde caja">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary"
                  data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i>Guardar
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
<script>
function prepararIngreso(id) {
    // Coloca la URL correcta en el form
    document.getElementById('ingresoForm').action =
        `/admin/configuracion/caja-periodo/${id}/ingresar`;

    // Limpia campos
    document.getElementById('ingreso_monto').value = '';
    document.getElementById('ingreso_descripcion').value = '';
}
</script>


<!-- Modal eliminar período -->
<div class="modal fade" id="eliminarPeriodoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="eliminarPeriodoForm">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Eliminar Período
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <p class="mb-0">
                        ¿Estás seguro de que deseas eliminar el período<br>
                        <strong id="eliminar_periodo_rango"></strong>?
                    </p>
                    <small class="text-muted">Esta acción no se puede deshacer.</small>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i> Eliminar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    function prepararEliminar(periodo) {
        // Texto del rango
        const rango = `${formatear(periodo.periodo_inicio)} – ${formatear(periodo.periodo_fin)}`;
        document.getElementById('eliminar_periodo_rango').textContent = rango;

        // Acción del formulario
        document.getElementById('eliminarPeriodoForm').action =
            `/admin/configuracion/caja-periodo/${periodo.id}`;
    }

    // Formatea YYYY-MM-DD a DD/MM/YYYY
    function formatear(fechaIso) {
        const [y, m, d] = fechaIso.split('-');
        return `${d}/${m}/${y}`;
    }
</script>



<!-- Modal Nueva Configuración -->
<div class="modal fade" id="configModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Nueva Configuración</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.configuraciones.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="tipo_origen" name="tipo_origen" placeholder="Tipo Origen" required>
                                <label for="tipo_origen"><i class="fas fa-tag me-2"></i>Tipo Origen</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="number" step="0.01" class="form-control" id="interes" name="interes" placeholder="Interés" required>
                                <label for="interes"><i class="fas fa-percentage me-2"></i>Interés (%)</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="number" step="0.01" class="form-control" id="penalidad" name="penalidad" placeholder="Penalidad" required>
                                <label for="penalidad"><i class="fas fa-exclamation-triangle me-2"></i>Penalidad (%)</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Guardar Configuración
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Configuración -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">
          <i class="fas fa-edit me-2"></i>Editar Configuración
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <form id="editForm" method="POST">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 mb-3">
              <div class="form-floating">
                <input type="text" class="form-control" id="edit_tipo_origen" name="tipo_origen" placeholder="Tipo Origen" required>
                <label for="edit_tipo_origen"><i class="fas fa-tag me-2"></i>Tipo Origen</label>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-floating">
                <input type="number" step="0.01" class="form-control" id="edit_interes" name="interes" placeholder="Interés" required>
                <label for="edit_interes"><i class="fas fa-percentage me-2"></i>Interés (%)</label>
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-floating">
                <input type="number" step="0.01" class="form-control" id="edit_penalidad" name="penalidad" placeholder="Penalidad" required>
                <label for="edit_penalidad"><i class="fas fa-exclamation-triangle me-2"></i>Penalidad (%)</label>
              </div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-2"></i>Cancelar
          </button>
          <button type="submit" class="btn btn-warning">
            <i class="fas fa-save me-2"></i>Actualizar Configuración
          </button>
        </div>
      </form>
      
    </div>
  </div>
</div>
<!-- Modal Confirmar Eliminación -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Confirmar Eliminación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                <h5>¿Estás seguro?</h5>
                <p class="text-muted">Esta acción eliminará permanentemente la configuración <strong id="deleteConfigName"></strong>.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancelar
                </button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('show');
    }

   function editConfig(id, tipo_origen, interes, penalidad) {
    const updateUrl = `/admin/configuraciones/${id}/actualizar`;
    document.getElementById('editForm').action = updateUrl;
    document.getElementById('edit_tipo_origen').value = tipo_origen;
    document.getElementById('edit_interes').value = interes;
    document.getElementById('edit_penalidad').value = penalidad;

    const modalEl = document.getElementById('editModal');
    const editModal = bootstrap.Modal.getOrCreateInstance(modalEl);
    editModal.show();
}

// Asegurar limpieza de backdrop si por algún motivo se queda
document.addEventListener('DOMContentLoaded', function () {
    const editModalEl = document.getElementById('editModal');
    editModalEl.addEventListener('hidden.bs.modal', function () {
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(b => b.remove());
    });
});

    function deleteConfig(id, tipo_origen) {
    const deleteUrl = `/admin/configuraciones/${id}/eliminar`;
    document.getElementById('deleteForm').action = deleteUrl;
    document.getElementById('deleteConfigName').textContent = tipo_origen;

    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
    // Auto-hide alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    });

    // Form validation
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const inputs = form.querySelectorAll('input[required]');
            let valid = true;
            
            inputs.forEach(input => {
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    valid = false;
                } else {
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                }
            });
            
            if (!valid) {
                e.preventDefault();
                alert('Por favor completa todos los campos requeridos.');
            }
        });
    });
</script>






</body>
</html>