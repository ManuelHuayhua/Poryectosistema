<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Estadístico</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container py-4">
    <h2 class="mb-4 text-center">Panel Estadístico</h2>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white text-center">
                <div class="card-body">
                    <h5>Total Usuarios</h5>
                    <h2>{{ $totalUsuarios }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white text-center">
                <div class="card-body">
                    <h5>Total Clientes</h5>
                    <h2>{{ $totalClientes }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white text-center">
                <div class="card-body">
                    <h5>Total Préstamos</h5>
                    <h2>{{ $totalPrestamos }}</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5>Préstamos por mes (aprobado/pagado)</h5>
            <canvas id="prestamosChart" height="300"></canvas>
        </div>
    </div>
</div>

<script>
    const labels = @json($labels);
    const datos = @json($datos);

    const ctx = document.getElementById('prestamosChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Préstamos',
                data: datos,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
</body>
</html>
