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
    
    <!-- jsPDF para generar PDFs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --sidebar-bg: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
            --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        body {
            background: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
        }

        /* SIDEBAR - NO MODIFICAR */
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
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
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
            max-height: calc(100vh - 160px);
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
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

        /* CONTENIDO PRINCIPAL MEJORADO */
        .main-content {
            margin-left: 280px;
            padding: 2rem;
            transition: margin-left 0.3s ease;
            min-height: 100vh;
        }

        /* Botones de acción */
        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .btn-print {
            background: var(--success-gradient);
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(17, 153, 142, 0.3);
        }

        .btn-print:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(17, 153, 142, 0.4);
            color: white;
        }

        /* Selector de período mejorado */
        .period-selector-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
            border: none;
        }

        .period-selector-title {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .period-selector-title i {
            color: #667eea;
        }

        .current-period-indicator {
            background: var(--info-gradient);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            font-weight: 600;
            text-align: center;
            box-shadow: 0 4px 15px rgba(79, 172, 254, 0.3);
        }

        .form-select {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-filter {
            background: var(--primary-gradient);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .btn-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        /* Cards para semanas */
        .week-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            overflow: hidden;
            border: none;
            transition: all 0.3s ease;
        }

        .week-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }

        .week-header {
            background: var(--primary-gradient);
            color: white;
            padding: 1.5rem 2rem;
            margin: 0;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .week-title {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0;
        }

        .week-count {
            background: rgba(255, 255, 255, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .week-actions {
            display: flex;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .btn-week-action {
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .btn-week-action:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
        }

        /* Tabla mejorada */
        .table-container {
            padding: 0;
        }

        .table {
            margin: 0;
            font-size: 0.95rem;
        }

        .table thead th {
            background: #f8f9fa;
            border: none;
            padding: 1rem 0.75rem;
            font-weight: 600;
            color: #2c3e50;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .table tbody td {
            padding: 1rem 0.75rem;
            border-color: #f1f3f4;
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        /* Total de semana */
        .week-total {
            background: #f8f9fa;
            padding: 1rem 2rem;
            border-top: 2px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 700;
            color: #2c3e50;
        }

        .total-amount {
            color: #28a745;
            font-size: 1.1rem;
        }

        /* Badges mejorados */
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-badge.success {
            background: var(--success-gradient);
            color: white;
        }

        .status-badge.warning {
            background: var(--warning-gradient);
            color: white;
        }

        .status-badge.secondary {
            background: #6c757d;
            color: white;
        }

        /* Alert mejorado */
        .alert-info {
            background: var(--info-gradient);
            color: white;
            border: none;
            border-radius: 15px;
            padding: 1.5rem;
            font-weight: 600;
            text-align: center;
            box-shadow: 0 4px 15px rgba(79, 172, 254, 0.3);
        }

        /* Estilos para impresión */
        @media print {
            .sidebar,
            .mobile-menu-toggle,
            .action-buttons,
            .week-actions,
            .btn,
            .period-selector-card {
                display: none !important;
            }

            .main-content {
                margin-left: 0 !important;
                padding: 0 !important;
            }

            .week-card {
                box-shadow: none !important;
                border: 1px solid #ddd !important;
                margin-bottom: 1rem !important;
                page-break-inside: avoid;
            }

            .week-header {
                background: #f8f9fa !important;
                color: #000 !important;
                -webkit-print-color-adjust: exact;
            }

            .table {
                font-size: 0.8rem !important;
            }

            .status-badge {
                border: 1px solid #ddd !important;
                background: #f8f9fa !important;
                color: #000 !important;
            }

            body {
                background: white !important;
            }
        }

        /* Responsive mejorado */
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
                border-radius: 10px;
                cursor: pointer;
                box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            }

            .action-buttons {
                flex-direction: column;
            }

            .week-actions {
                flex-direction: column;
            }

            .period-selector-card {
                padding: 1.5rem;
            }

            .week-header {
                padding: 1rem 1.5rem;
                flex-direction: column;
                align-items: flex-start;
            }

            .week-title {
                font-size: 1rem;
            }

            .table-responsive {
                border-radius: 0;
            }

            .table {
                font-size: 0.85rem;
            }

            .table thead th,
            .table tbody td {
                padding: 0.75rem 0.5rem;
            }

            .week-total {
                padding: 1rem;
                flex-direction: column;
                gap: 0.5rem;
                text-align: center;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 0.5rem;
            }

            .period-selector-card {
                padding: 1rem;
                margin-bottom: 1rem;
            }

            .week-card {
                margin-bottom: 1rem;
            }

            .week-header {
                padding: 1rem;
            }

            .table thead th,
            .table tbody td {
                padding: 0.5rem 0.25rem;
                font-size: 0.8rem;
            }

            .status-badge {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
        }

        @media (min-width: 769px) {
            .mobile-menu-toggle {
                display: none;
            }
        }

        /* Animaciones */
        .week-card {
            animation: fadeInUp 0.6s ease-out;
        }

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

        /* Números formateados */
        .currency {
            font-weight: 600;
            color: #2c3e50;
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
    <!-- Selector de período mejorado -->
    <div class="card period-selector-card">
        <h4 class="period-selector-title">
            <i class="fas fa-calendar-alt"></i>
            Selección de Período
        </h4>
        
        @if(request()->filled('periodo_id'))
            @php
                $periodoSeleccionado = $periodos->firstWhere('id', request('periodo_id'));
            @endphp
            @if($periodoSeleccionado)
                <div class="current-period-indicator">
                    <i class="fas fa-calendar-check me-2"></i>
                    Período Actual: 
                    {{ \Carbon\Carbon::parse($periodoSeleccionado->periodo_inicio)->format('d/m/Y') }}
                    — 
                    {{ \Carbon\Carbon::parse($periodoSeleccionado->periodo_fin)->format('d/m/Y') }}
                </div>
            @endif
        @endif
        
        <form method="GET" action="{{ route('reporte.general') }}" class="row g-3 align-items-end">
            <div class="col-md-8">
                <label for="periodo_id" class="form-label fw-bold text-muted">
                    <i class="fas fa-filter me-1"></i>
                    Seleccione un período para generar el reporte
                </label>
                <select name="periodo_id" id="periodo_id" class="form-select">
                    <option value="">— Seleccionar período —</option>
                    @foreach ($periodos as $p)
                        <option value="{{ $p->id }}" {{ request('periodo_id') == $p->id ? 'selected' : '' }}>
                            📅 {{ \Carbon\Carbon::parse($p->periodo_inicio)->format('d/m/Y') }}
                            — 
                            {{ \Carbon\Carbon::parse($p->periodo_fin)->format('d/m/Y') }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-filter w-100">
                    <i class="fas fa-search me-2"></i>
                    Generar Reporte
                </button>
            </div>
        </form>

        @if(request()->filled('periodo_id'))
            <form method="GET" action="{{ route('reporte.general.export') }}">
                <input type="hidden" name="periodo_id" value="{{ request('periodo_id') }}">
                <button type="submit" class="btn btn-success mt-3">
                    <i class="fas fa-file-excel me-2"></i>
                    Exportar a Excel
                </button>
            </form>
        @endif
    </div>

    <!-- Botones de acción general -->
    @if(request()->filled('periodo_id') && !$reporteSemanal->isEmpty())
        <div class="action-buttons">
    <button onclick="printReport()" class="btn btn-print">
        <i class="fas fa-print me-2"></i>
        Imprimir Reporte Completo (Ctrl+P)
    </button>
</div>
    @endif

    <!-- Contenido del reporte -->
    @if ($reporteSemanal->isEmpty() && request()->filled('periodo_id'))
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            No se encontraron préstamos dentro del período seleccionado.
        </div>
    @endif

    @foreach ($reporteSemanal as $semana)
        <div class="card week-card" id="week-{{ $semana['semana'] }}">
            <div class="week-header">
                <div>
                    <h5 class="week-title">
                        <i class="fas fa-calendar-week"></i>
                        Semana {{ $semana['semana'] }}
                        <small class="d-block d-md-inline ms-md-2 mt-1 mt-md-0">
                            {{ \Carbon\Carbon::parse($semana['desde'])->format('d/m/Y') }} 
                            — 
                            {{ \Carbon\Carbon::parse($semana['hasta'])->format('d/m/Y') }}
                        </small>
                    </h5>
                   <div class="week-actions">
    <button onclick="printWeek({{ $semana['semana'] }})" class="btn btn-week-action">
        <i class="fas fa-print me-1"></i>
        Imprimir Semana
    </button>
</div>
                </div>
                <div class="week-count">
                    <i class="fas fa-file-contract me-1"></i>
                    {{ $semana['prestamos']->count() }} préstamo(s)
                </div>
            </div>
            
            <div class="table-container">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>N° Préstamo</th>
                                <th>Usuario</th>
                                <th>Monto</th>
                                <th>Interés</th>
                                <th>Interés a Pagar</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalInteresPagar = 0;
                            @endphp
                            @forelse ($semana['prestamos'] as $prestamo)
                                @php
                                    $totalInteresPagar += $prestamo->interes_pagar;
                                @endphp
                                <tr>
                                    <td><strong>{{ $loop->iteration }}</strong></td>
                                    <td>
                                        <span class="fw-bold text-primary">{{ $prestamo->numero_prestamo }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-user-circle text-muted me-2"></i>
                                            {{ $prestamo->user->name ?? '—' }} {{ $prestamo->user->apellido_paterno ?? '' }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="currency">
                                            ${{ number_format($prestamo->monto, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="currency">
                                            {{ number_format($prestamo->interes, 2) }}%
                                        </span>
                                    </td>
                                    <td>
                                        <span class="currency text-success">
                                            ${{ number_format($prestamo->interes_pagar, 2) }}
                                        </span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($prestamo->fecha_inicio)->format('d/m/Y') }}
                                        </small>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($prestamo->fecha_fin)->format('d/m/Y') }}
                                        </small>
                                    </td>
                                    <td>
                                        <span class="status-badge {{ $prestamo->estado === 'pagado' ? 'success' : ($prestamo->estado === 'pendiente' ? 'warning' : 'secondary') }}">
                                            @if($prestamo->estado === 'pagado')
                                                <i class="fas fa-check-circle me-1"></i>
                                            @elseif($prestamo->estado === 'pendiente')
                                                <i class="fas fa-clock me-1"></i>
                                            @else
                                                <i class="fas fa-minus-circle me-1"></i>
                                            @endif
                                            {{ ucfirst($prestamo->estado) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <i class="fas fa-inbox text-muted mb-2 d-block" style="font-size: 2rem;"></i>
                                        <span class="text-muted">No hubo préstamos esta semana.</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($semana['prestamos']->count() > 0)
                <div class="week-total">
                    <span>
                        <i class="fas fa-calculator me-2"></i>
                        Total Interés a Pagar - Semana {{ $semana['semana'] }}:
                    </span>
                    <span class="total-amount">
                        ${{ number_format($totalInteresPagar, 2) }}
                    </span>
                </div>
            @endif
        </div>
    @endforeach
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('show');
    }

    // Cerrar sidebar al hacer clic fuera en móvil
    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('sidebar');
        const toggleButton = document.querySelector('.mobile-menu-toggle');
        
        if (window.innerWidth <= 768) {
            if (!sidebar.contains(event.target) && !toggleButton.contains(event.target)) {
                sidebar.classList.remove('show');
            }
        }
    });

    // Manejar redimensionamiento de ventana
    window.addEventListener('resize', function() {
        const sidebar = document.getElementById('sidebar');
        if (window.innerWidth > 768) {
            sidebar.classList.remove('show');
        }
    });

    // Función para imprimir reporte completo
    function printReport() {
        window.print();
    }

    // Función para imprimir una semana específica
    function printWeek(weekNumber) {
        // Ocultar todas las semanas excepto la seleccionada
        const allWeeks = document.querySelectorAll('.week-card');
        const targetWeek = document.getElementById(`week-${weekNumber}`);
        
        allWeeks.forEach(week => {
            if (week !== targetWeek) {
                week.style.display = 'none';
            }
        });

        // Imprimir
        window.print();

        // Restaurar todas las semanas
        setTimeout(() => {
            allWeeks.forEach(week => {
                week.style.display = 'block';
            });
        }, 1000);
    }

    // Función para descargar PDF completo
   

   

    // Atajo de teclado Ctrl+P
    document.addEventListener('keydown', function(event) {
        if (event.ctrlKey && event.key === 'p') {
            event.preventDefault();
            printReport();
        }
    });
</script>

</body>
</html>