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
            <a href="{{ route('home') }}" class="nav-link active"><i class="fas fa-home"></i><span>Inicio</span></a>
        </div>
        <div class="nav-item">
            <a href="{{ route('perfil') }}" class="nav-link "><i class="fas fa-user-circle"></i><span>Perfil</span></a>
        </div>
        <div class="nav-item">
            <a href="{{ route('reporteusuarios.index') }}" class="nav-link"><i class="fas fa-download"></i><span>Reporte</span></a>
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
    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>

                                <div class="container mt-5">
   <div class="container mt-5">
    <h2>Bienvenido, {{ Auth::user()->name }}</h2>

    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('prestamo.store') }}" method="POST" class="mt-4">
        @csrf
        <div class="form-group">
            <label for="monto">¿Cuánto deseas solicitar?</label>
            <input type="number" name="monto" id="monto" class="form-control" required min="1" step="0.01" placeholder="Ingrese monto en soles">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Solicitar préstamo</button>
    </form>

      
      <!-- Tabla de préstamos -->
<h3 class="mt-5">📄 Tus Préstamos</h3>
<table class="table table-bordered table-hover mt-3">
    <thead class="table-dark">
        <tr>
            <th>N° Préstamo</th>
            <th>Último Ítem</th>
            <th>Monto (S/)</th>
            <th>Interés (%)</th>
            <th>Interés a Pagar</th>
            <th>Estado</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Fecha de Pago</th>
      
        </tr>
    </thead>
    <tbody>
        @forelse($prestamos as $prestamo)
            <tr class="{{ $prestamo->estado === 'cancelado' ? 'table-danger' : '' }}">
                <td><strong>{{ $prestamo->numero_prestamo }}</strong></td>
                <td>{{ $prestamo->item_prestamo }}</td>
                <td>S/ {{ number_format($prestamo->monto, 2) }}</td>
                <td>{{ $prestamo->interes }}%</td>
                <td>S/ {{ number_format($prestamo->interes_pagar, 2) }}</td>
                <td><span class="badge bg-{{ $prestamo->estado == 'pendiente' ? 'warning' : ($prestamo->estado == 'cancelado' ? 'danger' : 'success') }}">
                    {{ ucfirst($prestamo->estado) }}</span>
                </td>
                  <td>{{ \Carbon\Carbon::parse($prestamo->Inicio)->format('Y-m-d') ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($prestamo->fecha_fin)->format('Y-m-d') ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($prestamo->fecha_pago)->format('Y-m-d') ?? '-' }}</td>     
             
            </tr>
        @empty
            <tr>
                <td colspan="10" class="text-center">No tienes préstamos registrados.</td>
            </tr>
        @endforelse
    </tbody>
</table>
    </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }
    </script>

    </body>
    </html>




