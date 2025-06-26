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
            --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --warning-gradient: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
            --info-gradient: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
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
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
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
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
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
        .page-title {
            background: var(--primary-gradient);
            color: white;
            padding: 2rem;
            border-radius: 20px;
            margin-bottom: 2rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
            animation: fadeInDown 0.8s ease-out;
        }

        .page-title h1 {
            margin: 0;
            font-weight: 700;
            font-size: 2.5rem;
        }

        .filter-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: none;
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }

        .filter-title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-control, .btn {
            border-radius: 12px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            transform: translateY(-2px);
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            border: none;
            font-weight: 600;
        }

        .btn-success {
            background: var(--success-gradient);
            border: none;
            font-weight: 600;
            box-shadow: 0 5px 15px rgba(17, 153, 142, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(17, 153, 142, 0.4);
        }

        .client-card {
            background: white;
            border-radius: 20px;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            border: none;
            animation: fadeInUp 0.6s ease-out;
            transition: all 0.3s ease;
        }

        .client-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .client-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem 2rem;
            position: relative;
            overflow: hidden;
        }

        .client-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20px;
            width: 100px;
            height: 200%;
            background: rgba(255,255,255,0.1);
            transform: rotate(15deg);
        }

        .client-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            position: relative;
            z-index: 1;
        }

        .client-info-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .client-info-item i {
            background: rgba(255,255,255,0.2);
            padding: 0.5rem;
            border-radius: 8px;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .loan-section {
            padding: 2rem;
        }

        .loan-section-title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .loan-item {
            background: #f8f9fa;
            border-radius: 15px;
            margin-bottom: 1.5rem;
            overflow: hidden;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .loan-item:hover {
            border-color: #667eea;
            transform: translateX(5px);
        }

        .loan-header {
            background: white;
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .loan-summary {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .loan-summary-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .loan-summary-label {
            font-size: 0.8rem;
            color: #6c757d;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .loan-summary-value {
            font-weight: 600;
            color: #2c3e50;
            font-size: 1.1rem;
        }

        .loan-controls {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-activo {
            background: var(--success-gradient);
            color: white;
        }

        .status-pagado {
            background: var(--info-gradient);
            color: #2c3e50;
        }

        .status-pendiente {
            background: var(--warning-gradient);
            color: #2c3e50;
        }

        .status-aprobado {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .status-rechazado {
            background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
            color: white;
        }

        .custom-checkbox {
            width: 20px;
            height: 20px;
            border-radius: 6px;
            border: 2px solid #667eea;
            background: white;
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
        }

        .custom-checkbox:checked {
            background: var(--primary-gradient);
            border-color: #667eea;
        }

        .custom-checkbox:checked::after {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            color: white;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 0.8rem;
        }

        .btn-toggle-details {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 25px;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-toggle-details:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }

        .loan-details {
            padding: 2rem;
            background: white;
        }

        .details-table {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .details-table th {
            background: var(--primary-gradient);
            color: white;
            padding: 1rem;
            font-weight: 600;
            border: none;
            text-align: center;
        }

        .details-table td {
            padding: 1rem;
            border-color: #e9ecef;
            text-align: center;
            vertical-align: middle;
        }

        .details-table tbody tr:hover {
            background: #f8f9fa;
            transform: scale(1.01);
            transition: all 0.2s ease;
        }

        .print-controls {
            background: white;
            padding: 1.5rem 2rem;
            border-radius: 20px;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            animation: fadeInUp 0.8s ease-out 0.4s both;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive mejorado para filtros */
        @media (max-width: 992px) {
            .filter-row {
                gap: 1rem !important;
            }
            
            .filter-col {
                min-width: 250px;
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
                box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            }

            .page-title h1 {
                font-size: 1.8rem;
            }

            .client-info {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }

            .loan-header {
                flex-direction: column;
                align-items: stretch;
                gap: 1rem;
            }

            .loan-summary {
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 1rem;
            }

            .loan-controls {
                justify-content: center;
                margin-top: 1rem;
            }

            .print-controls {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .filter-card {
                padding: 1.5rem;
            }

            /* Filtros responsive mejorados */
            .filter-row {
                gap: 1rem !important;
            }

            .filter-col {
                width: 100% !important;
                max-width: none !important;
            }

            .filter-buttons {
                flex-direction: column;
                gap: 0.5rem;
            }

            .filter-buttons .btn {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .loan-summary {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .loan-summary-item {
                align-items: center;
                text-align: center;
            }

            .details-table {
                font-size: 0.8rem;
            }

            .details-table th,
            .details-table td {
                padding: 0.5rem 0.25rem;
            }
        }

        @media (min-width: 769px) {
            .mobile-menu-toggle {
                display: none;
            }
        }

        /* Print styles mejorados */
        #printSection { display: none; }

        @media print {
            body * {
                visibility: hidden !important;
            }

            #printSection, #printSection * {
                visibility: visible !important;
            }

            #printSection {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 1cm;
                background: white;
                display: block !important;
                font-size: 9px;
                line-height: 1.1;
            }

            .print-client-header {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 1rem;
                padding: 0.8rem;
                border: 2px solid #000;
                border-radius: 8px;
                margin-bottom: 1rem;
                background: #f8f9fa;
                page-break-inside: avoid;
                font-size: 9px;
            }

            .print-client-info {
                display: flex;
                flex-direction: column;
                gap: 0.3rem;
            }

            .print-client-info-item {
                display: flex;
                gap: 0.5rem;
                align-items: center;
            }

            .print-client-info-item strong {
                min-width: 60px;
                font-weight: bold;
            }

            .printable-loan {
                margin-top: 0.5rem;
                margin-bottom: 1rem;
                page-break-inside: avoid;
                border: 1px solid #000;
                padding: 0.8rem;
                border-radius: 8px;
                font-size: 9px;
                background: white;
            }

            .print-loan-header {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                Gap: 0.5rem;
                margin-bottom: 0.8rem;
                padding: 0.5rem;
                background: #e9ecef;
                border-radius: 4px;
                font-weight: bold;
            }

            .print-loan-header-item {
                text-align: center;
                font-size: 8px;
            }

            .printable-loan table {
                width: 100%;
                border-collapse: collapse;
                font-size: 8px;
                margin-top: 0.5rem;
            }

            .printable-loan th {
                background: #f8f9fa;
                border: 1px solid #000;
                padding: 0.3rem 0.2rem;
                text-align: center;
                font-weight: bold;
                font-size: 7px;
            }

            .printable-loan td {
                border: 1px solid #000;
                padding: 0.3rem 0.2rem;
                text-align: center;
                font-size: 7px;
            }

            .print-status {
                padding: 0.2rem 0.4rem;
                border-radius: 3px;
                font-size: 6px;
                font-weight: bold;
                text-transform: uppercase;
            }

            .print-status.pagado {
                background: #d4edda;
                color: #155724;
                border: 1px solid #c3e6cb;
            }

            .print-status.aprobado {
                background: #cce5ff;
                color: #004085;
                border: 1px solid #99d6ff;
            }

            .print-status.pendiente {
                background: #fff3cd;
                color: #856404;
                border: 1px solid #ffeaa7;
            }

            .print-status.rechazado {
                background: #f8d7da;
                color: #721c24;
                border: 1px solid #f5c6cb;
            }

            .print-status.activo {
                background: #d1ecf1;
                color: #0c5460;
                border: 1px solid #bee5eb;
            }

            /* Asegurar que cada préstamo quepa en una página */
            .printable-loan {
                max-height: 25cm;
                overflow: hidden;
            }

            /* Ocultar elementos innecesarios en impresión */
            .form-check,
            .btn,
            .collapse,
            hr {
                display: none !important;
            }

            /* Forzar visibilidad de contenido expandido */
            .print-loan-details {
                display: block !important;
                visibility: visible !important;
            }

            /* Salto de página entre clientes */
            .print-client-break {
                page-break-after: always;
            }
        }

        .bs-collapse:not(.show) {
            display: none;
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
        <a href="{{ route('admin.reporte.prestamos') }}" class="nav-link active">
            <i class="fas fa-chart-line"></i><span>Generar Reportes</span>
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
    <!-- Título de la página -->
    <div class="page-title">
        <h1><i class="fas fa-file-lines me-2"></i>Resumen de Préstamos</h1>
        <p class="mb-0 mt-2 opacity-75">Gestiona y visualiza todos los préstamos de manera eficiente</p>
    </div>

    <!-- Filtros -->
    <div class="filter-card">
        <h5 class="filter-title">
            <i class="fas fa-filter"></i>
            Filtros de búsqueda
        </h5>
        
        <form method="GET" class="filter-row row g-3 align-items-end">
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 filter-col">
                <label class="form-label fw-semibold" for="dni">
                    <i class="fas fa-id-card me-1"></i>DNI
                </label>
                <input type="text" id="dni" name="dni" value="{{ request('dni') }}"
                       placeholder="Ej. 12345678" class="form-control">
            </div>

            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 filter-col">
                <label class="form-label fw-semibold" for="nombre">
                    <i class="fas fa-user me-1"></i>Nombre / Apellido
                </label>
                <input type="text" id="nombre" name="nombre" value="{{ request('nombre') }}"
                       placeholder="Ej. Juan, Rojas" class="form-control">
            </div>

            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 filter-col">
                <label class="form-label fw-semibold" for="desde">
                    <i class="fas fa-calendar-alt me-1"></i>Desde
                </label>
                <input type="date" id="desde" name="desde" value="{{ request('desde') }}"
                       class="form-control">
            </div>

            <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 filter-col">
                <label class="form-label fw-semibold" for="hasta">
                    <i class="fas fa-calendar-alt me-1"></i>Hasta
                </label>
                <input type="date" id="hasta" name="hasta" value="{{ request('hasta') }}"
                       class="form-control">
            </div>

            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 filter-col">
                <label class="form-label fw-semibold" for="estado">
                    <i class="fas fa-flag me-1"></i>Estado
                </label>
                <select id="estado" name="estado" class="form-control">
    <option value="">Todos</option>
    <option value="pagado"    {{ request('estado') == 'pagado'    ? 'selected' : '' }}>Pagado</option>
    <option value="aprobado"  {{ request('estado') == 'aprobado'  ? 'selected' : '' }}>Aprobado</option>
    <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
    <option value="rechazado" {{ request('estado') == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
   
</select>
            </div>

            <div class="col-xl-1 col-lg-2 col-md-2 col-sm-3 d-grid filter-col">
                <div class="filter-buttons d-flex gap-1">
                    <button class="btn btn-primary flex-fill" type="submit">
                        <i class="fas fa-search me-1"></i>
                        <span class="d-none d-md-inline">Filtrar</span>
                    </button>
                </div>
            </div>
            
            <div class="col-xl-1 col-lg-2 col-md-2 col-sm-3 d-grid filter-col">
                <a href="{{ route('admin.reporte.prestamos') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-1"></i>
                    <span class="d-none d-md-inline">Limpiar</span>
                </a>
            </div>
        </form>
    </div>

    <!-- Controles de impresión -->
    <div class="print-controls">
        <div>
            <h6 class="mb-0 text-muted">
                <i class="fas fa-info-circle me-1"></i>
                Selecciona los préstamos a imprimir o imprime todos
            </h6>
        </div>
        <button id="btnPrint" class="btn btn-success">
            <i class="fas fa-print me-2"></i>Imprimir seleccionados
        </button>
          <button id="btnRefresh" class="btn btn-secondary">
            <i class="fas fa-sync-alt me-2"></i>Actualizar
        </button>
    </div>

    <script>
    document.getElementById('btnRefresh').addEventListener('click', function () {
        location.reload(); // Recarga la página actual
    });
</script>

    <!-- Lista de clientes y préstamos -->
    @php use Illuminate\Support\Str; @endphp

    @foreach($prestamosAgrupados as $userId => $prestamosPorNumero)
        @php
            $usuario = $prestamosPorNumero->first()->first()->user ?? null;
        @endphp

        <div class="client-card" data-cliente="{{ $userId }}">
            <!-- Cabecera del cliente -->
            <div class="client-header">
                <div class="client-info">
                    <div class="client-info-item">
                        <i class="fas fa-id-card"></i>
                        <div>
                            <small class="opacity-75">DNI</small>
                            <div class="fw-bold">{{ $usuario->dni ?? '—' }}</div>
                        </div>
                    </div>
                    <div class="client-info-item">
                        <i class="fas fa-user"></i>
                        <div>
                            <small class="opacity-75">Nombre</small>
                            <div class="fw-bold">{{ $usuario->name ?? '—' }}</div>
                        </div>
                    </div>
                    <div class="client-info-item">
                        <i class="fas fa-user-tag"></i>
                        <div>
                            <small class="opacity-75">Apellido</small>
                            <div class="fw-bold">{{ $usuario->apellido_paterno ?? '—' }}</div>
                        </div>
                    </div>
                    <div class="client-info-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <small class="opacity-75">Teléfono</small>
                            <div class="fw-bold">{{ $usuario->telefono ?? '—' }}</div>
                        </div>
                    </div>
                    <div class="client-info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <small class="opacity-75">Dirección</small>
                            <div class="fw-bold">{{ $usuario->direccion ?? '—' }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección de préstamos -->
            <div class="loan-section">
                <h5 class="loan-section-title">
                    <i class="fas fa-list-alt"></i>
                    Detalle de cuotas
                </h5>

                @foreach($prestamosPorNumero as $numero => $items)
                    @php
                        $inicio = $items->min('fecha_inicio');
                        $fin = $items->max('fecha_fin');
                        $ultimo = $items->sortByDesc('item_prestamo')->first();
                        $collapseId = 'detalle-' . Str::slug($userId . '-' . $numero);
                    @endphp

                    <div class="loan-item printable-loan" data-loan-id="{{ $collapseId }}">
                        <div class="loan-header">
                            <div class="loan-summary">
                                <div class="loan-summary-item">
                                    <span class="loan-summary-label">N° Préstamo</span>
                                    <span class="loan-summary-value">{{ $numero }}</span>
                                </div>
                                <div class="loan-summary-item">
                                    <span class="loan-summary-label">Estado</span>
                                    <span class="status-badge status-{{ strtolower($ultimo->estado) }}">
                                        @if(strtolower($ultimo->estado) == 'pagado')
                                            <i class="fas fa-check-circle me-1"></i>
                                        @elseif(strtolower($ultimo->estado) == 'aprobado')
                                            <i class="fas fa-thumbs-up me-1"></i>
                                        @elseif(strtolower($ultimo->estado) == 'pendiente')
                                            <i class="fas fa-clock me-1"></i>
                                        @elseif(strtolower($ultimo->estado) == 'rechazado')
                                            <i class="fas fa-times-circle me-1"></i>
                                        @else
                                            <i class="fas fa-play-circle me-1"></i>
                                        @endif
                                        {{ ucfirst($ultimo->estado) }}
                                    </span>
                                </div>
                                <div class="loan-summary-item">
                                    <span class="loan-summary-label">Período</span>
                                    <span class="loan-summary-value">
                                        {{ \Carbon\Carbon::parse($inicio)->format('d/m/Y') }} - 
                                        {{ \Carbon\Carbon::parse($fin)->format('d/m/Y') }}
                                    </span>
                                </div>
                            </div>

                            <div class="loan-controls">
                                <div class="form-check">
                                    <input class="form-check-input custom-checkbox chk-print" 
                                           type="checkbox" id="chk-{{ $collapseId }}">
                                    <label class="form-check-label ms-2 text-muted" for="chk-{{ $collapseId }}">
                                        Seleccionar
                                    </label>
                                </div>
                                <button class="btn btn-toggle-details" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}"
                                        aria-expanded="false" aria-controls="{{ $collapseId }}">
                                    <i class="fas fa-chevron-down me-1"></i> Ver detalles
                                </button>
                            </div>
                        </div>

                        <div id="{{ $collapseId }}" class="collapse bs-collapse">
                            <div class="loan-details">
                                <div class="table-responsive">
                                    <table class="table details-table mb-0">
                                        <thead>
                                            <tr>
                                                <th><i class="fas fa-hashtag me-1"></i>Ítem</th>
                                                  <th><i class="fas fa-hashtag me-1"></i>Junta</th>
                                                <th><i class="fas fa-money-bill me-1"></i>Monto</th>
                                                <th><i class="fas fa-percentage me-1"></i>Interés</th>
                                                <th><i class="fas fa-calculator me-1"></i>Total</th>
                                                <th><i class="fas fa-flag me-1"></i>Estado</th>
                                                <th><i class="fas fa-calendar me-1"></i>Inicio</th>
                                                <th><i class="fas fa-calendar-check me-1"></i>Fin</th>
                                                <th><i class="fas fa-comment me-1"></i>Descripción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($items as $prestamo)
                                                <tr>
                                                    <td class="fw-bold">{{ $prestamo->item_prestamo }}</td>
                                                    <td class="fw-bold">{{ $prestamo->n_junta }}</td>
                                                    <td class="text-success fw-bold">S/ {{ number_format($prestamo->monto, 2) }}</td>
                                                    <td>{{ $prestamo->interes }}%</td>
                                                    <td class="text-primary fw-bold">S/ {{ number_format($prestamo->interes_pagar, 2) }}</td>
                                                    <td>
                                                        <span class="status-badge status-{{ strtolower($prestamo->estado) }}">
                                                            @if(strtolower($prestamo->estado) == 'pagado')
                                                                <i class="fas fa-check-circle me-1"></i>
                                                            @elseif(strtolower($prestamo->estado) == 'aprobado')
                                                                <i class="fas fa-thumbs-up me-1"></i>
                                                            @elseif(strtolower($prestamo->estado) == 'pendiente')
                                                                <i class="fas fa-clock me-1"></i>
                                                            @elseif(strtolower($prestamo->estado) == 'rechazado')
                                                                <i class="fas fa-times-circle me-1"></i>
                                                            @else
                                                                <i class="fas fa-play-circle me-1"></i>
                                                            @endif
                                                            {{ ucfirst($prestamo->estado) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($prestamo->fecha_inicio)->format('d/m/Y') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($prestamo->fecha_fin)->format('d/m/Y') }}</td>
                                                    <td>{{ $prestamo->descripcion ?: '—' }}</td>
                                                </tr>
                                            @endforeach
                                            <tfoot>
    <tr>
        <td colspan="4" class="text-end fw-bold">Total acumulado:</td>
        <td class="text-primary fw-bold">
            S/ {{ number_format($items->sum('interes_pagar'), 2) }}
        </td>
        <td colspan="4"></td>
    </tr>
</tfoot>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

<!-- Área de impresión -->
<div id="printSection"></div>

<script>
    // Función para alternar sidebar
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('show');
    }

    // Función de impresión mejorada
    document.getElementById('btnPrint').addEventListener('click', () => {
        const printDiv = document.getElementById('printSection');
        printDiv.innerHTML = '';

        // Checkbox seleccionados
        const chks = [...document.querySelectorAll('.chk-print:checked')];

        // Si no hay checks, asume "imprimir todo"
        const loansToPrint = chks.length
            ? chks
            : [...document.querySelectorAll('.chk-print')];

        // Agrupa por cliente
        const groups = {};
        loansToPrint.forEach(chk => {
            const loanBox = chk.closest('.printable-loan');
            const cliente = loanBox.closest('[data-cliente]').dataset.cliente;
            (groups[cliente] = groups[cliente] || []).push(loanBox);
        });

        // Genera contenido final
        for (const clienteId in groups) {
            const clienteBlock = document.querySelector('[data-cliente="'+clienteId+'"]');
            const usuario = clienteBlock.querySelector('.client-info');

            // Crear cabecera mejorada para impresión
            const printHeader = document.createElement('div');
            printHeader.className = 'print-client-header';
            
            // Extraer datos del usuario
            const clientData = {};
            usuario.querySelectorAll('.client-info-item').forEach(item => {
                const label = item.querySelector('small').textContent;
                const value = item.querySelector('.fw-bold').textContent;
                clientData[label] = value;
            });

            printHeader.innerHTML = `
                <div class="print-client-info">
                    <div class="print-client-info-item">
                        <strong>DNI:</strong> <span>${clientData['DNI'] || '—'}</span>
                    </div>
                    <div class="print-client-info-item">
                        <strong>Nombre:</strong> <span>${clientData['Nombre'] || '—'}</span>
                    </div>
                    <div class="print-client-info-item">
                        <strong>Teléfono:</strong> <span>${clientData['Teléfono'] || '—'}</span>
                    </div>
                </div>
                <div class="print-client-info">
                    <div class="print-client-info-item">
                        <strong>Apellido:</strong> <span>${clientData['Apellido'] || '—'}</span>
                    </div>
                    <div class="print-client-info-item">
                        <strong>Dirección:</strong> <span>${clientData['Dirección'] || '—'}</span>
                    </div>
                    <div class="print-client-info-item">
                        <strong>Fecha:</strong> <span>${new Date().toLocaleDateString()}</span>
                    </div>
                </div>
            `;
            
            printDiv.appendChild(printHeader);

            // Añade cada préstamo marcado
            const prestamos = groups[clienteId];
            prestamos.forEach((originalLoan, index) => {
                const loanClone = originalLoan.cloneNode(true);
                
                // Limpiar elementos innecesarios
                loanClone.querySelector('.form-check')?.remove();
                loanClone.querySelector('.loan-controls')?.remove();
                
                // Obtener datos del resumen del préstamo
                const loanSummary = originalLoan.querySelector('.loan-summary');
                const numero = loanSummary.querySelector('.loan-summary-value').textContent;
                const estado = loanSummary.querySelectorAll('.loan-summary-item')[1].querySelector('.status-badge').textContent.trim();
                const periodo = loanSummary.querySelectorAll('.loan-summary-item')[2].querySelector('.loan-summary-value').textContent;
                
                // Crear cabecera del préstamo para impresión
                const printLoanHeader = document.createElement('div');
                printLoanHeader.className = 'print-loan-header';
                printLoanHeader.innerHTML = `
                    <div class="print-loan-header-item">
                        <strong>N° Préstamo:</strong><br>${numero}
                    </div>
                    <div class="print-loan-header-item">
                        <strong>Estado:</strong><br>
                        <span class="print-status ${estado.toLowerCase()}">${estado}</span>
                    </div>
                    <div class="print-loan-header-item">
                        <strong>Período:</strong><br>${periodo}
                    </div>
                    <div class="print-loan-header-item">
                        <strong>Página:</strong><br>${index + 1}
                    </div>
                `;

                // Expandir detalles
                const collapseDiv = loanClone.querySelector('.collapse');
                if (collapseDiv) {
                    collapseDiv.classList.remove('collapse');
                    collapseDiv.classList.add('print-loan-details');
                    collapseDiv.style.display = 'block';
                }

                // Mejorar tabla para impresión
                const table = loanClone.querySelector('table');
                if (table) {
                    // Actualizar estados en la tabla
                    table.querySelectorAll('.status-badge').forEach(badge => {
                        const estado = badge.textContent.trim().toLowerCase();
                        badge.className = `print-status ${estado}`;
                    });
                }

                // Crear contenedor del préstamo
                const printLoan = document.createElement('div');
                printLoan.className = 'printable-loan';
                printLoan.appendChild(printLoanHeader);
                printLoan.appendChild(loanClone.querySelector('.loan-details') || loanClone);

                printDiv.appendChild(printLoan);

                // Agregar salto de página entre préstamos (excepto el último)
                if (index < prestamos.length - 1) {
                    const pageBreak = document.createElement('div');
                    pageBreak.style.pageBreakAfter = 'always';
                    printDiv.appendChild(pageBreak);
                }
            });

            // Salto de página entre clientes
            const clientBreak = document.createElement('div');
            clientBreak.className = 'print-client-break';
            printDiv.appendChild(clientBreak);
        }

        // Lanza diálogo imprimir
        window.print();
    });

    // Animación para los chevrones de los botones de detalles
    document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(btn => {
        btn.addEventListener('click', function() {
            const icon = this.querySelector('i');
            setTimeout(() => {
                const target = document.querySelector(this.dataset.bsTarget);
                if (target.classList.contains('show')) {
                    icon.classList.remove('fa-chevron-down');
                    icon.classList.add('fa-chevron-up');
                } else {
                    icon.classList.remove('fa-chevron-up');
                    icon.classList.add('fa-chevron-down');
                }
            }, 100);
        });
    });

    // Efecto hover para las tarjetas
    document.querySelectorAll('.client-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
</script>