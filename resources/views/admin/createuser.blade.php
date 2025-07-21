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
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
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

        /* Mejoras para el formulario de crear usuario */
        .form-card {
            background: white;
            border-radius: 15px;
            box-shadow: var(--card-shadow);
            border: none;
            overflow: hidden;
        }

        .form-card .card-header {
            background: var(--primary-gradient);
            color: white;
            padding: 1.5rem;
            border: none;
        }

        .form-section {
            background: #f8f9fa;
            padding: 1rem;
            margin: 1.5rem -1.5rem 1.5rem -1.5rem;
            border-left: 4px solid #667eea;
        }

        .form-section h6 {
            margin: 0;
            color: #495057;
            font-weight: 600;
        }

        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .btn-primary {
            background: var(--primary-gradient);
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        /* Mejoras para la tabla de usuarios */
        .users-card {
            background: white;
            border-radius: 15px;
            box-shadow: var(--card-shadow);
            border: none;
        }

        .search-container {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
        }

        .search-input {
            border-radius: 25px;
            border: 2px solid #e9ecef;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            transform: translateY(-1px);
        }

        .table-container {
            border-radius: 10px;
            overflow: hidden;
        }

        .table {
            margin: 0;
        }

        .table th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
            border: none;
            padding: 1rem;
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
            border-color: #e9ecef;
        }

        .user-avatar-small {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.9rem;
        }

        .badge-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 15px;
            font-size: 0.85rem;
        }

        /* Modal mejorado */
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background: var(--primary-gradient);
            color: white;
            border-radius: 15px 15px 0 0;
            border: none;
        }

        .btn-close {
            filter: brightness(0) invert(1);
        }

        .password-input-group {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
        }

          /* funciona para que el menu se despligue en movile */
               .sidebar {
    overflow-y: auto;            /* permite el scroll vertical */
    -webkit-overflow-scrolling: touch; /* scroll suave en iOS */
}

/* Opción 2: fija el header y desplaza solo los enlaces */
.sidebar-nav {
    max-height: calc(100vh - 200px); /* ajusta 160 px al alto real del header */
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

            .form-section {
                margin: 1rem -1rem;
                padding: 1rem;
            }
        }

        @media (min-width: 769px) {
            .mobile-menu-toggle {
                display: none;
            }
        }

        /* Animaciones */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
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
        <a href="{{ route('admin.createuser') }}" class="nav-link active">
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

<div class="main-content">
    <div class="container-fluid">
        <!-- Crear Usuario -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card form-card fade-in">
                    <div class="card-header">
                        <h4 class="mb-0">
                            <i class="fas fa-user-plus me-2"></i>
                            Crear nuevo usuario
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('admin.storeuser') }}" method="POST" id="userForm">
                            @csrf

                            <!-- Información Personal -->
                            <div class="form-section">
                                <h6><i class="fas fa-user me-2"></i>Información Personal</h6>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <label for="name" class="form-label fw-semibold">
                                        Nombre <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="apellido_paterno" class="form-label fw-semibold">
                                        Apellido Paterno <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control" value="{{ old('apellido_paterno') }}" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="apellido_materno" class="form-label fw-semibold">
                                        Apellido Materno <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="apellido_materno" id="apellido_materno" class="form-control" value="{{ old('apellido_materno') }}" required>
                                </div>

                                <div class="col-md-3">
                                    <label for="sexo" class="form-label fw-semibold">
                                        Sexo <span class="text-danger">*</span>
                                    </label>
                                    <select name="sexo" id="sexo" class="form-select" required>
                                        <option value="">Seleccionar...</option>
                                        <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                                        <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Femenino</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="estado_civil" class="form-label fw-semibold">
                                        Estado Civil <span class="text-danger">*</span>
                                    </label>
                                    <select name="estado_civil" id="estado_civil" class="form-select" required>
                                        <option value="">Seleccionar...</option>
                                        <option value="Soltero" {{ old('estado_civil') == 'Soltero' ? 'selected' : '' }}>Soltero(a)</option>
                                        <option value="Casado" {{ old('estado_civil') == 'Casado' ? 'selected' : '' }}>Casado(a)</option>
                                        <option value="Viudo" {{ old('estado_civil') == 'Viudo' ? 'selected' : '' }}>Viudo(a)</option>
                                        <option value="Divorciado" {{ old('estado_civil') == 'Divorciado' ? 'selected' : '' }}>Divorciado(a)</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="fecha_nacimiento" class="form-label fw-semibold">
                                        Fecha de Nacimiento
                                    </label>
                                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento') }}">
                                </div>

                                <div class="col-md-3">
                                    <label for="nacionalidad" class="form-label fw-semibold">
                                        Nacionalidad <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nacionalidad" id="nacionalidad" class="form-control" value="{{ old('nacionalidad') }}" required>
                                </div>
                            </div>

                            <!-- Información de Contacto -->
                            <div class="form-section">
                                <h6><i class="fas fa-address-book me-2"></i>Información de Contacto</h6>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <label for="dni" class="form-label fw-semibold">
                                        DNI
                                    </label>
                                    <input type="text" name="dni" id="dni" class="form-control @error('dni') is-invalid @enderror" value="{{ old('dni') }}" maxlength="8" pattern="[0-9]{8}" required>
                                    @error('dni') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    <div class="form-text">8 dígitos numéricos</div>
                                </div>

                                <div class="col-md-4">
                                    <label for="telefono" class="form-label fw-semibold">
                                        Teléfono
                                    </label>
                                    <input type="tel" name="telefono" id="telefono" class="form-control" value="{{ old('telefono') }}">
                                </div>

                               <div class="col-md-4">
    <label for="email" class="form-label fw-semibold">
        Correo electrónico
        <!-- Eliminado el * que indicaba campo obligatorio -->
    </label>
    <input type="email" name="email" id="email"
           class="form-control @error('email') is-invalid @enderror"
           value="{{ old('email') }}">
    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

                                <div class="col-md-6">
                                    <label for="direccion" class="form-label fw-semibold">
                                        Dirección
                                    </label>
                                    <input type="text" name="direccion" id="direccion" class="form-control" value="{{ old('direccion') }}">
                                </div>

                                <div class="col-md-6">
                                    <label for="tipo_origen" class="form-label fw-semibold">
                                        Tipo Origen
                                    </label>
                                    <input type="text" name="tipo_origen" id="tipo_origen" class="form-control" value="{{ old('tipo_origen') }}">
                                </div>
                            </div>

                            <!-- Contraseña igual a DNI (oculta) -->
                            <input type="hidden" name="password" id="password" required>
                            <input type="hidden" name="password_confirmation" id="password_confirmation" required>

                            <!-- Permisos -->
                            <div class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_admin" id="is_admin" {{ old('is_admin') ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="is_admin">
                                        <i class="fas fa-user-shield me-1"></i>¿Es administrador?
                                    </label>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-user-plus me-2"></i>Crear usuario
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Usuarios Registrados -->
        <div class="row">
            <div class="col-12">
                <div class="card users-card fade-in">
                    <div class="card-header" style="background: var(--primary-gradient); color: white;">
                        <h4 class="mb-0">
                            <i class="fas fa-users me-2"></i>
                            Usuarios registrados
                        </h4>
                    </div>
                     <a href="{{ route('exportar.usuarios') }}" class="btn btn-success">
                    <i class="fas fa-file-excel me-2"></i> Desacargar Usuarios
                </a>
            </div>

                    <div class="card-body p-4">
                        @if(session('success_password'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success_password') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Buscador -->
                        <div class="search-container">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <span class="input-group-text bg-white border-end-0">
                                            <i class="fas fa-search text-muted"></i>
                                        </span>
                                        <input type="text" class="form-control search-input border-start-0" id="searchInput" placeholder="Buscar por nombre completo o DNI...">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-outline-primary w-100" onclick="clearSearch()">
                                        <i class="fas fa-times me-2"></i>Limpiar búsqueda
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="table-container">
                            <div class="table-responsive">
                                <table class="table table-hover" id="usersTable">
                                    <thead>
                                        <tr>
                                             <th><i class="fas fa-user me-2"></i>N°</th>
                                            <th><i class="fas fa-user me-2"></i>Usuario</th>
                                            <th><i class="fas fa-id-card me-2"></i>DNI</th>
                                            <th><i class="fas fa-envelope me-2"></i>Correo</th>
                                            <th><i class="fas fa-cog me-2"></i>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="usersTableBody">
                                        @foreach($usuarios as $usuario)
                                            <tr>
                                                <td class="user-index"></td>
<script>
    function actualizarNumeracionUsuarios() {
        const filas = document.querySelectorAll('#usersTable tbody tr');
        filas.forEach((fila, index) => {
            const celdaIndice = fila.querySelector('.user-index');
            if (celdaIndice) {
                celdaIndice.textContent = index + 1;
            }
        });
    }

    // Llamamos la función al cargar la página
    document.addEventListener('DOMContentLoaded', actualizarNumeracionUsuarios);
</script>


                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="user-avatar-small me-3">
                                                            {{ strtoupper(substr($usuario->name, 0, 1)) }}
                                                        </div>
                                                        <div>
                                                            <strong class="user-full-name">{{ $usuario->name }} {{ $usuario->apellido_paterno }} {{ $usuario->apellido_materno }}</strong>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge-custom user-dni">{{ $usuario->dni ?: 'N/A' }}</span>
                                                </td>
                                                <td>{{ $usuario->email }}</td>
                                                <td>
                                                    <button class="btn btn-primary btn-sm" onclick="openPasswordModal('{{ $usuario->id }}', '{{ $usuario->name }} {{ $usuario->apellido_paterno }}')">
                                                        <i class="fas fa-key me-1"></i>Cambiar contraseña
                                                    </button>
                                                    <button class="btn btn-warning btn-sm" onclick="openEditModal({{ $usuario }})">
        <i class="fas fa-edit me-1"></i>Editar
    </button>
                                                </td>
                                                
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div id="noResults" class="text-center py-4" style="display: none;">
                            <i class="fas fa-search text-muted fa-3x mb-3"></i>
                            <h5 class="text-muted">No se encontraron usuarios</h5>
                            <p class="text-muted">Intenta con otros términos de búsqueda</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Modal Editar Usuario -->
<!-- Modal de Edición de Usuario -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="POST" action="{{ route('admin.updateuser') }}">
      @csrf
      @method('PUT')
      <input type="hidden" name="id" id="edit_user_id">
      <div class="modal-content shadow-lg rounded-4">
        <div class="modal-header bg-warning text-white">
          <h5 class="modal-title"><i class="fas fa-user-edit me-2"></i>Editar Usuario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="row g-3">
            <div class="col-md-6 mb-3">
              <label for="edit_name" class="form-label"><i class="fas fa-user me-1"></i>Nombre</label>
              <input type="text" class="form-control" name="name" id="edit_name" required>
            </div>

            <div class="col-md-6 mb-3">
              <label for="edit_apellido_paterno" class="form-label"><i class="fas fa-user-tag me-1"></i>Apellido Paterno</label>
              <input type="text" class="form-control" name="apellido_paterno" id="edit_apellido_paterno" required>
            </div>

            <div class="col-md-6 mb-3">
              <label for="edit_apellido_materno" class="form-label">Apellido Materno</label>
              <input type="text" class="form-control" name="apellido_materno" id="edit_apellido_materno">
            </div>

            <div class="col-md-6 mb-3">
              <label for="edit_email" class="form-label"><i class="fas fa-envelope me-1"></i>Correo</label>
              <input type="email" class="form-control" name="email" id="edit_email">
            </div>

            <div class="col-md-6 mb-3">
              <label for="edit_dni" class="form-label"><i class="fas fa-id-card me-1"></i>DNI</label>
              <input type="text" class="form-control" name="dni" id="edit_dni">
            </div>

            <div class="col-md-6 mb-3">
              <label for="edit_telefono" class="form-label"><i class="fas fa-phone me-1"></i>Teléfono</label>
              <input type="text" class="form-control" name="telefono" id="edit_telefono">
            </div>

            <div class="col-md-6 mb-3">
              <label for="edit_sexo" class="form-label">Sexo</label>
              <select class="form-select" name="sexo" id="edit_sexo">
                <option value="">Seleccionar</option>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
              </select>
            </div>

            <div class="col-md-6 mb-3">
              <label for="edit_estado_civil" class="form-label">Estado Civil</label>
              <select class="form-select" name="estado_civil" id="edit_estado_civil">
                <option value="">Seleccionar</option>
                <option value="Soltero/a">Soltero/a</option>
                <option value="Casado/a">Casado/a</option>
                <option value="Viudo/a">Viudo/a</option>
                <option value="Divorciado/a">Divorciado/a</option>
              </select>
            </div>

            <div class="col-md-6 mb-3">
              <label for="edit_fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
              <input type="date" class="form-control" name="fecha_nacimiento" id="edit_fecha_nacimiento">
            </div>

            <div class="col-md-6 mb-3">
              <label for="edit_nacionalidad" class="form-label">Nacionalidad</label>
              <input type="text" class="form-control" name="nacionalidad" id="edit_nacionalidad">
            </div>

            <div class="col-md-6 mb-3">
              <label for="edit_direccion" class="form-label"><i class="fas fa-map-marker-alt me-1"></i>Dirección</label>
              <input type="text" class="form-control" name="direccion" id="edit_direccion">
            </div>

            <div class="col-md-6 mb-3">
              <label for="edit_tipo_origen" class="form-label">Tipo de Origen</label>
              <input type="text" class="form-control" name="tipo_origen" id="edit_tipo_origen">
            </div>

          {{-- ========= 1. SELECT is_admin (sin cambios) ========= --}}
<div class="col-md-6 mb-3">
  <label for="edit_is_admin" class="form-label">
    <i class="fas fa-user-shield me-1"></i>¿Es administrador?
  </label>
  <select class="form-select" name="is_admin" id="edit_is_admin">
    <option value="0">No</option>
    <option value="1">Sí</option>
  </select>
</div>

{{-- ========= 2. CONTENEDOR DE PERMISOS (añadimos id y d-none) ========= --}}
<div id="admin-permissions" class="row g-3 d-none"><!-- NUEVO -->
  <div class="col-12">
    <h5 class="mt-3">Permisos de administrador</h5>
  </div>

  @php
      $flags = [
          'inicio'        => 'Inicio',
          'usuarios'      => 'Usuarios y Roles',
          'des_contrato'  => 'Des. Contrato',
          'configuracion' => 'Configuración',
          'ge_prestamo'   => 'Generar Préstamo',
          'ge_reportes'   => 'Generar Reportes',
          'grafica'       => 'Gráficos',
          'aporte'        => 'Aportes',  
      ];
  @endphp

  @foreach ($flags as $key => $label)
      <div class="col-md-4 mb-2">
          <div class="form-check form-switch">
              <input type="hidden" name="{{ $key }}" value="0">
              <input class="form-check-input" type="checkbox" id="edit_{{ $key }}" name="{{ $key }}" value="1">
              <label class="form-check-label" for="edit_{{ $key }}">{{ $label }}</label>
          </div>
      </div>
  @endforeach
</div>


          </div>
        </div>

        <div class="modal-footer border-top">
          <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i>Guardar cambios</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times me-1"></i>Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
    // Mostrar u ocultar los permisos según el valor del campo is_admin
    function toggleAdminPerms() {
        const isAdmin = document.getElementById('edit_is_admin').value == '1';
        const permsContainer = document.getElementById('admin-permissions');
        permsContainer.classList.toggle('d-none', !isAdmin);
    }

    // Escuchar el cambio del select "¿Es administrador?"
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('edit_is_admin')
            .addEventListener('change', toggleAdminPerms);
    });

    // Abrir el modal con los datos del usuario
    function openEditModal(usuario) {
        document.getElementById('edit_user_id').value = usuario.id;
        document.getElementById('edit_name').value = usuario.name;
        document.getElementById('edit_apellido_paterno').value = usuario.apellido_paterno;
        document.getElementById('edit_apellido_materno').value = usuario.apellido_materno;
        document.getElementById('edit_email').value = usuario.email;
        document.getElementById('edit_dni').value = usuario.dni;
        document.getElementById('edit_telefono').value = usuario.telefono;
        document.getElementById('edit_sexo').value = usuario.sexo;
        document.getElementById('edit_estado_civil').value = usuario.estado_civil;
        document.getElementById('edit_fecha_nacimiento').value = usuario.fecha_nacimiento;
        document.getElementById('edit_nacionalidad').value = usuario.nacionalidad;
        document.getElementById('edit_direccion').value = usuario.direccion;
        document.getElementById('edit_tipo_origen').value = usuario.tipo_origen;
        document.getElementById('edit_is_admin').value = usuario.is_admin ? 1 : 0;

        // Permisos
        document.getElementById('edit_inicio').checked        = usuario.inicio        == 1;
        document.getElementById('edit_usuarios').checked      = usuario.usuarios      == 1;
        document.getElementById('edit_des_contrato').checked  = usuario.des_contrato  == 1;
        document.getElementById('edit_configuracion').checked = usuario.configuracion == 1;
        document.getElementById('edit_ge_prestamo').checked   = usuario.ge_prestamo   == 1;
        document.getElementById('edit_ge_reportes').checked   = usuario.ge_reportes   == 1;
        document.getElementById('edit_grafica').checked       = usuario.grafica       == 1;
        document.getElementById('edit_aporte').checked = usuario.aporte == 1; // ⬅️ NUEVO

        // Mostrar u ocultar los permisos según el valor de is_admin
        toggleAdminPerms();

        // Mostrar el modal
        const modal = new bootstrap.Modal(document.getElementById('editUserModal'));
        modal.show();
    }
</script>

<!-- Modal para cambiar contraseña -->
<div class="modal fade" id="passwordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-key me-2"></i>Cambiar contraseña
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="passwordForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div class="user-avatar-small mx-auto mb-2" style="width: 60px; height: 60px; font-size: 1.5rem;">
                            <span id="modalUserInitial"></span>
                        </div>
                        <h6 id="modalUserName" class="text-muted"></h6>
                    </div>

                    <div class="mb-3">
                        <label for="modalPassword" class="form-label fw-semibold">Nueva contraseña</label>
                        <div class="password-input-group">
                            <input type="password" class="form-control" id="modalPassword" name="password" required>
                            <button type="button" class="password-toggle" onclick="togglePasswordVisibility('modalPassword', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="modalPasswordConfirmation" class="form-label fw-semibold">Confirmar contraseña</label>
                        <div class="password-input-group">
                            <input type="password" class="form-control" id="modalPasswordConfirmation" name="password_confirmation" required>
                            <button type="button" class="password-toggle" onclick="togglePasswordVisibility('modalPasswordConfirmation', this)">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        La contraseña debe tener al menos 8 caracteres.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Actualizar contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Script para copiar DNI como contraseña
    document.getElementById('dni').addEventListener('input', function () {
        const dni = this.value;
        document.getElementById('password').value = dni;
        document.getElementById('password_confirmation').value = dni;
    });

    // Toggle sidebar
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('show');
    }

    // Cerrar sidebar al hacer click fuera en móvil
    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('sidebar');
        const toggle = document.querySelector('.mobile-menu-toggle');
        
        if (window.innerWidth <= 768 && 
            !sidebar.contains(event.target) && 
            !toggle.contains(event.target) && 
            sidebar.classList.contains('show')) {
            sidebar.classList.remove('show');
        }
    });

    // Función de búsqueda
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#usersTableBody tr');
        const noResults = document.getElementById('noResults');
        let visibleRows = 0;

        rows.forEach(row => {
            const fullName = row.querySelector('.user-full-name').textContent.toLowerCase();
            const dni = row.querySelector('.user-dni').textContent.toLowerCase();
            
            if (fullName.includes(searchTerm) || dni.includes(searchTerm)) {
                row.style.display = '';
                visibleRows++;
            } else {
                row.style.display = 'none';
            }
        });

        // Mostrar mensaje de "no results" si no hay coincidencias
        if (visibleRows === 0 && searchTerm !== '') {
            noResults.style.display = 'block';
            document.querySelector('.table-container').style.display = 'none';
        } else {
            noResults.style.display = 'none';
            document.querySelector('.table-container').style.display = 'block';
        }
    });

    // Limpiar búsqueda
    function clearSearch() {
        document.getElementById('searchInput').value = '';
        document.querySelectorAll('#usersTableBody tr').forEach(row => {
            row.style.display = '';
        });
        document.getElementById('noResults').style.display = 'none';
        document.querySelector('.table-container').style.display = 'block';
    }

    // Abrir modal de contraseña
    function openPasswordModal(userId, userName) {
        const modal = new bootstrap.Modal(document.getElementById('passwordModal'));
        const form = document.getElementById('passwordForm');
        const userNameElement = document.getElementById('modalUserName');
        const userInitialElement = document.getElementById('modalUserInitial');
        
        // Configurar el formulario
        form.action = `/admin/usuarios/${userId}/actualizar-password`;
        
        // Configurar el nombre del usuario
        userNameElement.textContent = userName;
        userInitialElement.textContent = userName.charAt(0).toUpperCase();
        
        // Limpiar campos
        document.getElementById('modalPassword').value = '';
        document.getElementById('modalPasswordConfirmation').value = '';
        
        modal.show();
    }

    // Toggle visibilidad de contraseña
    function togglePasswordVisibility(inputId, button) {
        const input = document.getElementById(inputId);
        const icon = button.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Validación de contraseñas en el modal
    document.getElementById('passwordForm').addEventListener('submit', function(e) {
        const password = document.getElementById('modalPassword').value;
        const passwordConfirmation = document.getElementById('modalPasswordConfirmation').value;
        
        if (password !== passwordConfirmation) {
            e.preventDefault();
            alert('Las contraseñas no coinciden. Por favor, verifícalas.');
            return false;
        }
        
        if (password.length < 8) {
            e.preventDefault();
            alert('La contraseña debe tener al menos 8 caracteres.');
            return false;
        }
    });

    // Animación de entrada para elementos
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.fade-in');
        cards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 200);
        });
    });

    // Mejorar la experiencia del formulario
    const inputs = document.querySelectorAll('.form-control, .form-select');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });

    // Auto-focus en el modal
    document.getElementById('passwordModal').addEventListener('shown.bs.modal', function() {
        document.getElementById('modalPassword').focus();
    });
</script>

</body>
</html>