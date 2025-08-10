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
        .sidebar {
    overflow-y: auto;            /* permite el scroll vertical */
    -webkit-overflow-scrolling: touch; /* scroll suave en iOS */
}

/* Opción 2: fija el header y desplaza solo los enlaces */
.sidebar-nav {
    max-height: calc(100vh - 190px); /* ajusta 160 px al alto real del header */
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
            <a href="{{ route('reporte.general') }}" class="nav-link">
                <i class="fas fa-chart-line"></i><span>Reporte General</span>
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

     <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #f8fafc;
            --accent-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

     
        .main-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            margin: 1rem auto;
            padding: 0;
            overflow: hidden;
            max-width: 1100px;
        }

        .header-section {
            background: linear-gradient(135deg, var(--primary-color), #3b82f6);
            color: white;
            padding: 1.5rem 2rem;
            position: relative;
            overflow: hidden;
        }

        .header-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 50%);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-8px) rotate(180deg); }
        }

        .header-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            position: relative;
            z-index: 2;
        }

        .header-subtitle {
            opacity: 0.9;
            margin-top: 0.25rem;
            font-size: 0.9rem;
            position: relative;
            z-index: 2;
        }

        .content-section {
            padding: 1.5rem;
        }

        .filter-card {
            background: white;
            border-radius: 12px;
            padding: 1.25rem;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .filter-card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-1px);
        }

        .custom-select {
            border: 2px solid var(--border-color);
            border-radius: 8px;
            padding: 0.6rem 0.9rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: white;
        }

        .custom-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
            outline: none;
        }

        .btn-modern {
            background: linear-gradient(135deg, var(--primary-color), #3b82f6);
            border: none;
            border-radius: 8px;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            color: white;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
        }

        .btn-modern:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
            background: linear-gradient(135deg, #1d4ed8, var(--primary-color));
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.25rem;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-bottom: 0.75rem;
        }

        .stat-icon.socios {
            background: linear-gradient(135deg, #f59e0b, #f97316);
            color: white;
        }

        .stat-icon.aportes {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .stat-icon.interes {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
            color: white;
        }

        .stat-label {
            font-size: 0.8rem;
            color: var(--text-secondary);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0.25rem 0;
        }

        .table-card {
            background: white;
            border-radius: 12px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
            overflow: hidden;
            margin-bottom: 1.5rem;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-responsive::-webkit-scrollbar {
            height: 8px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary-color), #3b82f6);
            border-radius: 4px;
        }

        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #1d4ed8, var(--primary-color));
        }

        .table-header {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            padding: 1.25rem;
            border-bottom: 1px solid var(--border-color);
        }

        .table-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .modern-table {
            margin: 0;
            background: white;
            font-size: 0.9rem;
            min-width: 600px; /* Ancho mínimo para forzar scroll horizontal */
        }

        .modern-table thead th {
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            border: none;
            padding: 0.85rem;
            font-weight: 600;
            color: var(--text-primary);
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }

        .modern-table tbody td {
            padding: 0.85rem;
            border-top: 1px solid var(--border-color);
            vertical-align: middle;
        }

        .modern-table tbody tr {
            transition: all 0.2s ease;
        }

        .modern-table tbody tr:hover {
            background: rgba(37, 99, 235, 0.05);
        }

        .alert-modern {
            border: none;
            border-radius: 8px;
            padding: 0.85rem 1.25rem;
            margin-bottom: 1.25rem;
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            color: #1e40af;
            border-left: 3px solid var(--primary-color);
            font-size: 0.9rem;
        }

        .period-info {
            background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
            border: 1px solid #0ea5e9;
            border-radius: 8px;
            padding: 0.85rem;
            margin-bottom: 1.25rem;
            color: #0c4a6e;
            font-size: 0.9rem;
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 2.5rem;
            margin-bottom: 0.75rem;
            opacity: 0.5;
        }

        @media (max-width: 768px) {
            .main-container {
                margin: 0.5rem;
                border-radius: 12px;
            }
            
            .header-section {
                padding: 1rem 1.5rem;
            }
            
            .header-title {
                font-size: 1.5rem;
            }
            
            .header-subtitle {
                font-size: 0.85rem;
            }
            
            .content-section {
                padding: 1rem;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }
            
            .stat-card {
                padding: 1rem;
            }
            
            .stat-value {
                font-size: 1.25rem;
            }
            
            .modern-table {
                font-size: 0.8rem;
                min-width: 700px; /* Fuerza scroll horizontal en tablets */
            }
            
            .modern-table thead th,
            .modern-table tbody td {
                padding: 0.5rem 0.6rem;
                white-space: nowrap; /* Evita que el texto se corte */
            }
            
            .filter-card {
                padding: 1rem;
            }
            
            .btn-modern {
                padding: 0.6rem 1rem;
                font-size: 0.85rem;
            }
        }

        @media (max-width: 576px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .stat-card {
                text-align: center;
                padding: 0.85rem;
            }
            
            .modern-table {
                min-width: 500px; /* Scroll horizontal en móviles */
                font-size: 0.75rem;
            }
            
            .modern-table thead th,
            .modern-table tbody td {
                padding: 0.4rem 0.5rem;
            }
            
            .header-title {
                font-size: 1.3rem;
            }
            
            .stat-value {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 480px) {
            .main-container {
                margin: 0.25rem;
            }
            
            .modern-table {
                min-width: 450px; /* Mantiene scroll en pantallas muy pequeñas */
            }
        }
    </style>

  <div class="container-fluid">
        <div class="main-container">
            <!-- Header Section -->
            <div class="header-section">
                <h1 class="header-title">
                    <i class="fas fa-calculator me-3"></i>
                    Cuadre de Caja
                </h1>
                <p class="header-subtitle">Sistema de Control y Seguimiento Financiero</p>
            </div>

            <!-- Content Section -->
            <div class="content-section">
                <!-- Filter Card -->
                <div class="filter-card">
                    <form method="GET" action="{{ route('admin.cuadracaja.index') }}">
                        <div class="row g-3 align-items-end">
                            <div class="col-lg-8 col-md-7">
                                <label for="periodo_id" class="form-label fw-semibold">
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    Seleccionar Periodo
                                </label>
                                <select name="periodo_id" id="periodo_id" class="form-control custom-select">
                                    @foreach($periodos as $p)
                                        <option value="{{ $p->id }}" {{ (isset($periodo) && $p->id == $periodo->id) ? 'selected' : '' }}>
                                            {{ $p->periodo_inicio }} - {{ $p->periodo_fin }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4 col-md-5">
                                <button type="submit" class="btn btn-modern w-100">
                                    <i class="fas fa-filter me-2"></i>
                                    Aplicar Filtro
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Alert Messages -->
                @if(session('mensaje'))
                    <div class="alert-modern">
                        <i class="fas fa-info-circle me-2"></i>
                        {{ session('mensaje') }}
                    </div>
                @endif

                @if(isset($periodo))
                    <!-- Period Information -->
                    <div class="period-info">
                        <strong><i class="fas fa-clock me-2"></i>Periodo Activo:</strong> 
                        {{ $periodo->periodo_inicio }} a {{ $periodo->periodo_fin }}
                    </div>

                    <!-- Statistics Grid -->
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-icon socios">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-label">Socios Únicos</div>
                            <div class="stat-value">{{ number_format($cantidadSocios) }}</div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon aportes">
                                <i class="fas fa-wallet"></i>
                            </div>
                            <div class="stat-label">Total Aportes</div>
                            <div class="stat-value">S/ {{ number_format($totalAportes, 2) }}</div>
                        </div>
                        
                        <div class="stat-card">
                            <div class="stat-icon interes">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="stat-label">Interés Ganado</div>
                            <div class="stat-value">S/ {{ number_format($interesGanado, 2) }}</div>
                        </div>
                    </div>

                    <!-- Data Table -->
                    <div class="table-card">
                        <div class="table-header">
                            <h5 class="table-title">
                                <i class="fas fa-table"></i>
                                Detalle de Aportes por Socio
                            </h5>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table modern-table">
                                <thead>
                                    <tr>
                                        <th><i class="fas fa-hashtag me-1"></i>ID</th>
                                        <th><i class="fas fa-user me-1"></i>Cliente</th>
                                        <th><i class="fas fa-id-card me-1"></i>Nombre</th>
                                        <th><i class="fas fa-coins me-1"></i>Monto Total</th>
                                        <th><i class="fas fa-check-circle me-1"></i>Total Pagado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($aportesPorSocio as $fila)
                                        <tr>
                                            <td><span class="badge bg-primary">{{ $loop->iteration }}</span></td>
                                            <td>{{ $fila->numero_cliente }}</td>
                                            <td><strong>{{ $fila->nombre }} {{ $fila->apellido }}</strong></td>
                                            <td><span class="text-info fw-bold">S/ {{ number_format($fila->total_monto, 2) }}</span></td>
                                            <td><span class="text-success fw-bold">S/ {{ number_format($fila->total_pagado, 2) }}</span></td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">
                                                <div class="empty-state">
                                                    <i class="fas fa-inbox"></i>
                                                    <p class="mb-0">No hay aportes registrados en este periodo.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>



    <!-- Aquí va el contenido dinámico de tu blade -->
    {{-- @yield('content') --}}
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('show');
    }
</script>

</body>
</html>







  