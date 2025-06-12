<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Préstamos (Historial)</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .prestamo { border: 1px solid #ccc; padding: 15px; margin-bottom: 15px; border-radius: 8px; background: #f9f9f9; }
        .detalle { background: #fff; padding: 10px; margin-top: 10px; border-radius: 5px; }
        .penalidades { background: #ffe; margin-top: 10px; padding: 10px; border-radius: 5px; }
        button { margin-top: 10px; padding: 8px 12px; background: #007bff; color: #fff; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
    </style>
</head>
<body>

<h1>Reporte de Préstamos (Historial)</h1>

@php
    use Carbon\Carbon;
@endphp

@foreach($prestamos_grouped as $numero_prestamo => $historial)
    @php
        $ultimo = $historial->first(); // Última versión
    @endphp

    <div class="prestamo">
        <h3>Préstamo N°: {{ $numero_prestamo }}</h3>

        <h4>Datos base:</h4>
        <p>Monto del préstamo: {{ number_format($ultimo->monto, 2) }}</p>
        <p>Interés (%): {{ number_format($ultimo->interes, 2) }}</p>
        <p>Interés a pagar: {{ number_format($ultimo->interes_pagar, 2) }}</p>

        <h4>Penalidades y acumulados:</h4>
        <p>Penalidades acumuladas: {{ number_format($ultimo->penalidades_acumuladas, 2) }}</p>
        <p>Interés acumulado: {{ number_format($ultimo->interes_acumulado, 2) }}</p>

        <h4>Resumen financiero:</h4>
        <p>Interés total: {{ number_format($ultimo->interes_total, 2) }}</p>
        <p>Total a pagar (Monto + Interés total): {{ number_format($ultimo->total_pagar, 2) }}</p>

        <h4>Fechas:</h4>
        <p>Fecha inicio: {{ $ultimo->fecha_inicio ? Carbon::parse($ultimo->fecha_inicio)->format('d/m/Y') : 'Sin fecha de inicio' }}</p>
        <p>Fecha fin: {{ $ultimo->fecha_fin ? Carbon::parse($ultimo->fecha_fin)->format('d/m/Y') : 'Sin fecha de fin' }}</p>
        <p>Fecha de pago: {{ $ultimo->fecha_pago ? Carbon::parse($ultimo->fecha_pago)->format('d/m/Y') : 'Pendiente de pago' }}</p>
        <p>Estado actual: {{ ucfirst($ultimo->estado) }}</p>

        <div class="penalidades">
            <h4>Detalle de Penalidades:</h4>
            @if($ultimo->penalidades->count() > 0)
                <ul>
                    @foreach($ultimo->penalidades as $penalidad)
                        <li>
                            Penalización N° {{ $penalidad->numero_penalizacion }} |
                            Suma interés: {{ number_format($penalidad->suma_interes, 2) }} |
                            Interés penalidad: {{ number_format($penalidad->interes_penalidad, 2) }} |
                            Interés debe: {{ number_format($penalidad->interes_debe, 2) }} |
                            Tipo operación: {{ $penalidad->tipo_operacion }}
                        </li>
                    @endforeach
                </ul>
            @else
                <p>Sin penalidades registradas.</p>
            @endif
        </div>

        <button onclick="document.getElementById('historial-{{ $numero_prestamo }}').classList.toggle('show')">
            Ver Historial
        </button>

        <div id="historial-{{ $numero_prestamo }}" class="detalle" style="display:none;">
            <h4>Historial completo:</h4>
            @foreach($historial->slice(1) as $version)
                <div style="border: 1px solid #ddd; padding:10px; margin:10px 0;">
                    <h4>Datos base:</h4>
                    <p>Monto del préstamo: {{ number_format($version->monto, 2) }}</p>
                    <p>Interés (%): {{ number_format($version->interes, 2) }}</p>
                    <p>Interés a pagar: {{ number_format($version->interes_pagar, 2) }}</p>

                    <h4>Penalidades y acumulados:</h4>
                    <p>Penalidades acumuladas: {{ number_format($version->penalidades_acumuladas, 2) }}</p>
                    <p>Interés acumulado: {{ number_format($version->interes_acumulado, 2) }}</p>

                    <h4>Resumen financiero:</h4>
                    <p>Interés total: {{ number_format($version->interes_total, 2) }}</p>
                    <p>Total a pagar (Monto + Interés total): {{ number_format($version->total_pagar, 2) }}</p>

                    <h4>Fechas:</h4>
                    <p>Fecha inicio: {{ $version->fecha_inicio ? Carbon::parse($version->fecha_inicio)->format('d/m/Y') : 'Sin fecha de inicio' }}</p>
                    <p>Fecha fin: {{ $version->fecha_fin ? Carbon::parse($version->fecha_fin)->format('d/m/Y') : 'Sin fecha de fin' }}</p>
                    <p>Fecha de pago: {{ $version->fecha_pago ? Carbon::parse($version->fecha_pago)->format('d/m/Y') : 'Pendiente de pago' }}</p>
                    <p>Estado: {{ ucfirst($version->estado) }}</p>

                    <div class="penalidades">
                        <h5>Detalle de Penalidades:</h5>
                        @if($version->penalidades->count() > 0)
                            <ul>
                                @foreach($version->penalidades as $penalidad)
                                    <li>
                                        Penalización N° {{ $penalidad->numero_penalizacion }} |
                                        Suma interés: {{ number_format($penalidad->suma_interes, 2) }} |
                                        Interés penalidad: {{ number_format($penalidad->interes_penalidad, 2) }} |
                                        Interés debe: {{ number_format($penalidad->interes_debe, 2) }} |
                                        Tipo operación: {{ $penalidad->tipo_operacion }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>Sin penalidades registradas.</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endforeach

<script>
    document.querySelectorAll('button').forEach(btn => {
        btn.addEventListener('click', function(){
            const historial = this.nextElementSibling;
            historial.style.display = (historial.style.display === 'none' || historial.style.display === '') ? 'block' : 'none';
        });
    });
</script>

</body>
</html>
