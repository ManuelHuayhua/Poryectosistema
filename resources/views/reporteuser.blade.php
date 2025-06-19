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
            <a href="{{ route('home') }}" class="nav-link"><i class="fas fa-home"></i><span>Inicio</span></a>
        </div>
        <div class="nav-item">
            <a href="{{ route('perfil') }}" class="nav-link"><i class="fas fa-user-circle"></i><span>Perfil</span></a>
        </div>
        <div class="nav-item">
            <a href="#" class="nav-link"><i class="fas fa-download"></i><span>Descargas</span></a>
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
<div class="container my-4">
    <h1 class="text-center mb-4">📄 Reporte de Préstamos</h1>

    <div class="mb-3 no-print text-end">
        <button onclick="imprimirSeleccionados()" class="btn btn-success">🖨️ Imprimir Seleccionados</button>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-dark text-center align-middle">
            <tr>
                <th></th>
                <th>N° Préstamo</th>
                <th>Fecha Último Préstamo</th>
                <th>Fecha Último Pago</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($prestamos as $numero_prestamo => $registros)
                @php
                    $ultimo = $registros->sortByDesc('fecha_inicio')->first();
                @endphp

                <tr class="fila-principal-{{ $numero_prestamo }}">
                    <td class="text-center">
                        <input type="checkbox" class="seleccionar-reporte" data-target="{{ $numero_prestamo }}">
                    </td>
                    <td>{{ $numero_prestamo }}</td>
                    <td>{{ $ultimo->fecha_inicio }}</td>
                    <td>{{ $ultimo->fecha_fin }}</td>
                    <td class="text-center">
                        <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#detalle-{{ $numero_prestamo }}">
                            Ver Detalle
                        </button>
                    </td>
                </tr>

                {{-- Detalle --}}
                <tr class="collapse bloque-imprimible bloque-{{ $numero_prestamo }}" id="detalle-{{ $numero_prestamo }}">
                    <td colspan="5">
                        <table class="table table-sm table-bordered text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Item</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Fin</th>
                                   
                                    <th>Monto</th>
                                    <th>Interés</th>
                                    <th>Interés a Pagar</th>
                                    <th>Descripción</th>
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
                                    <tr>
                                        <td>{{ $detalle->id }}</td>
                                        <td>{{ $detalle->item_prestamo }}</td>
                                        <td>{{ $detalle->fecha_inicio }}</td>
                                        <td>{{ $detalle->fecha_fin }}</td>
                                      
                                        <td>S/ {{ number_format($detalle->monto, 2) }}</td>
                                        <td>S/ {{ number_format($detalle->interes, 2) }}</td>
                                        <td>S/ {{ number_format($detalle->interes_pagar, 2) }}</td>
                                        <td>{{ $detalle->descripcion }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-secondary">
                                <tr>
                                    <th colspan="5" class="text-end">Totales:</th>
                                    <th>S/ {{ number_format($totalMonto, 2) }}</th>
                                    <th>S/ {{ number_format($totalInteres, 2) }}</th>
                                    <th>S/ {{ number_format($totalInteresPagar, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>

{{-- Estilos de impresión --}}
<style>
    /* --- ESTILOS EN PANTALLA --- */
    .container {
        max-width: 100%;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: auto;
    }

    th, td {
        text-align: center;
        vertical-align: middle;
        padding: 8px;
        border: 1px solid #dee2e6;
        font-size: 14px;
    }

    thead th {
        background-color: #343a40;
        color: white;
    }

    tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    h1 {
        font-size: 28px;
        text-align: center;
        font-weight: bold;
        margin-bottom: 20px;
    }

    /* Botón flotante en pantallas pequeñas */
    @media (max-width: 768px) {
        .btn {
            width: 100%;
            margin-bottom: 10px;
        }

        table {
            font-size: 12px;
        }

        h1 {
            font-size: 22px;
        }
    }

    /* --- ESTILOS SOLO PARA IMPRESIÓN --- */
    @media print {
        body * {
            visibility: hidden;
        }

        .seleccionado-imprimir,
        .seleccionado-imprimir * {
            visibility: visible !important;
        }

        .seleccionado-imprimir {
            display: table-row !important;
        }

        .no-print {
            display: none !important;
        }

        .container {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        table {
            width: 100% !important;
            font-size: 11px !important;
        }

        th, td {
            border: 1px solid #000 !important;
            padding: 5px !important;
            word-break: break-word;
        }

        h1 {
            font-size: 20px !important;
            text-align: center;
            margin: 0 0 15px 0;
        }
    }
</style>


{{-- Script --}}
<script>
    function imprimirSeleccionados() {
        // Limpiar
        document.querySelectorAll('.seleccionado-imprimir').forEach(e => e.classList.remove('seleccionado-imprimir'));

        // Agregar a los seleccionados
        document.querySelectorAll('.seleccionar-reporte:checked').forEach(cb => {
            const numero = cb.getAttribute('data-target');
            const fila = document.querySelector('.fila-principal-' + numero);
            const detalle = document.querySelector('.bloque-' + numero);

            if (fila) fila.classList.add('seleccionado-imprimir');
            if (detalle) {
                detalle.classList.add('seleccionado-imprimir', 'show');
            }
        });

        window.print();
    }
</script>
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('show');
    }
</script>

</body>
</html>




