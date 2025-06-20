<div class="container">
    <h2>Generar Préstamo (Administrador)</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.prestamos.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="user_id" class="form-label">Seleccionar Usuario:</label>
           <select name="user_id" id="user_id" class="form-select" required>
    <option value="">-- Elegir usuario --</option>
    @foreach($usuarios as $usuario)
        <option value="{{ $usuario->id }}">
            {{ $usuario->apellido_paterno }} {{ $usuario->apellido_materno }}, {{ $usuario->name }} - DNI: {{ $usuario->dni }}
        </option>
    @endforeach
</select>
        </div>

        <div class="mb-3">
            <label for="monto" class="form-label">Monto del Préstamo:</label>
            <input type="number" name="monto" id="monto" class="form-control" min="1" required>
        </div>

        <button type="submit" class="btn btn-primary">Registrar Préstamo</button>
    </form>
</div>




<!-- jQuery (requerido por Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS y CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  $(document).ready(function() {
    $('#user_id').select2({
      placeholder: "Buscar por nombre o DNI...",
      width: '100%',
    });
  });
</script>