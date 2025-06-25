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

        /* Estilos mejorados para el contenido principal */
        .content-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .page-title {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-align: center;
        }

        .page-subtitle {
            color: #6c757d;
            text-align: center;
            margin-bottom: 2rem;
            font-size: 1rem;
        }

        .info-alert {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: none;
        }

        .info-alert .alert-title {
            display: flex;
            align-items: center;
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.8rem;
        }

        .info-alert .alert-title i {
            margin-right: 0.5rem;
        }

        .info-text {
            margin: 0;
            opacity: 0.9;
            line-height: 1.5;
        }

        .form-container {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 2rem;
            border: 2px solid #e9ecef;
        }

        .form-row {
            display: flex;
            gap: 1.5rem;
            align-items: end;
            margin-bottom: 1.5rem;
        }

        .form-group {
            flex: 1;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
        }

        .form-label i {
            margin-right: 0.5rem;
            color: #667eea;
        }

        .form-control, .form-select {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            padding: 0.75rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            height: 48px;
        }

        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
        }

        .btn-generate {
            background: var(--primary-gradient);
            border: none;
            border-radius: 8px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            height: 48px;
            min-width: 180px;
        }

        .btn-generate:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
            color: white;
        }

        .alert {
            border-radius: 10px;
            border: none;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: var(--success-gradient);
            color: white;
        }

        /* Select2 arreglado */
        .select2-container {
            width: 100% !important;
        }

        .select2-container--default .select2-selection--single {
            border: 2px solid #e9ecef !important;
            border-radius: 8px !important;
            height: 48px !important;
            line-height: 44px !important;
        }

        .select2-container--default .select2-selection--single:focus,
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #667eea !important;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15) !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding-left: 12px !important;
            padding-right: 20px !important;
            line-height: 44px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 44px !important;
            right: 8px !important;
        }

        .select2-dropdown {
            border: 2px solid #667eea !important;
            border-radius: 8px !important;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1) !important;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #ddd !important;
            border-radius: 6px !important;
            padding: 8px 12px !important;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #667eea !important;
        }

        /* Input group para el monto */
        .input-group .input-group-text {
            background: #667eea;
            color: white;
            border: 2px solid #667eea;
            border-radius: 8px 0 0 8px;
            font-weight: 600;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 8px 8px 0;
        }

        .input-group .form-control:focus {
            border-color: #667eea;
            border-left: 2px solid #667eea;
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

            .content-card {
                padding: 1.5rem;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .form-row {
                flex-direction: column;
                gap: 1rem;
            }

            .form-row .form-group {
                width: 100%;
            }

            .btn-generate {
                width: 100%;
                margin-top: 1rem;
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

        /* Animación */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .content-card {
            animation: fadeInUp 0.5s ease-out;
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
        <a href="{{ route('admin.createuser') }}" class="nav-link">
            <i class="fas fa-users-cog"></i><span>Usuario y Roles</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="{{ route('admin.prestamos.pendientes') }}" class="nav-link ">
            <i class="fas fa-file-download"></i><span>Descargar Contrato</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="{{ route('admin.configuraciones') }}" class="nav-link">
            <i class="fas fa-cogs"></i><span>Configurar</span>
        </a>
    </div>
    <div class="nav-item">
        <a href="{{ route('admin.prestamos.crear') }}" class="nav-link active">
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
    <div class="container">
        <div class="content-card">
            <h1 class="page-title">
                <i class="fas fa-hand-holding-usd"></i>
                Generar Préstamo
            </h1>
            <p class="page-subtitle">Crea un nuevo préstamo de manera rápida y sencilla</p>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Instrucciones simplificadas -->
           <!-- Instrucciones mejoradas -->
<div class="info-alert">
    <div class="alert-title">
        <i class="fas fa-info-circle"></i>
        ¿Cómo generar un préstamo?
    </div>

    <div class="row gy-3 align-items-center">
        <div class="col-12 col-md-6">
            <p class="info-text mb-0">
                <strong>1.</strong> Busca el usuario por nombre o DNI <br>
                <strong>2.</strong> Ingresa el monto <br>
                <strong>3.</strong> Haz clic en <em>"Generar Préstamo"</em>
            </p>
        </div>

        <div class="col-12 col-md-6 d-flex flex-column flex-md-row justify-content-md-end gap-2">
            <a href="{{ route('admin.prestamos.pendientes') }}" class="btn btn-light text-primary border-primary">
                <i class="fas fa-file-download me-2"></i> 4. Descargar Contrato
            </a>
            <a href="{{ route('indexAdmin') }}" class="btn btn-primary">
                <i class="fas fa-check-circle me-2"></i> 5. Aprobar Contrato
            </a>
        </div>
    </div>
</div>

            <!-- Formulario simplificado -->
            <div class="form-container">
                <form action="{{ route('admin.prestamos.store') }}" method="POST">
                    @csrf

                    <div class="form-row">
                        <div class="form-group">
                            <label for="user_id" class="form-label">
                                <i class="fas fa-user-search"></i>
                                Buscar Usuario
                            </label>
                            <select name="user_id" id="user_id" class="form-select" required>
                                <option value="">Escribe nombre o DNI...</option>
                                @foreach($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}">
                                        {{ $usuario->name }} {{ $usuario->apellido_paterno }} - DNI: {{ $usuario->dni }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="monto" class="form-label">
                                <i class="fas fa-dollar-sign"></i>
                                Monto del Préstamo
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">S/.</span>
                                <input type="number" name="monto" id="monto" class="form-control" 
                                       min="1" step="0.01" placeholder="0.00" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-generate">
                                <i class="fas fa-plus-circle me-2"></i>
                                Generar Préstamo
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery (requerido por Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS y CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<style>
    /* Limitar ancho del dropdown Select2 */
.select2-container--default .select2-dropdown {
    max-width: 500px !important; /* Puedes cambiar a 400px o lo que prefieras */
    min-width: 250px !important;
}

/* Centrar dropdown justo debajo del input */
.select2-container--default .select2-dropdown {
    margin-left: auto !important;
    margin-right: auto !important;
}

/* Corregir el campo de búsqueda dentro del dropdown */
.select2-search__field {
    width: 100% !important;
    box-sizing: border-box;
}
</style>
<script>
    $(document).ready(function() {
        // Inicializar Select2 con configuración mejorada
        $('#user_id').select2({
            placeholder: "Escribe nombre o DNI...",
            allowClear: true,
            width: '100%',
            minimumInputLength: 1,
            language: {
                inputTooShort: function() {
                    return "Escribe al menos 1 carácter para buscar";
                },
                noResults: function() {
                    return "No se encontraron usuarios";
                },
                searching: function() {
                    return "Buscando...";
                }
            },
            dropdownParent: $('body'), // Esto arregla el problema del dropdown
            dropdownAutoWidth: false,
width: 'resolve',
            escapeMarkup: function(markup) {
                return markup;
            }
        });

        // Auto-focus en el campo de búsqueda cuando se abre
        $('#user_id').on('select2:open', function() {
            setTimeout(function() {
                $('.select2-container--open .select2-search__field').focus();
            }, 100);
        });

        // Validación simple del formulario
       let formToSubmit = null;

$('form').on('submit', function(e) {
    e.preventDefault(); // Siempre detenemos temporalmente el envío

    const userId = $('#user_id').val();
    const monto = $('#monto').val();
    const userName = $('#user_id option:selected').text().split(' - ')[0];

    if (!userId) {
        alert('Por favor, selecciona un usuario.');
        $('#user_id').select2('open');
        return false;
    }

    if (!monto || parseFloat(monto) <= 0) {
        alert('Por favor, ingresa un monto válido.');
        $('#monto').focus();
        return false;
    }

    // Mostrar el modal con los datos
    $('#modalUser').text(userName);
    $('#modalMonto').text(parseFloat(monto).toFixed(2));

    // Guardamos el form actual para enviar después
    formToSubmit = this;

    // Mostramos el modal
    const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
    modal.show();
});
// Cuando se hace clic en "Sí, Generar"
$('#confirmSubmit').on('click', function() {
    if (formToSubmit) {
        formToSubmit.submit();
    }
});

        // Formatear monto automáticamente
        $('#monto').on('blur', function() {
            const value = parseFloat($(this).val());
            if (!isNaN(value)) {
                $(this).val(value.toFixed(2));
            }
        });
    });

    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('show');
    }
</script>


<!-- Modal de Confirmación -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="confirmModalLabel">
          <i class="fas fa-check-circle me-2"></i> Confirmar Préstamo
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <p><strong>Usuario:</strong> <span id="modalUser"></span></p>
        <p><strong>Monto:</strong> S/. <span id="modalMonto"></span></p>
        <p>¿Estás seguro que deseas generar este préstamo?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" id="confirmSubmit" class="btn btn-primary">Sí, Generar</button>
      </div>
    </div>
  </div>
</div>

</body>
</html>