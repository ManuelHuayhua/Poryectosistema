<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
