
<div class="container my-4">
    <h1 class="text-center mb-4">📄 Reporte de Préstamos</h1>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>N° Préstamo</th>
                <th>Usuario</th>
                <th>Monto</th>
                <th>Interés (%)</th>
                <th>Total a Pagar</th>
                <th>Estado</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Descripción</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($prestamos as $prestamo)
            <tr>
                <td>{{ $prestamo->id }}</td>
                <td>{{ $prestamo->numero_prestamo }}</td>
                <td>{{ $prestamo->user->name ?? 'Sin usuario' }}</td>
                <td>S/ {{ number_format($prestamo->monto, 2) }}</td>
                <td>{{ $prestamo->interes }}%</td>
                <td>S/ {{ number_format($prestamo->interes_pagar, 2) }}</td>
                <td>{{ ucfirst($prestamo->estado) }}</td>
                <td>{{ $prestamo->fecha_inicio }}</td>
                <td>{{ $prestamo->fecha_fin }}</td>
                <td>{{ $prestamo->descripcion }}</td>
                 <td>{{ $prestamo->estado }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

