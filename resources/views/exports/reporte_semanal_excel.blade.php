<table>
    <thead>
        <tr>
            <th>Semana</th>
            <th>Desde</th>
            <th>Hasta</th>
            <th>#</th>
            <th>N° Préstamo</th>
            <th>Usuario</th>
            <th>Monto</th>
            <th>Interés</th>
            <th>Interés a Pagar</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reporteSemanal as $semana)
            @foreach($semana['prestamos'] as $index => $prestamo)
                <tr>
                    <td>{{ $semana['semana'] }}</td>
                    <td>{{ \Carbon\Carbon::parse($semana['desde'])->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($semana['hasta'])->format('d/m/Y') }}</td>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $prestamo->numero_prestamo }}</td>
                    <td>{{ $prestamo->user->name ?? '—' }} {{ $prestamo->user->apellido_paterno ?? '' }}</td>
                    <td>{{ $prestamo->monto }}</td>
                    <td>{{ $prestamo->interes }}%</td>
                    <td>{{ $prestamo->interes_pagar }}</td>
                    <td>{{ $prestamo->fecha_inicio }}</td>
                    <td>{{ $prestamo->fecha_fin }}</td>
                    <td>{{ $prestamo->estado }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
