<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<div class="container my-4">
    <h1 class="text-center mb-4">📄 Reporte de Préstamos</h1>

    {{-- Botón de impresión --}}
    <div class="mb-3 no-print text-end">
        <button onclick="imprimirSeleccionados()" class="btn btn-success">🖨️ Imprimir Seleccionados</button>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-dark text-center align-middle">
            <tr>
                <th></th>
                <th>N° Préstamo</th>
                <th>Fecha Último Préstamo</th>
                <th>Fecha Último Pago</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($prestamos as $numero_prestamo => $registros)
                @php
                    $ultimo = $registros->sortByDesc('fecha_prestamos')->first();
                @endphp

                <tr class="fila-principal-{{ $numero_prestamo }}">
                    <td class="text-center">
                        <input type="checkbox" class="seleccionar-reporte" data-target="{{ $numero_prestamo }}">
                    </td>
                    <td>{{ $numero_prestamo }}</td>
                    <td>{{ $ultimo->fecha_prestamos }}</td>
                    <td>{{ $ultimo->fecha_pago }}</td>
                    <td class="text-center">
                        <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#detalle-{{ $numero_prestamo }}">
                            Ver Detalle
                        </button>
                    </td>
                </tr>

                {{-- Detalles --}}
                <tr class="collapse bloque-imprimible bloque-{{ $numero_prestamo }}" id="detalle-{{ $numero_prestamo }}">
                    <td colspan="5">
                        <table class="table table-sm table-bordered text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID Préstamo</th>
                                    <th>Item</th>
                                    <th>Renovación</th>
                                    <th>Junta</th>
                                    <th>Fecha Préstamo</th>
                                    <th>Fecha Pago</th>
                                    <th>Monto</th>
                                    <th>Interés</th>
                                    <th>% Interés</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalMonto = 0;
                                    $totalInteres = 0;
                                @endphp
                                @foreach($registros->sortBy('fecha_prestamos') as $detalle)
                                    @php
                                        $totalMonto += $detalle->monto;
                                        $totalInteres += $detalle->interes;
                                    @endphp
                                    <tr>
                                        <td>{{ $detalle->prestamo_id }}</td>
                                        <td>{{ $detalle->item }}</td>
                                        <td>{{ $detalle->renovacion }}</td>
                                        <td>{{ $detalle->junta }}</td>
                                        <td>{{ $detalle->fecha_prestamos }}</td>
                                        <td>{{ $detalle->fecha_pago }}</td>
                                        <td>S/ {{ number_format($detalle->monto, 2) }}</td>
                                        <td>S/ {{ number_format($detalle->interes, 2) }}</td>
                                        <td>{{ $detalle->interes_porcentaje }}%</td>
                                        <td>{{ $detalle->descripcion }}</td>
                                        <td>{{ $detalle->estado }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-secondary">
                                <tr>
                                    <th colspan="6" class="text-end">Totales:</th>
                                    <th>S/ {{ number_format($totalMonto, 2) }}</th>
                                    <th>S/ {{ number_format($totalInteres, 2) }}</th>
                                    <th colspan="3"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Estilos de impresión --}}
<style>
    /* --- ESTILOS EN PANTALLA --- */
    .container {
        max-width: 100%;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        table-layout: auto;
    }

    th, td {
        text-align: center;
        vertical-align: middle;
        padding: 8px;
        border: 1px solid #dee2e6;
        font-size: 14px;
    }

    thead th {
        background-color: #343a40;
        color: white;
    }

    tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    h1 {
        font-size: 28px;
        text-align: center;
        font-weight: bold;
        margin-bottom: 20px;
    }

    /* Botón flotante en pantallas pequeñas */
    @media (max-width: 768px) {
        .btn {
            width: 100%;
            margin-bottom: 10px;
        }

        table {
            font-size: 12px;
        }

        h1 {
            font-size: 22px;
        }
    }

    /* --- ESTILOS SOLO PARA IMPRESIÓN --- */
    @media print {
        body * {
            visibility: hidden;
        }

        .seleccionado-imprimir,
        .seleccionado-imprimir * {
            visibility: visible !important;
        }

        .seleccionado-imprimir {
            display: table-row !important;
        }

        .no-print {
            display: none !important;
        }

        .container {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        table {
            width: 100% !important;
            font-size: 11px !important;
        }

        th, td {
            border: 1px solid #000 !important;
            padding: 5px !important;
            word-break: break-word;
        }

        h1 {
            font-size: 20px !important;
            text-align: center;
            margin: 0 0 15px 0;
        }
    }
</style>


{{-- Script --}}
<script>
    function imprimirSeleccionados() {
        // Limpiar
        document.querySelectorAll('.seleccionado-imprimir').forEach(e => e.classList.remove('seleccionado-imprimir'));

        // Agregar a los seleccionados
        document.querySelectorAll('.seleccionar-reporte:checked').forEach(cb => {
            const numero = cb.getAttribute('data-target');
            const fila = document.querySelector('.fila-principal-' + numero);
            const detalle = document.querySelector('.bloque-' + numero);

            if (fila) fila.classList.add('seleccionado-imprimir');
            if (detalle) {
                detalle.classList.add('seleccionado-imprimir', 'show');
            }
        });

        window.print();
    }
</script>
