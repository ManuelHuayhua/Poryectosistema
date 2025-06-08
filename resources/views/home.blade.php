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
</div>
