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

        /* Estilos mejorados para el contenido */
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

        /* Estilos de impresión */
        @media print {
            body {
                font-family: 'Times New Roman', serif;
                margin: 0;
                padding: 0;
                font-size: 12px;
                line-height: 1.4;
                background: white !important;
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
            }

            .main-content {
                margin-left: 0 !important;
                padding: 0 !important;
            }

            @page {
                margin: 1.5cm;
                size: A4;
            }
        }
    </style>
</head>
<body>

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

<!-- Contenido principal mejorado -->
<div class="main-content">
    <!-- Header de la página -->
    <div class="page-header no-print">
        <h1 class="page-title">
            <i class="fas fa-money-bill-wave"></i>
            Préstamos Pendientes
        </h1>
    </div>

    <!-- Formulario de datos del prestamista -->
    <div class="form-card no-print">
        <div class="form-card-header">
            <i class="form-card-icon fas fa-user-tie"></i>
            <h3 class="form-card-title">Datos del Prestamista</h3>
        </div>
        
        <div class="row g-3">
            <div class="col-md-6">
                <label for="nombre-prestamista" class="form-label">
                    <i class="fas fa-user me-2"></i>Nombre del Prestamista
                </label>
                <input type="text" id="nombre-prestamista" class="form-control" placeholder="Nombre completo">
            </div>
            <div class="col-md-6">
                <label for="dni-prestamista" class="form-label">
                    <i class="fas fa-id-card me-2"></i>DNI del Prestamista
                </label>
                <input type="text" id="dni-prestamista" class="form-control" placeholder="12345678">
            </div>
        </div>
    </div>

    <!-- Formulario de condiciones del préstamo -->
    <div class="form-card no-print">
        <div class="form-card-header">
            <i class="form-card-icon fas fa-calculator"></i>
            <h3 class="form-card-title">Condiciones del Préstamo</h3>
        </div>
        
        <div class="row g-3">
            <div class="col-md-3">
                <label for="interes" class="form-label">
                    <i class="fas fa-percentage me-2"></i>Interés (%)
                </label>
                <input type="number" id="interes" class="form-control" placeholder="5" value="5">
            </div>
            <div class="col-md-3">
                <label for="penalidad" class="form-label">
                    <i class="fas fa-exclamation-circle me-2"></i>Penalidad (%)
                </label>
                <input type="number" id="penalidad" class="form-control" placeholder="2" value="2">
            </div>
            <div class="col-md-3">
                <label for="dias-plazo" class="form-label">
                    <i class="fas fa-calendar-alt me-2"></i>Días de plazo
                </label>
                <input type="number" id="dias-plazo" class="form-control" placeholder="28" value="28">
            </div>
            <div class="col-md-3">
                <label for="fecha-inicio" class="form-label">
                    <i class="fas fa-calendar-check me-2"></i>Fecha de Inicio
                </label>
                <input type="date" id="fecha-inicio" class="form-control">
            </div>
        </div>
        
        <div class="row g-3 mt-2">
            <div class="col-md-6">
                <label for="fecha-fin" class="form-label">
                    <i class="fas fa-calendar-times me-2"></i>Fecha de Vencimiento
                </label>
                <input type="date" id="fecha-fin" class="form-control" readonly>
            </div>
        </div>
    </div>

    <!-- Tabla de préstamos con tu lógica PHP original -->
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
                    Lista de Préstamos Pendientes
                </h3>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><i class="fas fa-hashtag me-2"></i>#</th>
                            <th><i class="fas fa-user me-2"></i>Usuario</th>
                            <th><i class="fas fa-file-invoice me-2"></i>N° Préstamo</th>
                            <th><i class="fas fa-money-bill me-2"></i>Monto</th>
                            <th><i class="fas fa-calendar me-2"></i>Fecha Inicio</th>
                            <th><i class="fas fa-info-circle me-2"></i>Estado</th>
                            <th><i class="fas fa-cogs me-2"></i>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prestamos as $index => $prestamo)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $prestamo->user->name }} {{ $prestamo->user->apellido_paterno }}</td>
                                <td><span class="badge bg-primary">{{ $prestamo->numero_prestamo }}</span></td>
                                <td><strong>S/ {{ number_format($prestamo->monto, 2) }}</strong></td>
                                <td>{{ $prestamo->fecha_inicio }}</td>
                                <td><span class="badge bg-warning text-dark">{{ ucfirst($prestamo->estado) }}</span></td>
                                <td>
                                    <button 
                                        class="btn btn-primary btn-sm"
                                        onclick="generarContrato({{ $prestamo->id }}, '{{ $prestamo->user->name }}', '{{ $prestamo->user->apellido_paterno }}', '{{ $prestamo->user->apellido_materno }}', '{{ $prestamo->user->nacionalidad }}', '{{ $prestamo->user->fecha_nacimiento }}', '{{ $prestamo->user->direccion }}', '{{ $prestamo->user->celular }}', '{{ $prestamo->numero_prestamo }}', '{{ $prestamo->monto }}', '{{ $prestamo->user->dni }}')"
                                    >
                                        <i class="fas fa-download me-1"></i>Descargar
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

<!-- Tu contrato original mantenido exactamente igual -->
<div id="formato-contrato" class="container" style="display: none; max-width: 800px; margin: 0 auto; padding: 40px; font-family: 'Times New Roman', serif; line-height: 1.6;">
    
    <!-- Encabezado -->
    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
        <h1 style="font-size: 24px; font-weight: bold; margin: 0; text-align: center; flex-grow: 1;">
            CONTRATO DE PRÉSTAMO
        </h1>
    </div>
    <div style="text-align: right; margin-left: 20px;">
        <strong>Fecha:</strong> <span id="fecha-contrato"></span>
    </div>

    <!-- Información de las partes -->
    <div style="margin-bottom: 25px;">
        <h3 style="font-size: 16px; font-weight: bold; margin-bottom: 15px;">LAS PARTES:</h3>

        <div style="display: flex; justify-content: space-between;">
            <!-- Prestamista a la izquierda -->
            <div style="width: 48%;">
                <strong>PRESTAMISTA:</strong><br>
                Nombre: <span id="nombre-prestamista-contrato"></span><br>
                DNI: <span id="dni-prestamista-contrato"></span>
            </div>

            <!-- Prestatario a la derecha -->
            <div style="width: 48%;">
                <strong>PRESTATARIO:</strong><br>
                Nombre: <span id="nombre-prestatario"></span><br>
                DNI: <span id="dni-prestatario"></span>
            </div>
        </div>
    </div>

    <!-- Cláusulas -->
    <div style="margin-bottom: 30px;">
        <h3 style="font-size: 16px; font-weight: bold; margin-bottom: 15px;">CLÁUSULAS:</h3>

        <div style="margin-bottom: 15px;">
            <strong>1. MONTO DEL PRÉSTAMO:</strong><br>
            El Prestamista otorga al Prestatario la suma de <strong>S/ <span id="monto-numeros"></span></strong> 
            (<span id="monto-letras"></span>) (en adelante, el "Principal").
        </div>

        <div style="margin-bottom: 15px;">
            <strong>2. PLAZO:</strong><br>
            Duración: <strong><span id="plazo-texto"></span></strong>, desde <strong><span id="fecha-inicio-contrato"></span></strong> 
            hasta <strong><span id="fecha-vencimiento-contrato"></span></strong>.
        </div>

        <div style="margin-bottom: 15px;">
            <strong>3. INTERÉS:</strong><br>
            Tasa fija del <strong><span id="tasa-interes"></span>%</strong> sobre el Principal.<br>
            Interés total: <strong>S/ <span id="monto-interes"></span></strong> (Principal × <span id="factor-interes"></span>).
        </div>

        <div style="margin-bottom: 15px;">
            <strong>4. PAGO TOTAL AL VENCIMIENTO:</strong><br>
            - Principal: S/ <span id="principal-pago"></span><br>
            - Interés: S/ <span id="interes-pago"></span><br>
            - <strong>Total: S/ <span id="total-pago"></span></strong>
        </div>

        <div style="margin-bottom: 15px;">
            <strong>5. FECHA LÍMITE:</strong><br>
            Pago máximo hasta: <strong><span id="fecha-limite"></span></strong> (inclusive).
        </div>
    </div>

    <!-- Nota sobre penalidad -->
    <div style="margin-bottom: 30px; padding: 10px; border: 1px solid #ccc; background-color: #f9f9f9;">
        <strong>NOTA IMPORTANTE:</strong> En caso de mora, se aplicará una penalidad del <strong><span id="penalidad-texto"></span>%</strong> 
        que se calcula exclusivamente sobre el interés. El vencimiento es de <strong><span id="dias-vencimiento"></span> días naturales</strong> 
        a partir de la fecha de firma del presente contrato.
    </div>

    <!-- Firmas -->
    <div style="display: flex; justify-content: space-between; margin-top: 60px;">
        <div style="text-align: center; width: 45%;">
            <div style="border-bottom: 1px solid #000; margin-bottom: 10px; height: 50px;"></div>
            <strong>PRESTAMISTA</strong><br>
            <span id="firma-prestamista"></span><br>
            DNI: <span id="dni-firma-prestamista"></span>
        </div>
        <div style="text-align: center; width: 45%;">
            <div style="border-bottom: 1px solid #000; margin-bottom: 10px; height: 50px;"></div>
            <strong>PRESTATARIO</strong><br>
            <span id="firma-prestatario"></span><br>
            DNI: <span id="dni-firma-prestatario"></span>
        </div>
    </div>
</div>

<!-- Tu JavaScript original mantenido exactamente igual -->
<script>
    // Función para convertir números a letras (básica)
    function numeroALetras(numero) {
        const unidades = ['', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
        const decenas = ['', '', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'];
        const centenas = ['', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos'];
        
        if (numero === 0) return 'cero';
        if (numero === 100) return 'cien';
        
        let resultado = '';
        
        if (numero >= 1000) {
            const miles = Math.floor(numero / 1000);
            if (miles === 1) {
                resultado += 'mil ';
            } else {
                resultado += numeroALetras(miles) + ' mil ';
            }
            numero %= 1000;
        }
        
        if (numero >= 100) {
            resultado += centenas[Math.floor(numero / 100)] + ' ';
            numero %= 100;
        }
        
        if (numero >= 20) {
            resultado += decenas[Math.floor(numero / 10)];
            if (numero % 10 !== 0) {
                resultado += ' y ' + unidades[numero % 10];
            }
        } else if (numero >= 10) {
            const especiales = ['diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve'];
            resultado += especiales[numero - 10];
        } else if (numero > 0) {
            resultado += unidades[numero];
        }
        
        return resultado.trim();
    }

    // Función para calcular fecha fin automáticamente
    document.getElementById('fecha-inicio').addEventListener('change', function() {
        const fechaInicio = new Date(this.value);
        const diasPlazo = parseInt(document.getElementById('dias-plazo').value) || 28;
        
        if (!isNaN(fechaInicio.getTime())) {
            const fechaFin = new Date(fechaInicio);
            fechaFin.setDate(fechaFin.getDate() + diasPlazo);
            
            document.getElementById('fecha-fin').value = fechaFin.toISOString().split('T')[0];
        }
    });

    // Función para calcular fecha fin cuando cambian los días
    document.getElementById('dias-plazo').addEventListener('change', function() {
        const fechaInicioValue = document.getElementById('fecha-inicio').value;
        if (fechaInicioValue) {
            const fechaInicio = new Date(fechaInicioValue);
            const diasPlazo = parseInt(this.value) || 28;
            
            const fechaFin = new Date(fechaInicio);
            fechaFin.setDate(fechaFin.getDate() + diasPlazo);
            
            document.getElementById('fecha-fin').value = fechaFin.toISOString().split('T')[0];
        }
    });

    // Establecer fecha de inicio por defecto (hoy)
    document.addEventListener('DOMContentLoaded', function() {
        const hoy = new Date();
        document.getElementById('fecha-inicio').value = hoy.toISOString().split('T')[0];
        
        // Calcular fecha fin automáticamente
        const diasPlazo = parseInt(document.getElementById('dias-plazo').value) || 28;
        const fechaFin = new Date(hoy);
        fechaFin.setDate(fechaFin.getDate() + diasPlazo);
        document.getElementById('fecha-fin').value = fechaFin.toISOString().split('T')[0];
    });

    function generarContrato(id, nombre, apePaterno, apeMaterno, nacionalidad, nacimiento, direccion, celular, numero, monto, dni) {
        // Validar campos requeridos
        const nombrePrestamista = document.getElementById("nombre-prestamista").value;
        const dniPrestamista = document.getElementById("dni-prestamista").value;
        const fechaInicio = document.getElementById("fecha-inicio").value;
        const fechaFin = document.getElementById("fecha-fin").value;
        
        if (!nombrePrestamista || !dniPrestamista || !fechaInicio || !fechaFin) {
            alert("Por favor, complete todos los campos requeridos (Nombre del prestamista, DNI del prestamista, fechas).");
            return;
        }

        const interes = parseFloat(document.getElementById("interes").value) || 5;
        const penalidad = parseFloat(document.getElementById("penalidad").value) || 2;
        const diasPlazo = parseInt(document.getElementById("dias-plazo").value) || 28;

        const fechaHoy = new Date();
        const fechaFormateada = fechaHoy.toLocaleDateString('es-PE', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            timeZone: 'America/Lima'
        });

        // Calcular montos
        const montoNumerico = parseFloat(monto);
        const montoInteres = montoNumerico * (interes / 100);
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

        // Llenar datos del contrato
        document.getElementById("fecha-contrato").textContent = fechaFormateada;
        
        // Prestamista
        document.getElementById("nombre-prestamista-contrato").textContent = nombrePrestamista;
        document.getElementById("dni-prestamista-contrato").textContent = dniPrestamista;
        document.getElementById("firma-prestamista").textContent = nombrePrestamista;
        document.getElementById("dni-firma-prestamista").textContent = dniPrestamista;
        
        // Prestatario
        const nombreCompleto = `${nombre} ${apePaterno} ${apeMaterno}`;
        document.getElementById("nombre-prestatario").textContent = nombreCompleto;
        document.getElementById("dni-prestatario").textContent = dni;
        document.getElementById("firma-prestatario").textContent = nombreCompleto;
        document.getElementById("dni-firma-prestatario").textContent = dni;

        // Montos
        document.getElementById("monto-numeros").textContent = montoNumerico.toFixed(2);
        document.getElementById("monto-letras").textContent = numeroALetras(Math.floor(montoNumerico)) + " soles";
        
        // Plazo
        const plazoTexto = diasPlazo === 28 ? "cuatro (4) semanas" : `${diasPlazo} días`;
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
        document.getElementById("dias-vencimiento").textContent = diasPlazo;

        // Mostrar contrato e imprimir
        document.getElementById("formato-contrato").style.display = "block";
        setTimeout(() => {
            window.print();
        }, 100);
    }

    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('show');
    }

    document.addEventListener("keydown", function(e) {
        if (e.ctrlKey && e.key === "p") {
            e.preventDefault();
            alert("Primero haz clic en 'Descargar' para generar el contrato.");
        }
    });
</script>

</body>
</html>
