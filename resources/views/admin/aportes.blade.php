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
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #17a2b8;
            --pending-color: #fd7e14;
        }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            min-height: 100vh;
        }
        
        /* Sidebar styles (mantenidos intactos) */
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
        
        /* Contenido principal mejorado */
        .main-content {
            margin-left: 280px;
            padding: 1rem;
            transition: margin-left 0.3s ease;
            background: transparent;
        }
        
        /* Toast Notifications Flotantes */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        
        .toast-custom {
            min-width: 350px;
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            backdrop-filter: blur(10px);
        }
        
        .toast-success {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.95), rgba(32, 201, 151, 0.95));
            color: white;
            border-left: 4px solid #28a745;
        }
        
        .toast-error {
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.95), rgba(231, 76, 60, 0.95));
            color: white;
            border-left: 4px solid #dc3545;
        }
        
        .toast-header-custom {
            background: transparent;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            color: white;
        }
        
        .toast-body-custom {
            background: transparent;
            color: white;
            font-weight: 500;
        }
        
        /* Cards y contenedores */
        .content-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: none;
        }
        
        .section-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 15px 15px 0 0;
            margin: -1.5rem -1.5rem 1.5rem -1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            flex-wrap: wrap;
        }
        
        .section-header h2, .section-header h3 {
            margin: 0;
            font-weight: 600;
            font-size: 1.25rem;
        }
        
        .section-header i {
            font-size: 1.25rem;
        }
        
        /* Tablas mejoradas y responsive */
        .table-container {
            overflow-x: auto;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 1rem;
        }
        
        .enhanced-table {
            border: none;
            margin-bottom: 0;
            min-width: 800px;
        }
        
        .enhanced-table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .enhanced-table thead th {
            border: none;
            padding: 0.75rem 0.5rem;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }
        
        .enhanced-table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .enhanced-table tbody tr:hover {
            background-color: #f8f9ff;
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .enhanced-table tbody td {
            padding: 0.75rem 0.5rem;
            vertical-align: middle;
            border: none;
            font-size: 0.9rem;
        }
        
        /* Estados de pago mejorados - estados en minúsculas */
        .status-badge {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            white-space: nowrap;
        }
        
        .status-pagado {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
        }
        
        .status-pendiente {
            background: linear-gradient(135deg, #fd7e14, #ffc107);
            color: white;
            box-shadow: 0 2px 8px rgba(253, 126, 20, 0.3);
        }
        
        /* Filas con estados - estados en minúsculas */
        .row-pagado {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.08), rgba(32, 201, 151, 0.08));
            border-left: 3px solid var(--success-color);
        }
        
        .row-pendiente {
            background: linear-gradient(135deg, rgba(253, 126, 20, 0.08), rgba(255, 193, 7, 0.08));
            border-left: 3px solid var(--pending-color);
        }
        
        /* Botones mejorados y responsive */
        .btn-enhanced {
            border-radius: 20px;
            padding: 0.6rem 1.2rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
            font-size: 0.85rem;
        }
        
        .btn-enhanced:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        }
        
        .btn-primary-enhanced {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-success-enhanced {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }
        
        .btn-warning-enhanced {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
            color: white;
        }
        
        .btn-danger-enhanced {
            background: linear-gradient(135deg, #dc3545, #e74c3c);
            color: white;
        }
        
        /* Formularios mejorados y responsive */
        .form-enhanced {
            background: #f8f9ff;
            border-radius: 15px;
            padding: 1.5rem;
            border: 2px solid #e9ecef;
            margin-bottom: 1.5rem;
        }
        
        .form-enhanced .form-control, .form-enhanced .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 0.6rem 0.8rem;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }
        
        .form-enhanced .form-control:focus, .form-enhanced .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        /* Modales mejorados */
        .modal-content-enhanced {
            border-radius: 20px;
            border: none;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        
        .modal-header-enhanced {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 20px 20px 0 0;
            border-bottom: none;
            padding: 1.2rem 1.5rem;
        }
        
        .modal-header-enhanced .btn-close {
            filter: invert(1);
        }
        
        /* Badges de período */
        .period-badge {
            background: linear-gradient(135deg, #17a2b8, #20c997);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }
        
        /* Cliente info responsive */
        .client-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }
        
        .client-number {
            font-size: 0.75rem;
            padding: 0.2rem 0.5rem;
        }
        
        .client-name {
            font-size: 0.8rem;
            color: #6c757d;
        }
        
        /* Scroll suave */
        html {
            scroll-behavior: smooth;
        }
        
        /* Highlight para sección activa */
        .section-highlight {
            animation: highlightSection 2s ease-in-out;
        }
        
        @keyframes highlightSection {
            0% { box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.7); }
            50% { box-shadow: 0 0 0 10px rgba(102, 126, 234, 0.3); }
            100% { box-shadow: 0 0 0 0 rgba(102, 126, 234, 0); }
        }
        
        /* Responsive mejoras */
        @media (max-width: 1200px) {
            .enhanced-table {
                min-width: 700px;
            }
            
            .enhanced-table thead th,
            .enhanced-table tbody td {
                padding: 0.5rem 0.3rem;
                font-size: 0.8rem;
            }
        }
        
        @media (max-width: 992px) {
            .main-content {
                padding: 0.75rem;
            }
            
            .content-card {
                padding: 1rem;
                margin-bottom: 1.5rem;
            }
            
            .section-header {
                margin: -1rem -1rem 1rem -1rem;
                padding: 0.75rem 1rem;
            }
            
            .section-header h2, .section-header h3 {
                font-size: 1.1rem;
            }
            
            .toast-container {
                right: 10px;
                left: 10px;
            }
            
            .toast-custom {
                min-width: auto;
                width: 100%;
            }
        }
        
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
                padding: 0.5rem;
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
            
            .content-card {
                padding: 0.75rem;
                margin-bottom: 1rem;
            }
            
            .section-header {
                margin: -0.75rem -0.75rem 0.75rem -0.75rem;
                padding: 0.75rem;
                flex-direction: column;
                text-align: center;
                gap: 0.5rem;
            }
            
            .enhanced-table {
                min-width: 600px;
            }
            
            .enhanced-table thead th,
            .enhanced-table tbody td {
                padding: 0.4rem 0.2rem;
                font-size: 0.75rem;
            }
            
            .status-badge {
                padding: 0.3rem 0.6rem;
                font-size: 0.7rem;
            }
            
            .btn-enhanced {
                padding: 0.5rem 1rem;
                font-size: 0.8rem;
            }
            
            .form-enhanced {
                padding: 1rem;
            }
            
            .client-info {
                align-items: flex-start;
            }
            
            .client-number {
                font-size: 0.7rem;
                align-self: flex-start;
            }
            
            .client-name {
                font-size: 0.75rem;
            }
            
            .toast-container {
                top: 10px;
                right: 10px;
                left: 10px;
            }
        }
        
        @media (max-width: 576px) {
            .enhanced-table {
                min-width: 500px;
            }
            
            .enhanced-table thead th,
            .enhanced-table tbody td {
                padding: 0.3rem 0.15rem;
                font-size: 0.7rem;
            }
            
            .section-header h2, .section-header h3 {
                font-size: 1rem;
            }
            
            .btn-group .btn {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
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

<!-- Toast Container para mensajes flotantes -->
<div class="toast-container" id="toastContainer"></div>

<!-- Botón para móviles -->
<button class="mobile-menu-toggle" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>

<!-- Sidebar (mantenido intacto) -->
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

<!-- Contenido principal mejorado -->
<div class="main-content">
    
    {{-- Sección de Clientes --}}
    <div class="content-card">
        <div class="section-header">
            <i class="fas fa-users"></i>
            <h2>Gestión de Clientes</h2>
        </div>
        
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 gap-3">
            <p class="text-muted mb-0">
                <i class="fas fa-info-circle me-2"></i>
                Administra la información de los clientes registrados
            </p>
            <button class="btn btn-primary-enhanced btn-enhanced" data-bs-toggle="modal" data-bs-target="#modalAgregarCliente">
                <i class="fas fa-plus me-2"></i>Agregar Cliente
            </button>
        </div>

        <div class="table-container">
            <table class="table enhanced-table">
                <thead>
                    <tr>
                        <th><i class="fas fa-hashtag me-1"></i>#</th>
                        <th><i class="fas fa-id-card me-1"></i>N° Cliente</th>
                        <th><i class="fas fa-user me-1"></i>Nombre</th>
                        <th><i class="fas fa-user me-1"></i>Apellido</th>
                        <th class="text-center"><i class="fas fa-cogs me-1"></i>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($aportes as $cliente)
                        <tr>
                            <td><strong>{{ $loop->iteration }}</strong></td>
                            <td>
                                <span class="badge bg-primary client-number">{{ $cliente->numero_cliente }}</span>
                            </td>
                            <td>{{ $cliente->nombre }}</td>
                            <td>{{ $cliente->apellido }}</td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <button class="btn btn-warning-enhanced btn-sm" 
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEditar{{ $cliente->id }}"
                                            title="Editar cliente">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger-enhanced btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEliminar{{ $cliente->id }}"
                                            title="Eliminar cliente">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <i class="fas fa-users fa-2x text-muted mb-2"></i>
                                <p class="text-muted mb-0">No hay clientes registrados</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Sección de Crear Aportes --}}
    <div class="content-card">
        <div class="section-header">
            <i class="fas fa-calendar-plus"></i>
            <h3>Crear Aportes por Período</h3>
        </div>
        
        @if ($periodos->isEmpty())
            <div class="alert alert-warning-enhanced alert-enhanced">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Atención:</strong> No hay un período de caja activo para generar aportes.
            </div>
        @else
            @isset($periodoActual)
                <div class="period-badge">
                    <i class="fas fa-calendar-check"></i>
                    Período Actual: {{ $periodoActual->periodo_inicio->format('d/m/Y') }} – {{ $periodoActual->periodo_fin->format('d/m/Y') }}
                </div>
            @endisset

            <form action="{{ route('pago-reportes.generar-por-periodo') }}" method="POST" class="form-enhanced">
                @csrf
                <div class="row g-3">
                    <div class="col-12 col-md-8">
                        <label class="form-label fw-bold" for="caja_periodo_id">
                            <i class="fas fa-calendar me-2"></i>Seleccionar Período de Caja
                        </label>
                        <select name="caja_periodo_id" id="caja_periodo_id" class="form-select" required>
                            <option value="" disabled @empty($periodoActual) selected @endempty>
                                — Selecciona el período vigente —
                            </option>
                            @foreach ($periodos as $p)
                                <option value="{{ $p->id }}"
                                        @selected(isset($periodoActual) && $periodoActual->id === $p->id)>
                                    {{ $p->periodo_inicio->format('d/m/Y') }} – {{ $p->periodo_fin->format('d/m/Y') }}
                                    @if (isset($periodoActual) && $periodoActual->id === $p->id)
                                        (Actual)
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-success-enhanced btn-enhanced w-100">
                            <i class="fas fa-plus-circle me-2"></i>Generar Pagos
                        </button>
                    </div>
                </div>
            </form>
        @endif
    </div>

    {{-- Sección de Historial de Pagos --}}
    @php
    $pagosAgrupados = $pagos
        ->sortBy('fecha_pago')
        ->groupBy(fn ($p) => \Carbon\Carbon::parse($p->fecha_pago)->toDateString());
    @endphp

    <div class="content-card">
        <div class="section-header">
            <i class="fas fa-history"></i>
            <h3>Historial de Pagos por Semana</h3>
        </div>
        
        @forelse ($pagosAgrupados as $fecha => $grupo)
            @php
                $fechaCarbon = \Carbon\Carbon::parse($fecha);
                $cajaPeriodo = $grupo->first()->cajaPeriodo;
                $inicioPeriodo = \Carbon\Carbon::parse($cajaPeriodo->periodo_inicio)->startOfWeek(\Carbon\Carbon::SUNDAY);
                $semana = $inicioPeriodo->diffInWeeks($fechaCarbon) + 1;
            @endphp

            <div class="mb-4">
                <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center mb-3 gap-2">
                    <h4 class="text-primary mb-0">
                        <i class="fas fa-calendar-week me-2"></i>
                        Semana {{ $semana }}
                    </h4>
                    <span class="badge bg-info">{{ $fechaCarbon->format('d/m/Y') }}</span>
                </div>

                <form action="{{ route('pago-reportes.pagar') }}" method="POST" class="form-enhanced">
                    @csrf
                    <input type="hidden" name="semana_desde" value="{{ $fechaCarbon->toDateString() }}">

                    <div class="row g-2 align-items-end mb-3">
                        <div class="col-12 col-sm-6 col-md-4">
                            <label for="monto-{{ $loop->index }}" class="form-label fw-bold">
                                <i class="fas fa-dollar-sign me-1"></i>Monto (S/)
                            </label>
                            <input type="number" step="0.01" min="0" class="form-control"
                                   id="monto-{{ $loop->index }}" name="monto" placeholder="0.00" required>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <button type="submit" class="btn btn-success-enhanced btn-enhanced w-100">
                                <i class="fas fa-credit-card me-1"></i>Pagar Seleccionados
                            </button>
                        </div>
                    </div>

                    <div class="table-container">
                        <table class="table enhanced-table">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <input type="checkbox" class="form-check-input" id="check-all-{{ $loop->index }}">
                                    </th>
                                    <th><i class="fas fa-hashtag me-1"></i>#</th>
                                    <th><i class="fas fa-user me-1"></i>Cliente</th>
                                    <th><i class="fas fa-calendar me-1"></i>Período</th>
                                    <th><i class="fas fa-dollar-sign me-1"></i>Monto</th>
                                    <th><i class="fas fa-calendar-day me-1"></i>F. Pago</th>
                                    <th><i class="fas fa-info-circle me-1"></i>Estado</th>
                                    <th><i class="fas fa-clock me-1"></i>Registro</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($grupo->sortBy('aporte.numero_cliente') as $i => $pago)
                                    <tr class="{{ $pago->estado === 'pagado' ? 'row-pagado' : 'row-pendiente' }}">
                                        <td class="text-center">
                                            <input type="checkbox" class="form-check-input fila-{{ $loop->parent->index }}"
                                                   name="pagos[]" value="{{ $pago->id }}"
                                                   {{ $pago->estado === 'pagado' ? 'disabled' : '' }}>
                                        </td>
                                        <td><strong>{{ $i + 1 }}</strong></td>
                                        <td>
                                            <div class="client-info">
                                                <span class="badge bg-primary client-number">{{ $pago->aporte->numero_cliente ?? '—' }}</span>
                                                <small class="client-name">{{ $pago->aporte->nombre }} {{ $pago->aporte->apellido }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <small>
                                                {{ \Carbon\Carbon::parse($pago->cajaPeriodo->periodo_inicio)->format('d/m/Y') }}
                                                <br>
                                                {{ \Carbon\Carbon::parse($pago->cajaPeriodo->periodo_fin)->format('d/m/Y') }}
                                            </small>
                                        </td>
                                        <td><strong>S/ {{ number_format($pago->monto, 2) }}</strong></td>
                                        <td>{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }}</td>
                                        <td>
                                            @if($pago->estado === 'pagado')
                                                <span class="status-badge status-pagado">
                                                    <i class="fas fa-check-circle"></i>
                                                    Pagado
                                                </span>
                                            @else
                                                <span class="status-badge status-pendiente">
                                                    <i class="fas fa-clock"></i>
                                                    Pendiente
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <small>{{ $pago->created_at->format('d/m/Y H:i') }}</small>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>

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
            <div class="text-center py-4">
                <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                <p class="text-muted">No hay pagos registrados en el sistema</p>
            </div>
        @endforelse
    </div>

    {{-- Sección de Historial por Período --}}
    <div class="content-card" id="historial-periodo">
        <div class="section-header">
            <i class="fas fa-search"></i>
            <h3>Consultar Historial por Período</h3>
        </div>
        
        <form method="GET" action="{{ route('aportes.index') }}" class="form-enhanced">
            <div class="row g-3">
                <div class="col-12 col-md-8">
                    <label for="periodo" class="form-label fw-bold">
                        <i class="fas fa-calendar-alt me-2"></i>Seleccionar Período
                    </label>
                    <select name="periodo" id="periodo" class="form-select" required>
                        <option value="" disabled {{ !$periodoHist ? 'selected' : '' }}>
                            — Selecciona un período —
                        </option>
                        @foreach ($periodos as $per)
                            <option value="{{ $per->id }}"
                                    {{ old('periodo', optional($periodoHist)->id) == $per->id ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::parse($per->periodo_inicio)->format('d/m/Y') }}
                                —
                                {{ \Carbon\Carbon::parse($per->periodo_fin)->format('d/m/Y') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-4 d-flex align-items-end">
                    <button class="btn btn-primary-enhanced btn-enhanced w-100">
                        <i class="fas fa-search me-2"></i>Ver Historial
                    </button>
                </div>
            </div>
        </form>

        @if(!$periodoHist && !request()->has('periodo'))
            <div class="text-center py-4 mt-3">
                <i class="fas fa-info-circle fa-2x text-muted mb-3"></i>
                <p class="text-muted">Selecciona un período y pulsa "Ver historial" para consultar los pagos</p>
            </div>
        @endif

        @if(!$periodoHist && request()->has('periodo'))
            <div class="alert alert-warning-enhanced alert-enhanced mt-3">
                <i class="fas fa-exclamation-triangle me-2"></i>
                El período seleccionado no se encontró. Por favor, intenta con otro.
            </div>
        @endif

        @if($periodoHist)
            @php
                $historialAgrupado = $pagosHist
                    ->sortBy('fecha_pago')
                    ->groupBy(fn ($p) => \Carbon\Carbon::parse($p->fecha_pago)->toDateString());
            @endphp

            <div class="mt-3">
                <div class="period-badge">
                    <i class="fas fa-calendar-check"></i>
                    Historial del {{ \Carbon\Carbon::parse($periodoHist->periodo_inicio)->format('d/m/Y') }}
                    al {{ \Carbon\Carbon::parse($periodoHist->periodo_fin)->format('d/m/Y') }}
                </div>

                @forelse ($historialAgrupado as $fecha => $grupo)
                    @php
                        $fechaCarbon = \Carbon\Carbon::parse($fecha);
                        $inicioPeriodo = \Carbon\Carbon::parse($periodoHist->periodo_inicio)->startOfWeek(\Carbon\Carbon::SUNDAY);
                        $semana = $inicioPeriodo->diffInWeeks($fechaCarbon) + 1;
                    @endphp

                    <div class="mb-4">
                        <h5 class="text-info mb-3">
                            <i class="fas fa-calendar-week me-2"></i>
                            Semana {{ $semana }} — {{ $fechaCarbon->format('d/m/Y') }}
                        </h5>

                        <div class="table-container">
                            <table class="table enhanced-table">
                                <thead>
                                    <tr>
                                        <th><i class="fas fa-hashtag me-1"></i>#</th>
                                        <th><i class="fas fa-user me-1"></i>Cliente</th>
                                        <th><i class="fas fa-calendar me-1"></i>Período</th>
                                        <th><i class="fas fa-dollar-sign me-1"></i>Monto</th>
                                        <th><i class="fas fa-calendar-day me-1"></i>F. Pago</th>
                                        <th><i class="fas fa-info-circle me-1"></i>Estado</th>
                                        <th><i class="fas fa-clock me-1"></i>Registro</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($grupo->sortBy('aporte.numero_cliente') as $i => $pago)
                                        <tr class="{{ $pago->estado === 'pagado' ? 'row-pagado' : 'row-pendiente' }}">
                                            <td><strong>{{ $i + 1 }}</strong></td>
                                            <td>
                                                <div class="client-info">
                                                    <span class="badge bg-primary client-number">{{ $pago->aporte->numero_cliente ?? '—' }}</span>
                                                    <small class="client-name">{{ $pago->aporte->nombre }} {{ $pago->aporte->apellido }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <small>
                                                    {{ \Carbon\Carbon::parse($pago->cajaPeriodo->periodo_inicio)->format('d/m/Y') }}
                                                    <br>
                                                    {{ \Carbon\Carbon::parse($pago->cajaPeriodo->periodo_fin)->format('d/m/Y') }}
                                                </small>
                                            </td>
                                            <td><strong>S/ {{ number_format($pago->monto, 2) }}</strong></td>
                                            <td>{{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }}</td>
                                            <td>
                                                @if($pago->estado === 'pagado')
                                                    <span class="status-badge status-pagado">
                                                        <i class="fas fa-check-circle"></i>
                                                        Pagado
                                                    </span>
                                                @else
                                                    <span class="status-badge status-pendiente">
                                                        <i class="fas fa-clock"></i>
                                                        Pendiente
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <small>{{ $pago->created_at->format('d/m/Y H:i') }}</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <i class="fas fa-receipt fa-2x text-muted mb-3"></i>
                        <p class="text-muted">No hay pagos registrados en este período</p>
                    </div>
                @endforelse
            </div>
        @endif
    </div>

</div>

<!-- Modales mejorados -->
<!-- Modal Agregar Cliente -->
<div class="modal fade" id="modalAgregarCliente" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('aportes.store') }}">
            @csrf
            <div class="modal-content modal-content-enhanced">
                <div class="modal-header modal-header-enhanced">
                    <h5 class="modal-title" id="modalLabel">
                        <i class="fas fa-user-plus me-2"></i>Nuevo Cliente
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="numero_cliente" class="form-label fw-bold">
                            <i class="fas fa-id-card me-2"></i>Número de Cliente
                        </label>
                        <input type="text" name="numero_cliente" id="numero_cliente" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-bold">
                            <i class="fas fa-user me-2"></i>Nombre
                        </label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellido" class="form-label fw-bold">
                            <i class="fas fa-user me-2"></i>Apellido
                        </label>
                        <input type="text" name="apellido" id="apellido" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success-enhanced btn-enhanced">
                        <i class="fas fa-save me-2"></i>Guardar
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modales de Editar -->
@foreach ($aportes as $cliente)
<div class="modal fade" id="modalEditar{{ $cliente->id }}" tabindex="-1" aria-labelledby="lblEditar{{ $cliente->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content modal-content-enhanced" action="{{ route('aportes.update', $cliente->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-header modal-header-enhanced">
                <h5 class="modal-title" id="lblEditar{{ $cliente->id }}">
                    <i class="fas fa-edit me-2"></i>Editar Cliente
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-id-card me-2"></i>Número Cliente
                    </label>
                    <input type="text" name="numero_cliente" class="form-control" value="{{ $cliente->numero_cliente }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-user me-2"></i>Nombre
                    </label>
                    <input type="text" name="nombre" class="form-control" value="{{ $cliente->nombre }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-user me-2"></i>Apellido
                    </label>
                    <input type="text" name="apellido" class="form-control" value="{{ $cliente->apellido }}" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary-enhanced btn-enhanced">
                    <i class="fas fa-save me-2"></i>Guardar Cambios
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancelar
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach

<!-- Modales de Eliminar -->
@foreach ($aportes as $cliente)
<div class="modal fade" id="modalEliminar{{ $cliente->id }}" tabindex="-1" aria-labelledby="lblEliminar{{ $cliente->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content modal-content-enhanced" action="{{ route('aportes.destroy', $cliente->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-header modal-header-enhanced bg-danger">
                <h5 class="modal-title" id="lblEliminar{{ $cliente->id }}">
                    <i class="fas fa-trash me-2"></i>Eliminar Cliente
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                <p class="mb-3">¿Estás seguro que deseas eliminar a:</p>
                <h5 class="text-danger">{{ $cliente->nombre }} {{ $cliente->apellido }}</h5>
                <p class="text-muted small">Esta acción no se puede deshacer</p>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger-enhanced btn-enhanced">
                    <i class="fas fa-trash me-2"></i>Eliminar
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancelar
                </button>
            </div>
        </form>
    </div>
</div>
@endforeach

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('show');
    }

    // Función para mostrar toast notifications
    function showToast(message, type = 'success') {
        const toastContainer = document.getElementById('toastContainer');
        const toastId = 'toast-' + Date.now();
        
        const toastHtml = `
            <div class="toast toast-custom toast-${type}" id="${toastId}" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000">
                <div class="toast-header toast-header-custom">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                    <strong class="me-auto">${type === 'success' ? 'Éxito' : 'Error'}</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body toast-body-custom">
                    ${message}
                </div>
            </div>
        `;
        
        toastContainer.insertAdjacentHTML('beforeend', toastHtml);
        
        const toastElement = document.getElementById(toastId);
        const toast = new bootstrap.Toast(toastElement);
        toast.show();
        
        // Remover el toast del DOM después de que se oculte
        toastElement.addEventListener('hidden.bs.toast', function () {
            toastElement.remove();
        });
    }

    // Mostrar toasts para mensajes de sesión
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('success'))
            showToast('{{ session('success') }}', 'success');
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                showToast('{{ $error }}', 'error');
            @endforeach
        @endif

        // Scroll automático a la sección de historial si hay un período seleccionado
        @if($periodoHist)
            setTimeout(function() {
                const historialSection = document.getElementById('historial-periodo');
                if (historialSection) {
                    historialSection.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'start' 
                    });
                    
                    // Agregar efecto de highlight
                    historialSection.classList.add('section-highlight');
                    setTimeout(function() {
                        historialSection.classList.remove('section-highlight');
                    }, 2000);
                }
            }, 500);
        @endif
    });
</script>

</body>
</html>
