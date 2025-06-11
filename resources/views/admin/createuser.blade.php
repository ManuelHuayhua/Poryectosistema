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
        <label for="apellido_paterno">Apellido Paterno</label>
        <input type="text" name="apellido_paterno" id="apellido_paterno" value="{{ old('apellido_paterno') }}" required>
    </div>

    <div>
        <label for="apellido_materno">Apellido Materno</label>
        <input type="text" name="apellido_materno" id="apellido_materno" value="{{ old('apellido_materno') }}" required>
    </div>

    <div>
        <label for="nacionalidad">Nacionalidad</label>
        <input type="text" name="nacionalidad" id="nacionalidad" value="{{ old('nacionalidad') }}" required>
    </div>

    <div>
        <label for="sexo">Sexo</label>
        <input type="text" name="sexo" id="sexo" value="{{ old('sexo') }}" required>
    </div>

    <div>
        <label for="estado_civil">Estado Civil</label>
        <input type="text" name="estado_civil" id="estado_civil" value="{{ old('estado_civil') }}" required>
    </div>

    <div>
        <label for="fecha_nacimiento">Fecha de Nacimiento</label>
        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}">
    </div>

    <div>
        <label for="telefono">Teléfono</label>
        <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}">
    </div>

    <div>
        <label for="celular">Celular</label>
        <input type="text" name="celular" id="celular" value="{{ old('celular') }}">
    </div>

    <div>
        <label for="direccion">Dirección</label>
        <input type="text" name="direccion" id="direccion" value="{{ old('direccion') }}">
    </div>

    <div>
        <label for="tipo_origen">Tipo Origen</label>
        <input type="text" name="tipo_origen" id="tipo_origen" value="{{ old('tipo_origen') }}">
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