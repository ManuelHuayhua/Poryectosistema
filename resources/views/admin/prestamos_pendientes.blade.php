<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Usuario - Préstamos Mejorado</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap y FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --sidebar-bg: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --primary-color: #667eea;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
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
            max-height: calc(100vh - 200px);
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

        .main-content {
            margin-left: 280px;
            padding: 2rem;
            transition: margin-left 0.3s ease;
            min-height: 100vh;
        }

        .page-header {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
            border-left: 5px solid var(--primary-color);
        }

        .page-title {
            color: #1f2937;
            font-weight: 700;
            font-size: 2rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .page-title i {
            color: var(--primary-color);
        }

        .form-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
        }

        .form-card-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f3f4f6;
        }

        .form-card-title {
            color: #1f2937;
            font-weight: 600;
            font-size: 1.25rem;
            margin: 0;
        }

        .form-card-icon {
            color: var(--primary-color);
            font-size: 1.5rem;
        }

        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .table-card {
            background: white;
            border-radius: 15px;
            padding: 0;
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }

        .table-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem 2rem;
            margin: 0;
        }

        .table-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .table-responsive {
            border-radius: 0 0 15px 15px;
        }

        .table {
            margin: 0;
        }

        .table th {
            background: #f8fafc;
            color: #374151;
            font-weight: 600;
            border: none;
            padding: 1rem;
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
            border-color: #f3f4f6;
        }

        .table tbody tr:hover {
            background-color: #f8fafc;
        }

        .btn {
            border-radius: 10px;
            padding: 0.5rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-primary {
            background: var(--primary-gradient);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .alert {
            border-radius: 15px;
            border: none;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .alert-info {
            background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
            color: #1e40af;
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
                border-radius: 10px;
                cursor: pointer;
                box-shadow: var(--card-shadow);
            }
            .page-header {
                padding: 1.5rem;
                margin-top: 4rem;
            }
            .page-title {
                font-size: 1.5rem;
            }
            .form-card {
                padding: 1.5rem;
            }
            .table-responsive {
                font-size: 0.9rem;
            }
        }

        @media (min-width: 769px) {
            .mobile-menu-toggle {
                display: none;
            }
        }

        /* Estilos de impresión mejorados */
        @media print {
            body {
                font-family: 'Times New Roman', serif !important;
                margin: 0 !important;
                padding: 0 !important;
                font-size: 12px !important;
                line-height: 1.4 !important;
                background: white !important;
                color: black !important;
            }
            
            /* Ocultar todo excepto el contrato */
            .sidebar,
            .mobile-menu-toggle,
            .no-print,
            .main-content > *:not(#formato-contrato) {
                display: none !important;
            }
            
            /* Mostrar solo el contrato */
            #formato-contrato {
                display: block !important;
                box-shadow: none !important;
                border: none !important;
                padding: 20px !important;
                margin: 0 !important;
                max-width: none !important;
                width: 100% !important;
                height: auto !important;
                font-family: 'Times New Roman', serif !important;
            }
            
            .main-content {
                margin-left: 0 !important;
                padding: 0 !important;
            }
            
            @page {
                margin: 1.5cm;
                size: A4;
            }
            
            /* Asegurar que el texto del contrato sea negro */
            #formato-contrato * {
                color: black !important;
                background: white !important;
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
            <a href="{{ route('admin.prestamos.pendientes') }}" class="nav-link active">
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
    <!-- Sección de Filtros -->
    <div class="form-card no-print" style="margin-bottom: 2rem;">
        <div class="form-card-header">
            <i class="fas fa-filter form-card-icon"></i>
            <h5 class="form-card-title">Filtros de Búsqueda</h5>
            <button class="btn btn-outline-secondary btn-sm ms-auto" onclick="limpiarFiltros()">
                <i class="fas fa-eraser me-1"></i>Limpiar Filtros
            </button>
        </div>
        
        <div class="row">
            <!-- Filtro por Usuario -->
            <div class="col-lg-3 col-md-6 mb-3">
                <label for="filtro-usuario" class="form-label">
                    <i class="fas fa-user me-1"></i>Usuario
                </label>
                <input type="text" id="filtro-usuario" class="form-control" 
                       placeholder="Buscar por nombre o apellido..." 
                       onkeyup="aplicarFiltros()">
            </div>
            
            <!-- Filtro por DNI -->
            <div class="col-lg-2 col-md-6 mb-3">
                <label for="filtro-dni" class="form-label">
                    <i class="fas fa-id-card me-1"></i>DNI
                </label>
                <input type="text" id="filtro-dni" class="form-control" 
                       placeholder="DNI..." 
                       onkeyup="aplicarFiltros()">
            </div>
            
            <!-- Filtro por Número de Préstamo -->
            <div class="col-lg-2 col-md-6 mb-3">
                <label for="filtro-numero" class="form-label">
                    <i class="fas fa-hashtag me-1"></i>N° Préstamo
                </label>
                <input type="text" id="filtro-numero" class="form-control" 
                       placeholder="Número..." 
                       onkeyup="aplicarFiltros()">
            </div>
            
            <!-- Filtro por Estado -->
            <div class="col-lg-2 col-md-6 mb-3">
                <label for="filtro-estado" class="form-label">
                    <i class="fas fa-info-circle me-1"></i>Estado
                </label>
                <select id="filtro-estado" class="form-select" onchange="aplicarFiltros()">
                    <option value="">Todos los estados</option>
                    <option value="aprobado">Aprobado</option>
                   
                    <option value="pagado">Pagado</option>
                    
                  
                </select>
            </div>
            
            <!-- Filtro por Interés -->
            <div class="col-lg-3 col-md-6 mb-3">
                <label for="filtro-interes" class="form-label">
                    <i class="fas fa-percentage me-1"></i>Interés
                </label>
                <select id="filtro-interes" class="form-select" onchange="aplicarFiltros()">
                    <option value="">Todos los intereses</option>
                    <option value="5">5%</option>
                    <option value="10">10%</option>
                    <option value="15">15%</option>
                    <option value="20">20%</option>
                    <option value="25">25%</option>
                </select>
            </div>
        </div>
        
        <div class="row">
            <!-- Rango de Monto -->
            <div class="col-lg-3 col-md-6 mb-3">
                <label class="form-label">
                    <i class="fas fa-money-bill me-1"></i>Rango de Monto
                </label>
                <div class="row">
                    <div class="col-6">
                        <input type="number" id="filtro-monto-min" class="form-control" 
                               placeholder="Mínimo" onkeyup="aplicarFiltros()">
                    </div>
                    <div class="col-6">
                        <input type="number" id="filtro-monto-max" class="form-control" 
                               placeholder="Máximo" onkeyup="aplicarFiltros()">
                    </div>
                </div>
            </div>
            
            <!-- Rango de Fecha Inicio -->
            <div class="col-lg-3 col-md-6 mb-3">
                <label class="form-label">
                    <i class="fas fa-calendar-alt me-1"></i>Fecha Inicio
                </label>
                <div class="row">
                    <div class="col-6">
                        <input type="date" id="filtro-fecha-inicio-desde" class="form-control" 
                               onchange="aplicarFiltros()">
                    </div>
                    <div class="col-6">
                        <input type="date" id="filtro-fecha-inicio-hasta" class="form-control" 
                               onchange="aplicarFiltros()">
                    </div>
                </div>
                <small class="text-muted">Desde - Hasta</small>
            </div>
            
            <!-- Rango de Fecha Fin -->
            <div class="col-lg-3 col-md-6 mb-3">
                <label class="form-label">
                    <i class="fas fa-calendar-check me-1"></i>Fecha Fin
                </label>
                <div class="row">
                    <div class="col-6">
                        <input type="date" id="filtro-fecha-fin-desde" class="form-control" 
                               onchange="aplicarFiltros()">
                    </div>
                    <div class="col-6">
                        <input type="date" id="filtro-fecha-fin-hasta" class="form-control" 
                               onchange="aplicarFiltros()">
                    </div>
                </div>
                <small class="text-muted">Desde - Hasta</small>
            </div>
            
            <!-- Contador de resultados -->
            <div class="col-lg-3 col-md-6 mb-3 d-flex align-items-end">
                <div class="w-100">
                    <div class="alert alert-info mb-0 py-2">
                        <i class="fas fa-search me-2"></i>
                        <span id="contador-resultados">Mostrando todos los préstamos</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Tabla de préstamos -->
    @if($prestamos->isEmpty())
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            No hay préstamos pendientes.
        </div>
    @else
        <div class="table-card no-print">
            <div class="table-header">
                <h3 class="table-title">
                    <i class="fas fa-list"></i>
                    Lista de Préstamos Aprobados
                </h3>
                <button class="btn btn-outline-light btn-sm" onclick="exportarFiltrados()">
                    <i class="fas fa-file-export me-1"></i>Exportar Filtrados
                </button>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover" id="tabla-prestamos">
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag me-2"></i>#</th>
                            <th><i class="fas fa-user me-2"></i>Usuario</th>
                            <th><i class="fas fa-file-invoice me-2"></i>N° Préstamo</th>
                            <th><i class="fas fa-money-bill me-2"></i>Monto</th>
                            <th><i class="fas fa-calendar me-2"></i>Fecha Inicio</th>
                            <th><i class="fas fa-calendar me-2"></i>Fecha Fin</th>
                            <th><i class="fas fa-percentage me-2"></i>Interés</th>
                            <th><i class="fas fa-info-circle me-2"></i>Estado</th>
                            <th><i class="fas fa-cogs me-2"></i>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prestamos as $index => $prestamo)
                            <tr data-dni="{{ $prestamo->user->dni ?? '' }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $prestamo->user->name }} {{ $prestamo->user->apellido_paterno }}</td>
                                <td><span class="badge bg-primary">{{ $prestamo->numero_prestamo }}</span></td>
                                <td><strong>S/ {{ number_format($prestamo->monto, 2) }}</strong></td>
                                <td>{{ \Carbon\Carbon::parse($prestamo->fecha_inicio)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($prestamo->fecha_fin)->format('d/m/Y') }}</td>
                                <td>{{ $prestamo->interes }}%</td>
                                <td><span class="badge bg-success">{{ ucfirst($prestamo->estado) }}</span></td>
                                <td>
                                    <button
                                        class="btn btn-primary btn-sm"
                                        onclick="generarContrato(
                                            '{{ $prestamo->user->name }}',
                                            '{{ $prestamo->user->apellido_paterno ?? '' }}',
                                            '{{ $prestamo->user->apellido_materno ?? '' }}',
                                            '{{ $prestamo->user->dni ?? '' }}',
                                            '{{ $prestamo->numero_prestamo }}',
                                            {{ $prestamo->monto }},
                                            '{{ $prestamo->fecha_inicio }}',
                                            '{{ $prestamo->fecha_fin }}',
                                            {{ $prestamo->interes }},
                                            {{ $prestamo->porcentaje_penalidad ?? 2 }},
                                            {{ $prestamo->interes_pagar ?? ($prestamo->monto * $prestamo->interes / 100) }}
                                        )"
                                    >
                                        <i class="fas fa-download me-1"></i>Descargar Contrato
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Formato del contrato (oculto inicialmente) -->
    <div id="formato-contrato" class="container" style="display: none; max-width: 800px; margin: 0 auto; padding: 40px; font-family: 'Times New Roman', serif; line-height: 1.6;">
        <!-- Encabezado -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
            <h1 style="font-size: 24px; font-weight: bold; margin: 0; text-align: center; flex-grow: 1; text-transform: uppercase;">
                CONTRATO DE PRÉSTAMO
            </h1>
        </div>
        <div style="text-align: right; margin-bottom: 20px;">
            <strong>Fecha:</strong> <span id="fecha-contrato"></span>
        </div>

        <!-- Información de las partes -->
        <div style="margin-bottom: 25px;">
            <h3 style="font-size: 16px; font-weight: bold; margin-bottom: 15px; text-decoration: underline;">LAS PARTES:</h3>
            <div style="margin-bottom: 15px;">
                <strong>PRESTAMISTA:</strong> Banquito
            </div>
            <div>
                <strong>PRESTATARIO:</strong> <span id="nombre-prestatario"></span>, DNI: <span id="dni-prestatario"></span>
            </div>
        </div>

        <!-- Cláusulas -->
        <div style="margin-bottom: 30px;">
            <h3 style="font-size: 16px; font-weight: bold; margin-bottom: 15px; text-decoration: underline;">CLÁUSULAS:</h3>
            
            <div style="margin-bottom: 15px; text-align: justify;">
                <strong>1. MONTO DEL PRÉSTAMO:</strong><br>
                El Prestamista otorga al Prestatario la suma de <strong>S/ <span id="monto-numeros"></span></strong>
                (<span id="monto-letras"></span>) (en adelante, el "Principal").
            </div>

            <div style="margin-bottom: 15px; text-align: justify;">
                <strong>2. PLAZO:</strong><br>
                Duración: <strong><span id="plazo-texto"></span></strong>, desde <strong><span id="fecha-inicio-contrato"></span></strong>
                hasta <strong><span id="fecha-vencimiento-contrato"></span></strong>.
            </div>

            <div style="margin-bottom: 15px; text-align: justify;">
                <strong>3. INTERÉS:</strong><br>
                Tasa fija del <strong><span id="tasa-interes"></span>%</strong> sobre el Principal.<br>
                Interés total: <strong>S/ <span id="monto-interes"></span></strong> (Principal × <span id="factor-interes"></span>).
            </div>

            <div style="margin-bottom: 15px; text-align: justify;">
                <strong>4. PAGO TOTAL AL VENCIMIENTO:</strong><br>
                - Principal: <strong>S/ <span id="principal-pago"></span></strong><br>
                - Interés: <strong>S/ <span id="interes-pago"></span></strong><br>
                - <strong>Total: S/ <span id="total-pago"></span></strong>
            </div>

            <div style="margin-bottom: 15px; text-align: justify;">
                <strong>5. FECHA LÍMITE:</strong><br>
                Pago máximo hasta: <strong><span id="fecha-limite"></span></strong> (inclusive).
            </div>
        </div>

        <!-- Nota sobre penalidad -->
        <div style="margin-bottom: 30px; padding: 15px; border: 2px solid #333; background-color: #f9f9f9; border-radius: 5px;">
            <strong>NOTA IMPORTANTE:</strong> En caso de mora, se aplicará una penalidad del <strong><span id="penalidad-texto"></span>%</strong>
            que se calcula exclusivamente sobre el interés. El vencimiento es de <strong><span id="dias-vencimiento"></span> días naturales</strong>
            a partir de la fecha de firma del presente contrato.
        </div>

        <!-- Firmas -->
        <div style="display: flex; justify-content: space-between; margin-top: 60px;">
            <div style="text-align: center; width: 45%;">
                <div style="border-bottom: 2px solid #000; margin-bottom: 10px; height: 60px;"></div>
                <strong>PRESTAMISTA</strong><br>
                Banquito
            </div>
            <div style="text-align: center; width: 45%;">
                <div style="border-bottom: 2px solid #000; margin-bottom: 10px; height: 60px;"></div>
                <strong>PRESTATARIO</strong><br>
                <span id="firma-prestatario"></span><br>
                DNI: <span id="dni-firma-prestatario"></span>
            </div>
        </div>
    </div>
</div>

<script>
    // Función para convertir números a letras
    function numeroALetras(numero) {
        const unidades = ['', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
        const decenas = ['', '', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'];
        const centenas = ['', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos'];
        const especiales = ['diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve'];
        
        if (numero === 0) return 'cero';
        if (numero === 100) return 'cien';
        if (numero === 1000) return 'mil';
        
        let resultado = '';
        
        // Miles
        if (numero >= 1000) {
            const miles = Math.floor(numero / 1000);
            if (miles === 1) {
                resultado += 'mil ';
            } else {
                resultado += numeroALetras(miles) + ' mil ';
            }
            numero %= 1000;
        }
        
        // Centenas
        if (numero >= 100) {
            const cent = Math.floor(numero / 100);
            resultado += centenas[cent] + ' ';
            numero %= 100;
        }
        
        // Decenas y unidades
        if (numero >= 20) {
            const dec = Math.floor(numero / 10);
            const uni = numero % 10;
            resultado += decenas[dec];
            if (uni > 0) {
                resultado += ' y ' + unidades[uni];
            }
        } else if (numero >= 10) {
            resultado += especiales[numero - 10];
        } else if (numero > 0) {
            resultado += unidades[numero];
        }
        
        return resultado.trim();
    }

    // Función principal para generar el contrato
    function generarContrato(nombre, apePaterno, apeMaterno, dni, numeroPrestamo, monto, fechaInicio, fechaFin, interes, penalidad, interesPagar) {
        // Fecha actual
        const fechaHoy = new Date();
        const fechaFormateada = fechaHoy.toLocaleDateString('es-PE', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            timeZone: 'America/Lima'
        });

        // Calcular montos
        const montoNumerico = parseFloat(monto);
        const montoInteres = parseFloat(interesPagar);
        const montoTotal = montoNumerico + montoInteres;

        // Formatear fechas
        const fechaInicioFormateada = new Date(fechaInicio).toLocaleDateString('es-PE', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        
        const fechaFinFormateada = new Date(fechaFin).toLocaleDateString('es-PE', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        // Calcular duración
        const inicio = new Date(fechaInicio);
        const fin = new Date(fechaFin);
        const duracionDias = Math.ceil((fin - inicio) / (1000 * 60 * 60 * 24));
        const duracionSemanas = Math.ceil(duracionDias / 7);

        // Llenar datos del contrato
        document.getElementById("fecha-contrato").textContent = fechaFormateada;

        // Prestatario
        const nombreCompleto = `${nombre} ${apePaterno} ${apeMaterno}`.trim();
        document.getElementById("nombre-prestatario").textContent = nombreCompleto;
        document.getElementById("dni-prestatario").textContent = dni;
        document.getElementById("firma-prestatario").textContent = nombreCompleto;
        document.getElementById("dni-firma-prestatario").textContent = dni;

        // Montos
        document.getElementById("monto-numeros").textContent = montoNumerico.toFixed(2);
        document.getElementById("monto-letras").textContent = numeroALetras(Math.floor(montoNumerico)) + " soles";

        // Plazo
        const plazoTexto = duracionSemanas === 4 ? "cuatro (4) semanas" : 
                          duracionSemanas === 1 ? "una (1) semana" : 
                          `${duracionSemanas} semanas`;
        document.getElementById("plazo-texto").textContent = plazoTexto;
        document.getElementById("fecha-inicio-contrato").textContent = fechaInicioFormateada;
        document.getElementById("fecha-vencimiento-contrato").textContent = fechaFinFormateada;
        document.getElementById("fecha-limite").textContent = fechaFinFormateada;

        // Interés
        document.getElementById("tasa-interes").textContent = interes;
        document.getElementById("monto-interes").textContent = montoInteres.toFixed(2);
        document.getElementById("factor-interes").textContent = (interes / 100).toFixed(2);

        // Pago total
        document.getElementById("principal-pago").textContent = montoNumerico.toFixed(2);
        document.getElementById("interes-pago").textContent = montoInteres.toFixed(2);
        document.getElementById("total-pago").textContent = montoTotal.toFixed(2);

        // Penalidad y días
        document.getElementById("penalidad-texto").textContent = penalidad;
        document.getElementById("dias-vencimiento").textContent = duracionDias;

        // Mostrar contrato y preparar para imprimir
        document.getElementById("formato-contrato").style.display = "block";
        
        // Scroll al contrato
        document.getElementById("formato-contrato").scrollIntoView({ 
            behavior: 'smooth' 
        });

        // Activar impresión automáticamente después de un breve delay
        setTimeout(() => {
            window.print();
        }, 500);
    }

    // Función para toggle del sidebar en móviles
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('show');
    }

    // Interceptar Ctrl+P para mostrar mensaje si no hay contrato visible
    document.addEventListener("keydown", function(e) {
        if (e.ctrlKey && e.key === "p") {
            const contrato = document.getElementById("formato-contrato");
            if (contrato.style.display === "none" || !contrato.style.display) {
                e.preventDefault();
                alert("Primero haz clic en 'Descargar Contrato' para generar el contrato.");
            }
            // Si el contrato está visible, permitir la impresión normal
        }
    });

    // Función para ocultar el contrato y volver a la tabla
    function volverATabla() {
        document.getElementById("formato-contrato").style.display = "none";
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Agregar botón para volver (opcional)
    document.addEventListener('DOMContentLoaded', function() {
        const contrato = document.getElementById("formato-contrato");
        if (contrato) {
            const botonVolver = document.createElement('button');
            botonVolver.innerHTML = '<i class="fas fa-arrow-left me-2"></i>Volver a la lista';
            botonVolver.className = 'btn btn-secondary no-print';
            botonVolver.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 1000;';
            botonVolver.onclick = volverATabla;
            contrato.appendChild(botonVolver);
        }
    });

    // Variables globales para filtros
    let prestamosOriginales = [];
    let prestamosFiltrados = [];

    // Inicializar filtros cuando se carga la página
    document.addEventListener('DOMContentLoaded', function() {
        // Guardar datos originales de la tabla
        const filas = document.querySelectorAll('#tabla-prestamos tbody tr');
        prestamosOriginales = Array.from(filas).map(fila => {
            const celdas = fila.querySelectorAll('td');
            return {
                elemento: fila,
                usuario: celdas[1].textContent.trim().toLowerCase(),
                numeroPrestamo: celdas[2].textContent.trim().toLowerCase(),
                monto: parseFloat(celdas[3].textContent.replace(/[^\d.-]/g, '')),
                fechaInicio: celdas[4].textContent.trim(),
                fechaFin: celdas[5].textContent.trim(),
                interes: parseInt(celdas[6].textContent.replace('%', '')),
                estado: celdas[7].textContent.trim().toLowerCase(),
                dni: fila.dataset.dni || '' // Asumiendo que agregas data-dni a las filas
            };
        });
        
        prestamosFiltrados = [...prestamosOriginales];
        actualizarContador();
    });

    // Función principal para aplicar todos los filtros
    function aplicarFiltros() {
        const filtros = {
            usuario: document.getElementById('filtro-usuario').value.toLowerCase().trim(),
            dni: document.getElementById('filtro-dni').value.toLowerCase().trim(),
            numero: document.getElementById('filtro-numero').value.toLowerCase().trim(),
            estado: document.getElementById('filtro-estado').value.toLowerCase(),
            interes: document.getElementById('filtro-interes').value,
            montoMin: parseFloat(document.getElementById('filtro-monto-min').value) || 0,
            montoMax: parseFloat(document.getElementById('filtro-monto-max').value) || Infinity,
            fechaInicioDesde: document.getElementById('filtro-fecha-inicio-desde').value,
            fechaInicioHasta: document.getElementById('filtro-fecha-inicio-hasta').value,
            fechaFinDesde: document.getElementById('filtro-fecha-fin-desde').value,
            fechaFinHasta: document.getElementById('filtro-fecha-fin-hasta').value
        };
        
        prestamosFiltrados = prestamosOriginales.filter(prestamo => {
            // Filtro por usuario (nombre y apellidos)
            if (filtros.usuario && !prestamo.usuario.includes(filtros.usuario)) {
                return false;
            }
            
            // Filtro por DNI
            if (filtros.dni && !prestamo.dni.includes(filtros.dni)) {
                return false;
            }
            
            // Filtro por número de préstamo
            if (filtros.numero && !prestamo.numeroPrestamo.includes(filtros.numero)) {
                return false;
            }
            
            // Filtro por estado
            if (filtros.estado && !prestamo.estado.includes(filtros.estado)) {
                return false;
            }
            
            // Filtro por interés
            if (filtros.interes && prestamo.interes !== parseInt(filtros.interes)) {
                return false;
            }
            
            // Filtro por rango de monto
            if (prestamo.monto < filtros.montoMin || prestamo.monto > filtros.montoMax) {
                return false;
            }
            
            // Filtro por rango de fecha inicio
            if (filtros.fechaInicioDesde || filtros.fechaInicioHasta) {
                const fechaInicio = new Date(convertirFecha(prestamo.fechaInicio));
                if (filtros.fechaInicioDesde && fechaInicio < new Date(filtros.fechaInicioDesde)) {
                    return false;
                }
                if (filtros.fechaInicioHasta && fechaInicio > new Date(filtros.fechaInicioHasta)) {
                    return false;
                }
            }
            
            // Filtro por rango de fecha fin
            if (filtros.fechaFinDesde || filtros.fechaFinHasta) {
                const fechaFin = new Date(convertirFecha(prestamo.fechaFin));
                if (filtros.fechaFinDesde && fechaFin < new Date(filtros.fechaFinDesde)) {
                    return false;
                }
                if (filtros.fechaFinHasta && fechaFin > new Date(filtros.fechaFinHasta)) {
                    return false;
                }
            }
            
            return true;
        });
        
        // Mostrar/ocultar filas según filtros
        prestamosOriginales.forEach(prestamo => {
            if (prestamosFiltrados.includes(prestamo)) {
                prestamo.elemento.style.display = '';
            } else {
                prestamo.elemento.style.display = 'none';
            }
        });
        
        actualizarContador();
        
        // Efecto visual para indicar que se aplicaron filtros
        const tabla = document.querySelector('.table-card');
        tabla.style.transform = 'scale(0.98)';
        setTimeout(() => {
            tabla.style.transform = 'scale(1)';
        }, 150);
    }

    // Función para convertir fecha de formato dd/mm/yyyy a yyyy-mm-dd
    function convertirFecha(fechaTexto) {
        const partes = fechaTexto.split('/');
        if (partes.length === 3) {
            return `${partes[2]}-${partes[1].padStart(2, '0')}-${partes[0].padStart(2, '0')}`;
        }
        return fechaTexto;
    }

    // Función para limpiar todos los filtros
    function limpiarFiltros() {
        document.getElementById('filtro-usuario').value = '';
        document.getElementById('filtro-dni').value = '';
        document.getElementById('filtro-numero').value = '';
        document.getElementById('filtro-estado').value = '';
        document.getElementById('filtro-interes').value = '';
        document.getElementById('filtro-monto-min').value = '';
        document.getElementById('filtro-monto-max').value = '';
        document.getElementById('filtro-fecha-inicio-desde').value = '';
        document.getElementById('filtro-fecha-inicio-hasta').value = '';
        document.getElementById('filtro-fecha-fin-desde').value = '';
        document.getElementById('filtro-fecha-fin-hasta').value = '';
        
        // Mostrar todas las filas
        prestamosOriginales.forEach(prestamo => {
            prestamo.elemento.style.display = '';
        });
        
        prestamosFiltrados = [...prestamosOriginales];
        actualizarContador();
        
        // Efecto visual
        const filtrosCard = document.querySelector('.form-card');
        filtrosCard.style.backgroundColor = '#e8f5e8';
        setTimeout(() => {
            filtrosCard.style.backgroundColor = '';
        }, 500);
    }

    // Función para actualizar el contador de resultados
    function actualizarContador() {
        const contador = document.getElementById('contador-resultados');
        const total = prestamosOriginales.length;
        const mostrados = prestamosFiltrados.length;
        
        if (mostrados === total) {
            contador.textContent = `Mostrando todos los préstamos (${total})`;
            contador.parentElement.className = 'alert alert-info mb-0 py-2';
        } else {
            contador.textContent = `Mostrando ${mostrados} de ${total} préstamos`;
            contador.parentElement.className = 'alert alert-success mb-0 py-2';
        }
    }

    // Función para exportar resultados filtrados (bonus)
    function exportarFiltrados() {
        if (prestamosFiltrados.length === 0) {
            alert('No hay resultados para exportar');
            return;
        }
        
        let csv = 'Usuario,Número Préstamo,Monto,Fecha Inicio,Fecha Fin,Interés,Estado\n';
        
        prestamosFiltrados.forEach(prestamo => {
            const celdas = prestamo.elemento.querySelectorAll('td');
            csv += `"${celdas[1].textContent}","${celdas[2].textContent}","${celdas[3].textContent}","${celdas[4].textContent}","${celdas[5].textContent}","${celdas[6].textContent}","${celdas[7].textContent}"\n`;
        });
        
        const blob = new Blob([csv], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `prestamos_filtrados_${new Date().toISOString().split('T')[0]}.csv`;
        a.click();
        window.URL.revokeObjectURL(url);
    }
</script>

</body>
</html>
