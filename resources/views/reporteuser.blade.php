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
            --success-gradient: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
            --info-gradient: linear-gradient(135deg, #3498db 0%, #85c1e9 100%);
            --warning-gradient: linear-gradient(135deg, #f39c12 0%, #f7dc6f 100%);
            --shadow-soft: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-medium: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
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
            min-height: 100vh;
        }

        /* MEJORAS VISUALES DEL CONTENIDO */
        .content-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 20px;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-medium);
            text-align: center;
        }

        .content-header h1 {
            margin: 0;
            font-size: 2.5rem;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .content-header .subtitle {
            opacity: 0.9;
            font-size: 1.1rem;
            margin-top: 0.5rem;
        }

        /* FILTROS MEJORADOS */
        .filters-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-medium);
            border: 1px solid rgba(0,0,0,0.05);
        }

        .filters-title {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-group {
            margin-bottom: 1.5rem;
        }

        .filter-label {
            font-weight: 600;
            color: #34495e;
            margin-bottom: 0.5rem;
            display: block;
        }

        .filter-input {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            width: 100%;
        }

        .filter-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            outline: none;
        }

        .btn-filter {
            background: var(--primary-gradient);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-soft);
        }

        .btn-filter:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
        }

        .btn-clear {
            background: linear-gradient(135deg, #95a5a6 0%, #bdc3c7 100%);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-soft);
        }

        .btn-clear:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
        }

        /* TABLA MEJORADA */
        .table-container {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: var(--shadow-medium);
            overflow: hidden;
        }

        .table-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .results-info {
            color: #6c757d;
            font-weight: 500;
        }

        .btn-print {
            background: var(--success-gradient);
            border: none;
            padding: 0.75rem 0rem;
            border-radius: 50px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-soft);
            display: flex;
            align-items: center;
        
        }

        .btn-print:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
        }

        .custom-table {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: var(--shadow-soft);
            margin: 0;
        }

        .custom-table thead th {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            font-weight: 600;
            padding: 1rem;
            border: none;
            text-align: center;
            font-size: 0.9rem;
        }

        .custom-table tbody tr {
            transition: all 0.3s ease;
            border: none;
        }

        .custom-table tbody tr:hover {
            background-color: #f8f9fa;
            transform: scale(1.01);
        }

        .custom-table tbody td {
            padding: 1rem;
            border: 1px solid #e9ecef;
            text-align: center;
            vertical-align: middle;
        }

        .loan-number {
            font-weight: 700;
            color: #667eea;
            font-size: 1.1rem;
        }

        .date-cell {
            color: #6c757d;
            font-weight: 500;
        }

        .amount-cell {
            font-weight: 700;
            color: #27ae60;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .status-paid {
            background: #cce5ff;
            color: #004085;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .btn-detail {
            background: var(--info-gradient);
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 0.85rem;
        }

        .btn-detail:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-soft);
        }

        /* DETALLE EXPANDIBLE */
        .detail-container {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 15px;
            padding: 1.5rem;
            margin: 1rem 0;
        }

        .detail-table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: var(--shadow-soft);
        }

        .detail-table thead th {
            background: linear-gradient(135deg, #495057 0%, #6c757d 100%);
            color: white;
            font-weight: 600;
            padding: 0.75rem;
            font-size: 0.85rem;
        }

        .detail-table tbody td {
            padding: 0.75rem;
            font-size: 0.9rem;
            border-bottom: 1px solid #e9ecef;
        }

        .totals-row {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            font-weight: 700;
            color: #1565c0;
        }

        .checkbox-custom {
            width: 1.2rem;
            height: 1.2rem;
            accent-color: #667eea;
        }

        /* RESPONSIVE MEJORADO */
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
                padding: 0.75rem;
                border-radius: 50%;
                cursor: pointer;
                width: 50px;
                height: 50px;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: var(--shadow-medium);
            }

            .content-header h1 {
                font-size: 1.8rem;
            }

            .filters-card {
                padding: 1rem;
            }

            .table-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-print {
                justify-content: center;
            }

            .custom-table {
                font-size: 0.8rem;
            }

            .custom-table thead th,
            .custom-table tbody td {
                padding: 0.5rem 0.25rem;
            }

            .loan-number {
                font-size: 1rem;
            }
        }

        @media (min-width: 769px) {
            .mobile-menu-toggle {
                display: none;
            }
        }

        /* ESTILOS DE IMPRESIÓN MEJORADOS */
        @media print {
            body * {
                visibility: hidden;
            }

            .print-content,
            .print-content * {
                visibility: visible !important;
            }

            .print-content {
                position: absolute;
                left: 0;
                top: 0;
                width: 100% !important;
                background: white !important;
            }

            .no-print {
                display: none !important;
            }

            .sidebar {
                display: none !important;
            }

            .main-content {
                margin-left: 0 !important;
                padding: 0 !important;
            }

            .print-header {
                text-align: center;
                margin-bottom: 20px;
                border-bottom: 2px solid #000;
                padding-bottom: 10px;
            }

            .print-title {
                font-size: 24px !important;
                font-weight: bold;
                margin: 0;
                color: #000 !important;
            }

            .print-date {
                font-size: 12px;
                color: #666;
                margin-top: 5px;
            }

            .custom-table,
            .detail-table {
                border-collapse: collapse !important;
                width: 100% !important;
                font-size: 10px !important;
                margin-bottom: 20px !important;
            }

            .custom-table th,
            .custom-table td,
            .detail-table th,
            .detail-table td {
                border: 1px solid #000 !important;
                padding: 6px !important;
                text-align: center !important;
                color: #000 !important;
                background: white !important;
            }

            .custom-table thead th,
            .detail-table thead th {
                background: #f0f0f0 !important;
                font-weight: bold !important;
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
            <a href="{{ route('home') }}" class="nav-link"><i class="fas fa-home"></i><span>Inicio</span></a>
        </div>
        <div class="nav-item">
            <a href="{{ route('perfil') }}" class="nav-link"><i class="fas fa-user-circle"></i><span>Perfil</span></a>
        </div>
        <div class="nav-item">
            <a href="{{ route('reporteusuarios.index') }}" class="nav-link active"><i class="fas fa-download"></i><span>Reporte</span></a>
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
    <!-- Header del contenido -->
    <div class="content-header">
        <h1><i class="fas fa-chart-line"></i> Reporte de Préstamos</h1>
        <div class="subtitle">Gestiona y visualiza todos los préstamos de forma eficiente</div>
    </div>

    <!-- Filtros -->
    <div class="filters-card no-print">
        <h3 class="filters-title">
            <i class="fas fa-filter"></i>
            Filtros de Búsqueda
        </h3>
        
        <div class="row">
            <div class="col-md-4">
                <div class="filter-group">
                    <label class="filter-label">Número de Préstamo</label>
                    <input type="text" class="filter-input" id="filterNumero" placeholder="Ej: 001, 002...">
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="filter-group">
                    <label class="filter-label">Fecha Desde</label>
                    <input type="date" class="filter-input" id="filterFechaDesde">
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="filter-group">
                    <label class="filter-label">Fecha Hasta</label>
                    <input type="date" class="filter-input" id="filterFechaHasta">
                </div>
            </div>
        </div>
        
        <div class="row mt-3">
            
            
            <div class="col-md-8 d-flex align-items-end gap-2">
                <button type="button" class="btn-filter" onclick="aplicarFiltros()">
                    <i class="fas fa-search"></i> Buscar
                </button>
                <button type="button" class="btn-clear" onclick="limpiarFiltros()">
                    <i class="fas fa-times"></i> Limpiar
                </button>
            </div>
        </div>
    </div>

    <!-- Contenedor de la tabla -->
    <div class="table-container">
        <div class="table-actions no-print">
            <div class="results-info">
                <i class="fas fa-info-circle"></i>
                Mostrando <span id="resultados-count">{{ count($prestamos) }}</span> préstamos
            </div>
            
            <div class="d-flex gap-2 align-items-center">
                <button type="button" class="btn btn-outline-primary btn-sm" onclick="seleccionarTodos()">
                    <i class="fas fa-check-double"></i> Seleccionar Todos
                </button>
                <button type="button" class="btn-print" onclick="imprimirSeleccionados()">
                    <i class="fas fa-print"></i> Imprimir o Descargar
                </button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="location.reload()">
                <i class="fas fa-sync-alt"></i> Actualizar
            </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table custom-table" id="tablaReportes">
                <thead>
                    <tr>
                        <th width="5%">
                            <input type="checkbox" class="checkbox-custom" id="selectAll">
                        </th>
                        <th width="15%">N° Préstamo</th>
                        <th width="20%">Fecha Último Préstamo</th>
                        <th width="20%">Fecha Último Pago</th>
                        <th width="15%">Monto Total</th>
                       
                        <th width="10%">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prestamos as $numero_prestamo => $registros)
                        @php
                            $ultimo = $registros->sortByDesc('fecha_inicio')->first();
                            $totalMonto = $registros->sum('monto');
                            $estados = $registros->pluck('estado')->unique();
                          
                        @endphp

                       <tr class="fila-principal"
    data-numero="{{ $numero_prestamo }}"
    data-fecha-inicio="{{ $ultimo->fecha_inicio }}"
    data-fecha-fin="{{ $ultimo->fecha_fin }}"
    data-estado="{{ $estados->first() }}">
                            <td>
                                <input type="checkbox" class="checkbox-custom seleccionar-reporte" data-target="{{ $numero_prestamo }}">
                            </td>
                            <td class="loan-number"># {{ $numero_prestamo }}</td>
                            <td class="date-cell">{{ date('d/m/Y', strtotime($ultimo->fecha_inicio)) }}</td>
                            <td class="date-cell">{{ date('d/m/Y', strtotime($ultimo->fecha_fin)) }}</td>
                            <td class="amount-cell">S/ {{ number_format($totalMonto, 2) }}</td>
                            
                            <td>
                                <button class="btn-detail" type="button" data-bs-toggle="collapse" data-bs-target="#detalle-{{ $numero_prestamo }}">
                                    <i class="fas fa-eye"></i> Ver Detalle
                                </button>
                            </td>
                        </tr>

                        {{-- Detalle expandible --}}
                        <tr class="collapse bloque-imprimible bloque-{{ $numero_prestamo }}" id="detalle-{{ $numero_prestamo }}">
                            <td colspan="7">
                                <div class="detail-container">
                                    <h5 class="mb-3">
                                        <i class="fas fa-list-ul"></i>
                                        Detalle del Préstamo # {{ $numero_prestamo }}
                                    </h5>
                                    
                                    <div class="table-responsive">
                                        <table class="table detail-table">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Item</th>
                                                    <th>Junta</th>
                                                    <th>Fecha Inicio</th>
                                                    <th>Fecha Fin</th>
                                                    <th>Monto</th>
                                                    <th>Interés a Pagar</th>
                                                    <th>Interés</th>
                                                    <th>Descripción</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $totalMonto = 0;
                                                    $totalInteres = 0;
                                                    $totalInteresPagar = 0;
                                                @endphp
                                                @foreach($registros->sortBy('fecha_inicio') as $detalle)
                                                    @php
                                                        $totalMonto += $detalle->monto;
                                                        $totalInteres += $detalle->interes;
                                                        $totalInteresPagar += $detalle->interes_pagar;
                                                    @endphp
                                                   <tr 
    data-fecha-inicio="{{ $detalle->fecha_inicio }}" 
    data-fecha-fin="{{ $detalle->fecha_fin }}"
>
    <td>{{ $detalle->id }}</td>
    <td>{{ $detalle->item_prestamo }}</td>
    <td>{{ $detalle->n_junta }}</td>
    <td>{{ date('d/m/Y', strtotime($detalle->fecha_inicio)) }}</td>
    <td>{{ date('d/m/Y', strtotime($detalle->fecha_fin)) }}</td>
    <td class="amount-cell">S/ {{ number_format($detalle->monto, 2) }}</td>
    <td class="amount-cell">S/ {{ number_format($detalle->interes_pagar, 2) }}</td>
    <td class="amount-cell"> {{ number_format($detalle->interes, 2) }}%</td>
    <td>{{ $detalle->descripcion ?: 'N/A' }}</td>
    <td>
        <span class="status-badge status-{{ $detalle->estado }}">
            {{ ucfirst($detalle->estado) }}
        </span>
    </td>
</tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr class="totals-row">
                                                    <th colspan="5" class="text-end">TOTALES:</th>
                                                    <th>S/ {{ number_format($totalMonto, 2) }}</th>
                                                    <th>S/ {{ number_format($totalInteresPagar, 2) }}</th>
                                                    
                                                    <th colspan="2"></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Contenido para impresión (oculto por defecto) -->
<div class="print-content" style="display: none;">
    <div class="print-header">
        <h1 class="print-title">REPORTE DE PRÉSTAMOS</h1>
        <div class="print-date">Fecha de generación: <span id="fechaImpresion"></span></div>
    </div>
    <div id="contenidoImpresion"></div>
</div>

<script>
    // Variables globales
    let prestamosOriginales = [];

    // Inicialización
    document.addEventListener('DOMContentLoaded', function() {
        cargarDatosOriginales();
        configurarEventos();
    });

    function cargarDatosOriginales() {
    const filas = document.querySelectorAll('.fila-principal');
    prestamosOriginales = Array.from(filas).map(fila => ({
        elemento: fila,
        numero: fila.dataset.numero,
        fecha_inicio: fila.dataset.fechaInicio,
        fecha_fin: fila.dataset.fechaFin,
        estado: fila.dataset.estado
    }));
}

    function configurarEventos() {
        // Checkbox seleccionar todos
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.seleccionar-reporte:not([style*="display: none"])');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        // Filtros en tiempo real
        const filtros = ['filterNumero', 'filterFechaDesde', 'filterFechaHasta', 'filterEstado'];
        filtros.forEach(filtroId => {
            document.getElementById(filtroId).addEventListener('input', aplicarFiltros);
        });
    }

function aplicarFiltros() {
    const filtroNumero = document.getElementById('filterNumero').value.toLowerCase();
    const filtroFechaDesde = document.getElementById('filterFechaDesde').value;
    const filtroFechaHasta = document.getElementById('filterFechaHasta').value;
    const filtroEstado = document.getElementById('filterEstado')?.value;

    let contadorVisible = 0;

    prestamosOriginales.forEach(prestamo => {
        let mostrar = true;

        // Filtro por número
        if (filtroNumero && !prestamo.numero.toLowerCase().includes(filtroNumero)) {
            mostrar = false;
        }

        // Filtro por estado
        if (filtroEstado && prestamo.estado !== filtroEstado) {
            mostrar = false;
        }

        // Filtro por fechas
        if ((filtroFechaDesde || filtroFechaHasta) && mostrar) {
            const filaDetalle = document.getElementById(`detalle-${prestamo.numero}`);
            const filasInternas = filaDetalle?.querySelectorAll('tr[data-fecha-inicio]') || [];

            let tieneCoincidencia = false;

            filasInternas.forEach(tr => {
    const fechaInicio = new Date(tr.dataset.fechaInicio);
    const fechaFin = new Date(tr.dataset.fechaFin);

   const desde = filtroFechaDesde ? new Date(filtroFechaDesde) : null;
let hasta = filtroFechaHasta ? new Date(filtroFechaHasta) : null;
if (hasta) {
  // Asegúrate que incluye todo el día
  hasta.setHours(23, 59, 59, 999);
}

    // Comparación robusta con objetos Date
    if (
        (!desde || fechaFin >= desde) &&
        (!hasta || fechaInicio <= hasta)
    ) {
        tieneCoincidencia = true;
    }
});

            if (!tieneCoincidencia) {
                mostrar = false;
            }
        }

        // Mostrar u ocultar la fila principal y su detalle
        const filaDetalle = document.getElementById(`detalle-${prestamo.numero}`);
        if (mostrar) {
            prestamo.elemento.style.display = '';
            if (filaDetalle) filaDetalle.style.display = '';
            contadorVisible++;
        } else {
            prestamo.elemento.style.display = 'none';
            if (filaDetalle) filaDetalle.style.display = 'none';
        }
    });

    // Actualiza el contador
    document.getElementById('resultados-count').textContent = contadorVisible;
}
    function limpiarFiltros() {
        document.getElementById('filterNumero').value = '';
        document.getElementById('filterFechaDesde').value = '';
        document.getElementById('filterFechaHasta').value = '';
        document.getElementById('filterEstado').value = '';
        
        // Mostrar todas las filas
        prestamosOriginales.forEach(prestamo => {
            prestamo.elemento.style.display = '';
            const filaDetalle = document.getElementById(`detalle-${prestamo.numero}`);
            if (filaDetalle) filaDetalle.style.display = '';
        });

        // Resetear contador
        document.getElementById('resultados-count').textContent = prestamosOriginales.length;
        
        // Limpiar selección
        document.getElementById('selectAll').checked = false;
        document.querySelectorAll('.seleccionar-reporte').forEach(cb => cb.checked = false);
    }

    function seleccionarTodos() {
        const checkboxesVisibles = document.querySelectorAll('.seleccionar-reporte');
        const todosSeleccionados = Array.from(checkboxesVisibles).every(cb => 
            cb.checked || cb.closest('tr').style.display === 'none'
        );
        
        checkboxesVisibles.forEach(cb => {
            if (cb.closest('tr').style.display !== 'none') {
                cb.checked = !todosSeleccionados;
            }
        });
        
        document.getElementById('selectAll').checked = !todosSeleccionados;
    }

    function imprimirSeleccionados() {
        const seleccionados = document.querySelectorAll('.seleccionar-reporte:checked');
        
        if (seleccionados.length === 0) {
            alert('Por favor, selecciona al menos un préstamo para imprimir.');
            return;
        }

        // Preparar contenido de impresión
        let contenidoHTML = '';
        
        seleccionados.forEach(checkbox => {
            const numero = checkbox.getAttribute('data-target');
            const filaDetalle = document.getElementById(`detalle-${numero}`);
            
            if (filaDetalle) {
                // Expandir el detalle si no está expandido
                if (!filaDetalle.classList.contains('show')) {
                    filaDetalle.classList.add('show');
                }
                
                // Extraer el contenido del detalle
                const detalleContainer = filaDetalle.querySelector('.detail-container');
                if (detalleContainer) {
                    contenidoHTML += `
                        <div class="page-break">
                            ${detalleContainer.innerHTML}
                        </div>
                    `;
                }
            }
        });

        // Actualizar fecha de impresión
        const ahora = new Date();
        document.getElementById('fechaImpresion').textContent = ahora.toLocaleDateString('es-ES', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });

        // Insertar contenido
        document.getElementById('contenidoImpresion').innerHTML = contenidoHTML;
        
        // Mostrar contenido de impresión
        document.querySelector('.print-content').style.display = 'block';
        
        // Imprimir
        window.print();
        
        // Ocultar contenido de impresión después de imprimir
        setTimeout(() => {
            document.querySelector('.print-content').style.display = 'none';
        }, 1000);
    }

    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('show');
    }

    // Función para exportar a PDF (opcional)
    function exportarPDF() {
        // Esta función requeriría una librería como jsPDF o html2pdf
        // Por ahora, redirigimos a la función de impresión
        imprimirSeleccionados();
    }

    // Animaciones adicionales
    document.addEventListener('DOMContentLoaded', function() {
        // Animación de entrada para las tarjetas
        const cards = document.querySelectorAll('.filters-card, .table-container');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.6s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 200);
        });

        // Efecto hover en las filas de la tabla
        const filas = document.querySelectorAll('.fila-principal');
        filas.forEach(fila => {
            fila.addEventListener('mouseenter', function() {
                this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
            });
            
            fila.addEventListener('mouseleave', function() {
                this.style.boxShadow = 'none';
            });
        });
    });

    // Función para actualizar contadores en tiempo real
    function actualizarContadores() {
        const totalPrestamos = prestamosOriginales.length;
        const prestamosVisibles = prestamosOriginales.filter(p => 
            p.elemento.style.display !== 'none'
        ).length;
        
        document.getElementById('resultados-count').textContent = prestamosVisibles;
    }

    // Mejorar la experiencia de usuario con tooltips
    document.addEventListener('DOMContentLoaded', function() {
        // Agregar tooltips a los botones
        const tooltips = {
            '.btn-filter': 'Aplicar filtros de búsqueda',
            '.btn-clear': 'Limpiar todos los filtros',
            '.btn-print': 'Imprimir préstamos seleccionados',
            '.btn-detail': 'Ver detalles del préstamo'
        };

        Object.entries(tooltips).forEach(([selector, text]) => {
            document.querySelectorAll(selector).forEach(element => {
                element.setAttribute('title', text);
            });
        });
    });

    // Función para validar fechas
    function validarFechas() {
        const fechaDesde = document.getElementById('filterFechaDesde').value;
        const fechaHasta = document.getElementById('filterFechaHasta').value;
        
        if (fechaDesde && fechaHasta && fechaDesde > fechaHasta) {
            alert('La fecha "Desde" no puede ser mayor que la fecha "Hasta"');
            document.getElementById('filterFechaHasta').value = '';
            return false;
        }
        return true;
    }

    // Agregar validación a los campos de fecha
    document.getElementById('filterFechaDesde').addEventListener('change', validarFechas);
    document.getElementById('filterFechaHasta').addEventListener('change', validarFechas);

    // Función para guardar preferencias de filtros (localStorage)
    function guardarFiltros() {
        const filtros = {
            numero: document.getElementById('filterNumero').value,
            fechaDesde: document.getElementById('filterFechaDesde').value,
            fechaHasta: document.getElementById('filterFechaHasta').value,
            estado: document.getElementById('filterEstado').value
        };
        
        localStorage.setItem('filtrosReporte', JSON.stringify(filtros));
    }

    function cargarFiltros() {
        const filtrosGuardados = localStorage.getItem('filtrosReporte');
        if (filtrosGuardados) {
            const filtros = JSON.parse(filtrosGuardados);
            document.getElementById('filterNumero').value = filtros.numero || '';
            document.getElementById('filterFechaDesde').value = filtros.fechaDesde || '';
            document.getElementById('filterFechaHasta').value = filtros.fechaHasta || '';
            document.getElementById('filterEstado').value = filtros.estado || '';
        }
    }

    // Cargar filtros guardados al iniciar
    document.addEventListener('DOMContentLoaded', cargarFiltros);

    // Guardar filtros cuando cambien
    ['filterNumero', 'filterFechaDesde', 'filterFechaHasta', 'filterEstado'].forEach(id => {
        document.getElementById(id).addEventListener('change', guardarFiltros);
    });
</script>

</body>
</html>