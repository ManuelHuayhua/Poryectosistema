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

                                <div class="container mt-4"></div>

                                <div class="container">
    <h2>Crear nuevo usuario</h2>

    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.storeuser') }}" method="POST">
        @csrf

        <div>
            <label for="name">Nombre</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
            @error('name') <small style="color:red;">{{ $message }}</small> @enderror
        </div>

        <div>
            <label for="email">Correo electrónico</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
            @error('email') <small style="color:red;">{{ $message }}</small> @enderror
        </div>

        <div>
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" required>
            @error('password') <small style="color:red;">{{ $message }}</small> @enderror
        </div>

        <div>
            <label for="password_confirmation">Confirmar contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>

        <div>
            <label>
                <input type="checkbox" name="is_admin" {{ old('is_admin') ? 'checked' : '' }}>
                ¿Es administrador?
            </label>
        </div>

        <button type="submit">Crear usuario</button>
    </form>
</div>