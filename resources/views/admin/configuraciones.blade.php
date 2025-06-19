<div class="container">
    <h1 class="mb-4">📋 Configuraciones</h1>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Formulario de registro --}}
    <div class="card mb-4">
        <div class="card-header">➕ Nueva Configuración</div>
        <div class="card-body">
            <form action="{{ route('admin.configuraciones.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="tipo_origen" class="form-label">Tipo Origen</label>
                    <input type="text" class="form-control" id="tipo_origen" name="tipo_origen" required>
                </div>

                <div class="mb-3">
                    <label for="interes" class="form-label">Interés (%)</label>
                    <input type="number" step="0.01" class="form-control" id="interes" name="interes" required>
                </div>

                <div class="mb-3">
                    <label for="penalidad" class="form-label">Penalidad (%)</label>
                    <input type="number" step="0.01" class="form-control" id="penalidad" name="penalidad" required>
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>

    {{-- Tabla de configuraciones --}}
    <h2 class="mb-3">📄 Configuraciones Registradas</h2>
  <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tipo Origen</th>
            <th>Interés (%)</th>
            <th>Penalidad (%)</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($configuraciones as $config)
            <tr>
                <form action="{{ route('admin.configuraciones.update', $config->id) }}" method="POST">
                    @csrf
                    <td>{{ $config->id }}</td>
                    <td><input type="text" name="tipo_origen" value="{{ $config->tipo_origen }}" class="form-control" required></td>
                    <td><input type="number" step="0.01" name="interes" value="{{ $config->interes }}" class="form-control" required></td>
                    <td><input type="number" step="0.01" name="penalidad" value="{{ $config->penalidad }}" class="form-control" required></td>
                    <td>{{ $config->created_at->format('Y-m-d') }}</td>
                    <td class="d-flex gap-1">
                        <button type="submit" class="btn btn-sm btn-warning">💾 Guardar</button>
                </form>
                <form action="{{ route('admin.configuraciones.destroy', $config->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">🗑️ Eliminar</button>
                </form>
                    </td>
            </tr>
        @empty
            <tr><td colspan="6">No hay configuraciones registradas.</td></tr>
        @endforelse
    </tbody>
</table>
</div>