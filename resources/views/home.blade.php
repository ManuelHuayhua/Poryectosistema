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
    <h3 class="mt-5">Tus Préstamos</h3>
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Monto</th>
                <th>Interés (%)</th>
                <th>Interés a pagar</th>
                <th>Penalidad (%)</th>
                <th>Penalidades acumuladas</th>
                <th>Total a pagar</th>
                <th>Estado</th>
                <th>Fecha inicio</th>
                <th>Fecha fin</th>
                <th>Fecha pago</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            @forelse($prestamos as $prestamo)
                <tr>
                    <td>{{ $prestamo->numero_prestamo }}</td>
                    <td>S/ {{ number_format($prestamo->monto, 2) }}</td>
                    <td>{{ $prestamo->interes }}%</td>
                    <td>S/ {{ number_format($prestamo->interes_pagar, 2) }}</td>
                    <td>{{ $prestamo->porcentaje_penalidad ?? '0' }}%</td>
                    <td>S/ {{ number_format($prestamo->penalidades_acumuladas, 2) }}</td>
                    <td>S/ {{ number_format($prestamo->total_pagar, 2) }}</td>
                    <td>{{ ucfirst($prestamo->estado) }}</td>
                    <td>{{ $prestamo->fecha_inicio ?? '-' }}</td>
                    <td>{{ $prestamo->fecha_fin ?? '-' }}</td>
                    <td>{{ $prestamo->fecha_pago ?? '-' }}</td>
                    <td>{{ $prestamo->descripcion ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" class="text-center">No tienes préstamos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
