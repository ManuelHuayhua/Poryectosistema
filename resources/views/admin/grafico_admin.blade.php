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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --sidebar-bg: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
            --success-gradient: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --info-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
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

        /* Bubble Cards Styles */
        .stats-bubbles {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .bubble-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .bubble-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .bubble-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
        }

        .bubble-card.success::before {
            background: var(--success-gradient);
        }

        .bubble-card.info::before {
            background: var(--info-gradient);
        }

        .bubble-card.warning::before {
            background: var(--warning-gradient);
        }

        .bubble-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
            color: white;
        }

        .bubble-card.success .bubble-icon {
            background: var(--success-gradient);
        }

        .bubble-card.info .bubble-icon {
            background: var(--info-gradient);
        }

        .bubble-card.warning .bubble-icon {
            background: var(--warning-gradient);
        }

        .bubble-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .bubble-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .bubble-subtitle {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .eye-toggle {
            background: none;
            border: none;
            color: #6c757d;
            font-size: 1.2rem;
            cursor: pointer;
            margin-left: 0.5rem;
            transition: color 0.3s ease;
        }

        .eye-toggle:hover {
            color: #495057;
        }

        .hidden-value {
            display: none;
        }

        /* Chart Container - TAMAÑO FIJO */
        .chart-container {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            margin-top: 2rem;
            width: 100%;
            max-width: 100%;
        }

        .chart-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        /* CONTENEDOR DEL CANVAS CON TAMAÑO FIJO */
        .chart-wrapper {
            position: relative;
            height: 400px;
            width: 100%;
            max-width: 100%;
        }

        #prestamosChart {
            max-width: 100% !important;
            max-height: 400px !important;
        }

        /* Filter Form */
        .filter-form {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
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
            }

            .stats-bubbles {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .bubble-card {
                padding: 1.5rem;
            }

            .bubble-value {
                font-size: 2rem;
            }

            /* Gráfico más pequeño en móviles */
            .chart-wrapper {
                height: 300px;
            }
        }

        @media (min-width: 769px) {
            .mobile-menu-toggle {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .filter-form .row {
                flex-direction: column;
            }
            
            .filter-form .col-auto {
                margin-bottom: 1rem;
            }

            .chart-wrapper {
                height: 250px;
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
            <a href="{{ route('indexAdmin') }}" class="nav-link ">
                <i class="fas fa-home"></i><span>Inicio</span>
            </a>
        </div>
            <div class="nav-item">
            <a href="{{ route('admin.graficos') }}" class="nav-link active">
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
    <!-- Formulario de filtros -->
    <div class="filter-form">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-auto">
                <label for="desde" class="form-label mb-1">Desde</label>
                <input type="date" id="desde" name="desde"
                       class="form-control"
                       value="{{ $desde }}">
            </div>

            <div class="col-auto">
                <label for="hasta" class="form-label mb-1">Hasta</label>
                <input type="date" id="hasta" name="hasta"
                       class="form-control"
                       value="{{ $hasta }}">
            </div>

            <div class="col-auto">
                <button class="btn btn-primary">
                    <i class="fas fa-filter me-2"></i>Aplicar
                </button>
            </div>
        </form>
    </div>

    <!-- Tarjetas de estadísticas (Bubbles) -->
    <div class="stats-bubbles">
        <!-- Préstamos aprobados -->
        <div class="bubble-card success">
            <div class="bubble-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="bubble-title">Préstamos aprobados</div>
            <div class="bubble-value">{{ $totalPrestamosAprobados }}</div>
            <div class="bubble-subtitle">
                Del {{ \Carbon\Carbon::parse($desde)->isoFormat('DD/MM/YYYY') }}
                al {{ \Carbon\Carbon::parse($hasta)->isoFormat('DD/MM/YYYY') }}
            </div>
        </div>

        <!-- Usuarios con préstamo -->
        <div class="bubble-card info">
            <div class="bubble-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="bubble-title">Usuarios con préstamo</div>
            <div class="bubble-value">{{ $usuariosConPrestamo }}</div>
            <div class="bubble-subtitle">
                Del {{ \Carbon\Carbon::parse($desde)->isoFormat('DD/MM/YYYY') }}
                al {{ \Carbon\Carbon::parse($hasta)->isoFormat('DD/MM/YYYY') }}
            </div>
        </div>

        <!-- Saldo final -->
        <div class="bubble-card warning">
            <div class="bubble-icon">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="bubble-title">
                Saldo final
                <button class="eye-toggle" onclick="toggleBalance()" id="eyeToggle">
                    <i class="fas fa-eye-slash"></i>
                </button>
            </div>
            <div class="bubble-value">
                <span id="hiddenBalance" class="hidden-value">
                    {{ $saldoFinal !== null ? number_format($saldoFinal, 2, '.', ',') : '–' }}
                </span>
                <span id="maskedBalance">••••••</span>
            </div>
            <div class="bubble-subtitle">Último dentro del rango</div>
        </div>
    </div>

    <!-- Gráfico de barras -->
    @if($prestamosPorDia->isNotEmpty())
        <div class="chart-container">
            <h3 class="chart-title">
                <i class="fas fa-chart-bar me-2"></i>
                Préstamos y Usuarios por Día
            </h3>
            <div class="chart-wrapper">
                <canvas id="prestamosChart"></canvas>
            </div>
        </div>
    @else
        <div class="chart-container text-center">
            <i class="fas fa-chart-bar fa-3x text-muted mb-3"></i>
            <h4 class="text-muted">No hay datos para mostrar</h4>
            <p class="text-muted">No hubo préstamos aprobados en este rango de fechas.</p>
        </div>
    @endif
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('show');
    }

    function toggleBalance() {
        const hiddenBalance = document.getElementById('hiddenBalance');
        const maskedBalance = document.getElementById('maskedBalance');
        const eyeToggle = document.getElementById('eyeToggle');
        const eyeIcon = eyeToggle.querySelector('i');

        if (hiddenBalance.classList.contains('hidden-value')) {
            // Mostrar saldo
            hiddenBalance.classList.remove('hidden-value');
            maskedBalance.style.display = 'none';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        } else {
            // Ocultar saldo
            hiddenBalance.classList.add('hidden-value');
            maskedBalance.style.display = 'inline';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        }
    }

    // Gráfico de barras - CONFIGURACIÓN ESTÁTICA
    @if($prestamosPorDia->isNotEmpty())
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('prestamosChart').getContext('2d');
    
    // Preparar los datos desde PHP
    const chartData = [
        @foreach($prestamosPorDia as $dia)
        {
            fecha: '{{ \Carbon\Carbon::parse($dia->dia)->isoFormat("DD/MM/YYYY") }}',
            fechaCorta: '{{ \Carbon\Carbon::parse($dia->dia)->isoFormat("DD/MM") }}',
            prestamos: {{ $dia->total_prestamos }},
            usuarios: {{ $dia->total_usuarios }}
        },
        @endforeach
    ];

    const labels = chartData.map(item => item.fechaCorta);
    const prestamosData = chartData.map(item => item.prestamos);
    const usuariosData = chartData.map(item => item.usuarios);

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Préstamos Aprobados',
                    data: prestamosData,
                    backgroundColor: 'rgba(102, 126, 234, 0.8)',
                    borderColor: 'rgba(102, 126, 234, 1)',
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                },
                {
                    label: 'Usuarios',
                    data: usuariosData,
                    backgroundColor: 'rgba(56, 239, 125, 0.8)',
                    borderColor: 'rgba(56, 239, 125, 1)',
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true, // CAMBIADO A TRUE
            aspectRatio: 2, // RELACIÓN DE ASPECTO FIJA
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            size: 14,
                            weight: '600'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.9)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    borderColor: 'rgba(255, 255, 255, 0.2)',
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: true,
                    callbacks: {
                        title: function(context) {
                            const index = context[0].dataIndex;
                            return 'Fecha: ' + chartData[index].fecha;
                        },
                        label: function(context) {
                            const label = context.dataset.label;
                            const value = context.parsed.y;
                            return label + ': ' + value;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)',
                        drawBorder: false
                    },
                    ticks: {
                        font: {
                            size: 12
                        },
                        color: '#6c757d',
                        stepSize: 1
                    },
                    title: {
                        display: true,
                        text: 'Cantidad',
                        font: {
                            size: 14,
                            weight: '600'
                        },
                        color: '#495057'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 12
                        },
                        color: '#6c757d',
                        maxRotation: 45
                    },
                    title: {
                        display: true,
                        text: 'Fechas',
                        font: {
                            size: 14,
                            weight: '600'
                        },
                        color: '#495057'
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
});
@endif
</script>

</body>
</html>