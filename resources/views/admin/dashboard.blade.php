 <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <h1>admin</h1>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>

                                <div class="container mt-4">
 <div class="container mt-4">
    <h2>Bienvenido Administrador</h2>

    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    {{-- Préstamos pendientes --}}
    <h4 class="mt-5">Solicitudes de Préstamos Pendientes</h4>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Usuario</th>
                <th>Monto</th>
                <th>Fecha de solicitud</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($prestamosPendientes as $prestamo)
                <tr>
                    <td>{{ $prestamo->numero_prestamo }}</td>
                    <td>{{ $prestamo->user->name }}</td>
                    <td>S/. {{ number_format($prestamo->monto, 2) }}</td>
                    <td>{{ $prestamo->created_at->format('d/m/Y') }}</td>
                    <td>
                        <form action="{{ route('prestamo.aprobar', ['id' => $prestamo->id, 'interes' => 10]) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Aprobar 10%</button>
                        </form>

                        <form action="{{ route('prestamo.aprobar', ['id' => $prestamo->id, 'interes' => 5]) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-info btn-sm">Aprobar 5%</button>
                        </form>

                        <form action="{{ route('prestamo.rechazar', $prestamo->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Rechazar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No hay préstamos pendientes.</td>
                </tr>
            @endforelse
        </tbody>
    </table>


   {{-- Préstamos Aprobados --}}
<h4 class="mt-5 text-success">Préstamos Aprobados</h4>

<table class="table table-bordered mt-3">
    <thead>
        <tr>
            <th>ID</th>
            <th>N° Préstamo</th>
            <th>Usuario</th>
            <th>Monto</th>
            <th>Interés (%)</th>
            <th>Interés a Pagar</th>
            <th>% Penalidad</th>
            <th>Penalidad por Interés</th>
            <th>Penalidades Acumuladas</th>
            <th>Total a Pagar</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Fecha de Pago</th>
            <th>Estado</th>
            <th>Descripción</th>
            <th>Creado</th>
            <th>Actualizado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse($prestamosAprobados as $prestamo)
            <tr>
                <td>{{ $prestamo->id }}</td>
                <td>{{ $prestamo->numero_prestamo }}</td> 
                <td>{{ $prestamo->user->name }}</td>
                <td>S/. {{ number_format($prestamo->monto, 2) }}</td>
                <td>{{ $prestamo->interes }}%</td>
                <td>S/. {{ number_format($prestamo->interes_pagar, 2) }}</td>
                <td>{{ $prestamo->porcentaje_penalidad ? number_format($prestamo->porcentaje_penalidad, 2) . '%' : 'N/A' }}</td>
                <td>S/. {{ number_format($prestamo->interes_penalidad, 2) }}</td>
                <td>S/. {{ number_format($prestamo->penalidades_acumuladas, 2) }}</td>
                <td>
                    S/. {{ number_format(
                        $prestamo->total_pagar 
                        ?? ($prestamo->monto + $prestamo->interes_pagar + $prestamo->interes_penalidad + $prestamo->penalidades_acumuladas), 
                    2) }}
                </td>
                <td>{{ \Carbon\Carbon::parse($prestamo->fecha_inicio)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($prestamo->fecha_fin)->format('d/m/Y') }}</td>
                <td>{{ optional($prestamo->fecha_pago)->format('d/m/Y') }}</td>
                <td>{{ ucfirst($prestamo->estado) }}</td>
                <td>{{ $prestamo->descripcion }}</td>
                <td>{{ $prestamo->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $prestamo->updated_at->format('d/m/Y H:i') }}</td>
                <td>
                    <form method="POST" action="{{ route('prestamos.renovar', $prestamo->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-warning btn-sm">Renovar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="17">No hay préstamos aprobados.</td>
            </tr>
        @endforelse
    </tbody>
</table>



