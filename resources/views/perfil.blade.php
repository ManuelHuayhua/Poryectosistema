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
            --accent-color: #667eea;
            --card-shadow: 0 8px 25px rgba(0,0,0,0.1);
            --transition: all 0.3s ease;
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
        }

        /* Estilos mejorados para el contenido */
        .page-header {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: var(--card-shadow);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: var(--primary-gradient);
        }

        .page-title {
            color: #2c3e50;
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: #7f8c8d;
            font-size: 1.1rem;
        }

        .profile-card {
            background: white;
            border-radius: 20px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .card-header-custom {
            background: var(--primary-gradient);
            color: white;
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .card-header-custom i {
            font-size: 1.5rem;
        }

        .card-header-custom h4 {
            margin: 0;
            font-weight: 600;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            padding: 2rem;
        }

        .info-item {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 1.5rem;
            border-left: 4px solid var(--accent-color);
            transition: var(--transition);
            position: relative;
        }

        .info-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .info-label {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--accent-color);
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .info-label i {
            font-size: 1.1rem;
        }

        .info-value {
            color: #2c3e50;
            font-size: 1.1rem;
            font-weight: 500;
        }

        .action-buttons {
            padding: 2rem;
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-custom {
            background: var(--primary-gradient);
            border: none;
            color: white;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
            color: white;
        }

        .btn-custom i {
            font-size: 1.1rem;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }

        .stat-icon {
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

        .stat-card:nth-child(1) .stat-icon { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .stat-card:nth-child(2) .stat-icon { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .stat-card:nth-child(3) .stat-icon { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #7f8c8d;
            font-weight: 500;
        }

        /* Modal mejorado */
        .modal-content {
            border-radius: 20px;
            border: none;
            box-shadow: var(--card-shadow);
        }

        .modal-header {
            background: var(--primary-gradient);
            color: white;
            border-radius: 20px 20px 0 0;
            border-bottom: none;
        }

        .modal-body {
            padding: 2rem;
        }

        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
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
                padding: 0.75rem;
                border-radius: 10px;
                cursor: pointer;
                box-shadow: var(--card-shadow);
            }

            .page-title {
                font-size: 2rem;
            }

            .profile-grid {
                grid-template-columns: 1fr;
                padding: 1rem;
            }

            .stats-row {
                grid-template-columns: 1fr;
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
            <a href="#" class="nav-link"><i class="fas fa-home"></i><span>Inicio</span></a>
        </div>
        <div class="nav-item">
            <a href="#" class="nav-link active"><i class="fas fa-user-circle"></i><span>Perfil</span></a>
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
    <!-- Header de la página -->
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-user-circle me-3"></i>Mi Perfil</h1>
        <p class="page-subtitle">Gestiona tu información personal y configuración de cuenta</p>
    </div>

    <!-- Estadísticas rápidas -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stat-value" id="edadCalculada">25</div>
            <div class="stat-label">Años</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <div class="stat-value">Activo</div>
            <div class="stat-label">Estado de Cuenta</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-value">Verificado</div>
            <div class="stat-label">Perfil</div>
        </div>
    </div>

    <!-- Información del perfil -->
    <div class="profile-card">
        <div class="card-header-custom">
            <i class="fas fa-id-card"></i>
            <h4>Información Personal</h4>
        </div>
        
        <div class="profile-grid">
            <div class="info-item">
                <div class="info-label">
                    <i class="fas fa-user"></i>
                    Nombre Completo
                </div>
                <div class="info-value">{{ $usuario->name }} {{ $usuario->apellido_paterno }} {{ $usuario->apellido_materno }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">
                    <i class="fas fa-id-badge"></i>
                    DNI
                </div>
                <div class="info-value">{{ $usuario->dni }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">
                    <i class="fas fa-envelope"></i>
                    Email
                </div>
                <div class="info-value">{{ $usuario->email }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">
                    <i class="fas fa-phone"></i>
                    Teléfono
                </div>
                <div class="info-value">{{ $usuario->telefono }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">
                    <i class="fas fa-map-marker-alt"></i>
                    Dirección
                </div>
                <div class="info-value">{{ $usuario->direccion }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">
                    <i class="fas fa-venus-mars"></i>
                    Sexo
                </div>
                <div class="info-value">{{ $usuario->sexo }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">
                    <i class="fas fa-heart"></i>
                    Estado Civil
                </div>
                <div class="info-value">{{ $usuario->estado_civil }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">
                    <i class="fas fa-birthday-cake"></i>
                    Fecha de Nacimiento
                </div>
                <div class="info-value" id="fechaNacimiento">{{ $usuario->fecha_nacimiento }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">
                    <i class="fas fa-flag"></i>
                    Nacionalidad
                </div>
                <div class="info-value">{{ $usuario->nacionalidad }}</div>
            </div>

            <div class="info-item">
                <div class="info-label">
                    <i class="fas fa-tag"></i>
                    Tipo de Usuario
                </div>
                <div class="info-value">{{ $usuario->tipo_origen }}</div>
            </div>
        </div>

        <div class="action-buttons">
            <button type="button" class="btn-custom" data-bs-toggle="modal" data-bs-target="#modalCambiarContrasena">
                <i class="fas fa-key"></i>
                Cambiar Contraseña
            </button>
           
        </div>
    </div>
</div>

<!-- Modal mejorado -->
<div class="modal fade" id="modalCambiarContrasena" tabindex="-1" aria-labelledby="modalCambiarContrasenaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCambiarContrasenaLabel">
                    <i class="fas fa-key me-2"></i>Cambiar Contraseña
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body">
                <form method="POST" action="{{ route('perfil.cambiarPassword') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-user me-2"></i>Usuario
                        </label>
                        <input type="text" class="form-control" value="{{ $usuario->name }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-id-badge me-2"></i>DNI
                        </label>
                        <input type="text" class="form-control" value="{{ $usuario->dni }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-2"></i>Nueva Contraseña
                        </label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">
                            <i class="fas fa-lock me-2"></i>Confirmar Contraseña
                        </label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    </div>

                    @if (session('success_password'))
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success_password') }}
                        </div>
                    @endif

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </button>
                        <button type="submit" class="btn-custom">
                            <i class="fas fa-save me-2"></i>Actualizar Contraseña
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Función para calcular edad a partir de la fecha de nacimiento
    function calcularEdad(fechaNacimiento) {
        const hoy = new Date();
        const nacimiento = new Date(fechaNacimiento);
        let edad = hoy.getFullYear() - nacimiento.getFullYear();
        const mes = hoy.getMonth() - nacimiento.getMonth();

        if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
            edad--;
        }
        return edad;
    }

    // Obtener la fecha de nacimiento desde el DOM
    const fechaNac = document.getElementById('fechaNacimiento').innerText;

    // Calcular y mostrar la edad
    const edadElementos = document.querySelectorAll('#edadCalculada');
    const edad = calcularEdad(fechaNac);
    edadElementos.forEach(elemento => {
        elemento.innerText = edad;
    });

    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('show');
    }
</script>

<!-- Script para abrir automáticamente el modal si hay errores o éxito -->
@if ($errors->has('password') || session('success_password'))
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = new bootstrap.Modal(document.getElementById('modalCambiarContrasena'));
        modal.show();
    });
</script>
@endif

</body>
</html>