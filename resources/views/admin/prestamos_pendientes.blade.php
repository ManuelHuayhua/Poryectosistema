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
            <a href="{{ route('indexAdmin') }}" class="nav-link"><i class="fas fa-home"></i><span>Inicio</span></a>
        </div>
        <div class="nav-item">
            <a href="{{ route('admin.createuser') }}" class="nav-link "><i class="fas fa-user-circle" ></i><span>Crear Usuario</span></a>
        </div>
        <div class="nav-item ">
            <a href="{{ route('admin.prestamos.pendientes') }}" class="nav-link  active" ><i class="fas fa-download"></i><span>Descargas Contrato</span></a>
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
    
{{-- VISTA DE PRÉSTAMOS PENDIENTES --}}
<div class="container no-print my-4">
    <h2 class="mb-4">Préstamos Pendientes</h2>

    {{-- Inputs para interés y penalidad --}}
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="interes" class="form-label">Interés (%)</label>
            <input type="number" id="interes" class="form-control" placeholder="Ej: 5">
        </div>
        <div class="col-md-3">
            <label for="penalidad" class="form-label">Penalidad por mora (%)</label>
            <input type="number" id="penalidad" class="form-control" placeholder="Ej: 2">
        </div>
    </div>

    @if($prestamos->isEmpty())
        <div class="alert alert-info">No hay préstamos pendientes.</div>
    @else
        <table class="table table-bordered table-hover text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Usuario</th>
                    <th>N° Préstamo</th>
                    <th>Monto</th>
                    <th>Fecha Inicio</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($prestamos as $index => $prestamo)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $prestamo->user->name }} {{ $prestamo->user->apellido_paterno }}</td>
                        <td>{{ $prestamo->numero_prestamo }}</td>
                        <td>S/ {{ number_format($prestamo->monto, 2) }}</td>
                        <td>{{ $prestamo->fecha_inicio }}</td>
                        <td><span class="badge bg-warning text-dark">{{ ucfirst($prestamo->estado) }}</span></td>
                        <td>
                            <button 
                                class="btn btn-primary btn-sm"
                                onclick="generarContrato({{ $prestamo->id }}, '{{ $prestamo->user->name }}', '{{ $prestamo->user->apellido_paterno }}', '{{ $prestamo->user->apellido_materno }}', '{{ $prestamo->user->nacionalidad }}', '{{ $prestamo->user->fecha_nacimiento }}', '{{ $prestamo->user->direccion }}', '{{ $prestamo->user->celular }}', '{{ $prestamo->numero_prestamo }}', '{{ $prestamo->monto }}', '{{ $prestamo->user->dni }}')"
                            >
                                Descargar
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

{{-- CONTRATO OCULTO --}}
<div id="formato-contrato" class="container card p-4 shadow" style="display: none;">
    <div class="card-body">
        <h3 class="text-center mb-4">Contrato de Préstamo</h3>

        <p>En la fecha <strong><span id="fecha-contrato"></span></strong>, la empresa acuerda realizar un préstamo a la siguiente persona:</p>

        <ul>
            <li><strong>Nombre completo:</strong> <span id="nombre-cliente"></span></li>
            <li><strong>Nacionalidad:</strong> <span id="nacionalidad-cliente"></span></li>
            <li><strong>Fecha de nacimiento:</strong> <span id="nacimiento-cliente"></span></li>
            <li><strong>Dirección:</strong> <span id="direccion-cliente"></span></li>
            <li><strong>Celular:</strong> <span id="celular-cliente"></span></li>
                <li><strong>DNI:</strong> <span id="dni-cliente"></span></li>

        </ul>

        <p>El cliente acepta haber recibido en calidad de préstamo la suma de <strong>S/ <span id="monto-prestamo"></span></strong> (soles), correspondiente al préstamo número <strong><span id="numero-prestamo"></span></strong>.</p>

        <p>Este préstamo estará sujeto a un interés del <strong><span id="interes-aplicado"></span>%</strong> y en caso de mora se aplicará una penalidad del <strong><span id="penalidad-aplicada"></span>%</strong> adicional.</p>

        <p>Ambas partes aceptan y reconocen los términos establecidos en este contrato, comprometiéndose a cumplir con las obligaciones derivadas del mismo.</p>

        <div class="row mt-5">
            <div class="col-6 text-center">
                ___________________________<br>
                <em>Firma del Cliente</em>
            </div>
            <div class="col-6 text-center">
                ___________________________<br>
                <em>Firma de la Empresa</em>
            </div>
        </div>
    </div>
</div>

{{-- ESTILOS DE IMPRESIÓN --}}
<style>
    @media print {
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }

        .no-print, nav, .btn, .table, .form-control, .form-label, input {
            display: none !important;
        }

        #formato-contrato {
            display: block !important;
        }
    }
</style>

{{-- SCRIPT --}}
<script>
    function generarContrato(id, nombre, apePaterno, apeMaterno, nacionalidad, nacimiento, direccion, celular, numero, monto, dni) {
    const interes = document.getElementById("interes").value || "0";
    const penalidad = document.getElementById("penalidad").value || "0";

    const fechaHoy = new Date();
    const fechaFormateada = fechaHoy.toLocaleDateString('es-PE', {
    year: 'numeric',
    month: '2-digit',
    day: '2-digit',
    timeZone: 'America/Lima'
}).split('/').reverse().join('-'); // Formato YYYY-MM-DD

    document.getElementById("nombre-cliente").textContent = `${nombre} ${apePaterno} ${apeMaterno}`;
    document.getElementById("nacionalidad-cliente").textContent = nacionalidad;
    document.getElementById("nacimiento-cliente").textContent = nacimiento;
    document.getElementById("direccion-cliente").textContent = direccion;
    document.getElementById("celular-cliente").textContent = celular;
    document.getElementById("dni-cliente").textContent = dni;

    document.getElementById("numero-prestamo").textContent = numero;
    document.getElementById("monto-prestamo").textContent = parseFloat(monto).toFixed(2);
    document.getElementById("fecha-contrato").textContent = fechaFormateada;
    document.getElementById("interes-aplicado").textContent = interes;
    document.getElementById("penalidad-aplicada").textContent = penalidad;

    document.getElementById("formato-contrato").style.display = "block";
    window.print();
}

    document.addEventListener("keydown", function(e) {
        if (e.ctrlKey && e.key === "p") {
            e.preventDefault();
            alert("Primero haz clic en 'Descargar' para generar el contrato.");
        }
    });
 

</script>
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('show');
    }
</script>

</body>
</html>




