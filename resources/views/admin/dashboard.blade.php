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
    <h2>Bienvenido, {{ Auth::user()->name }}</h2>

    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
<a href="{{ route('admin.createuser') }}" class="btn btn-primary">
    Crear nuevo usuario
</a>
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
                      <form action="{{ route('prestamo.aprobar', $prestamo->id) }}" method="POST">
    @csrf

    <!-- Selección de interés -->
    <label for="interes">Interés:</label>
    <select name="interes" required class="form-control">
        @foreach ($configuraciones as $config)
            <option value="{{ $config->interes }}">
                {{ $config->interes }}%
            </option>
        @endforeach
    </select>

    <!-- Selección de penalidad -->
    <label for="penalidad" class="mt-2">Penalidad:</label>
    <select name="penalidad" required class="form-control">
        @foreach ($configuraciones as $config)
            <option value="{{ $config->penalidad }}">
                {{ $config->penalidad }}%
            </option>
        @endforeach
    </select>

    <button type="submit" class="btn btn-success mt-2">Aprobar</button>
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
            <th>Interés Acumulado</th>
            <th><strong>Interés Total</strong></th> <!-- NUEVA COLUMNA -->
            <th>Total a Pagar</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Fecha de Pago</th>
            <th>Estado</th>
            <th>Descripción</th>
            

            
            
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

                 <td>S/. {{ number_format($prestamo->interes_acumulado, 2) }}</td>
               <!-- NUEVA COLUMNA: INTERÉS TOTAL -->
<td>
    S/. {{ number_format($prestamo->interes_total, 2) }}</td>
              <!-- TOTAL A PAGAR: Monto + Interés Total -->
<td>
    S/. {{ number_format($prestamo->total_pagar,2) }}
</td>
                <td>{{ \Carbon\Carbon::parse($prestamo->fecha_inicio)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($prestamo->fecha_fin)->format('d/m/Y') }}</td>
                <td>{{ optional($prestamo->fecha_pago)->format('d/m/Y') }}</td>
                <td>{{ ucfirst($prestamo->estado) }}</td>
                <td>{{ $prestamo->descripcion }}</td>
                

                
                <td>
              <form method="POST" action="{{ route('prestamos.penalidad', $prestamo->id) }}">
    @csrf
    <button type="submit" class="btn btn-danger btn-sm">Penalidad</button>
</form>
                </td>
                <td>
               <form action="{{ route('prestamos.renovar', $prestamo->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de renovar este préstamo?')">
    @csrf
    <button type="submit" class="btn btn-primary btn-sm mt-1">Renovar</button>
</form>
                </td>
                <td>
                  <form method="POST" action="{{ route('prestamos.diferencia', $prestamo->id) }}" class="mt-1">
    @csrf
    <div class="input-group">
        <input type="number" step="0.01" min="0" max="{{ $prestamo->monto }}" name="nuevo_monto" class="form-control form-control-sm" placeholder="Monto a descontar" required>
        <button type="submit" class="btn btn-warning btn-sm">Diferencia</button>
    </div>
    <small class="text-muted">Máx: {{ number_format($prestamo->monto, 2) }}</small>
</form>
                    <td>
    <form action="{{ route('prestamos.pagado', $prestamo->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de marcar como pagado?')">
        @csrf
        <button type="submit" class="btn btn-success btn-sm">Pagado</button>
    </form>
</td>
                </td>
                
            </tr>
        @empty
            <tr>
                <td colspan="17">No hay préstamos aprobados.</td>
            </tr>
        @endforelse
    </tbody>
</table>



