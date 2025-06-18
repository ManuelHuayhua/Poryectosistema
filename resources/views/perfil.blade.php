<div class="container mt-4">
    <h2>Mi Perfil</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>Nombre:</strong> {{ $usuario->name }}</p>
            <p><strong>Apellido Paterno:</strong> {{ $usuario->apellido_paterno }}</p>
            <p><strong>Apellido Materno:</strong> {{ $usuario->apellido_materno }}</p>
            <p><strong>DNI:</strong> {{ $usuario->dni }}</p>
            <p><strong>Email:</strong> {{ $usuario->email }}</p>
            <p><strong>Teléfono:</strong> {{ $usuario->telefono }}</p>
            <p><strong>Celular:</strong> {{ $usuario->celular }}</p>
            <p><strong>Dirección:</strong> {{ $usuario->direccion }}</p>
            <p><strong>Sexo:</strong> {{ $usuario->sexo }}</p>
            <p><strong>Estado Civil:</strong> {{ $usuario->estado_civil }}</p>
            <p><strong>Fecha de Nacimiento:</strong> {{ $usuario->fecha_nacimiento }}</p>
            <p><strong>Nacionalidad:</strong> {{ $usuario->nacionalidad }}</p>
            <p><strong>Tipo de Origen:</strong> {{ $usuario->tipo_origen }}</p>
            <p><strong>Rol:</strong> {{ $usuario->is_admin ? 'Administrador' : 'Usuario' }}</p>
        </div>
    </div>
</div>


 {{-- Cambiar contraseña --}}
    <div class="card">
        <div class="card-header">
            <h4>Cambiar Contraseña</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('perfil.cambiarPassword') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label"><strong>Usuario:</strong></label>
                    <input type="text" class="form-control" value="{{ $usuario->name }}" disabled>
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>DNI:</strong></label>
                    <input type="text" class="form-control" value="{{ $usuario->dni }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Nueva Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </div>

                @if (session('success_password'))
                    <div class="alert alert-success">{{ session('success_password') }}</div>
                @endif

                <button type="submit" class="btn btn-primary">Actualizar Contraseña</button>
            </form>
        </div>
    </div>
</div>