<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Préstamos</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f4f4f4; }
        .prestamo { border: 1px solid #ccc; padding: 20px; margin-bottom: 20px; border-radius: 10px; background: #fff; box-shadow: 0 0 5px rgba(0,0,0,0.1);}
        h3 { margin-top: 0; }
        .detalle, .historial, .penalidades { margin-top: 15px; padding: 15px; border-radius: 8px; background: #fafafa; border: 1px solid #ddd; }
        button { margin-top: 10px; padding: 8px 15px; background: #007bff; color: #fff; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
        ul { padding-left: 20px; }
        
        /* Estilos para impresión */
        /* Estilos para impresión */
@media print {
    body { 
        background: white; 
        margin: 0; 
        padding: 0;
    }

    /* Oculta el título general al imprimir */
    h1.reporte-titulo {
        display: none;
    }

    .prestamo {
        break-inside: avoid;
        page-break-inside: avoid;
        margin-bottom: 20px;
    }

    .prestamo:not(:first-of-type) {
        page-break-before: always;
    }

    .detalle, .historial, .penalidades, .detalle-historial { 
        break-inside: avoid; 
        page-break-inside: avoid;
    }

    .historial .prestamo {
        margin-bottom: 10px;
    }

    button {
        display: none;
    }
}


    </style>
</head>
<body>

<h1 class="reporte-titulo">Reporte de Préstamos</h1>


<!-- BOTONES PARA IMPRIMIR -->
<button onclick="imprimirSeleccionados(false)">Imprimir solo el resumen</button>
<button onclick="imprimirSeleccionados(true)">Imprimir con historial completo</button>

@php
    use Carbon\Carbon;
    $hoy = Carbon::now()->startOfDay();
@endphp

@foreach($prestamos_grouped as $numero_prestamo => $historial)
    @php
        $ultimo = $historial->first();
        $fechaFin = $ultimo->fecha_fin ? Carbon::parse($ultimo->fecha_fin)->startOfDay() : null;
    @endphp

    <div class="prestamo" id="prestamo-{{ $numero_prestamo }}">
        <input type="checkbox" class="seleccion-prestamo" value="{{ $numero_prestamo }}">
        
        <h1 style="border-bottom: 2px solid #333; padding-bottom: 5px; margin-bottom: 20px;">PRÉSTAMO N° {{ $numero_prestamo }}</h1>


        <p><strong>Monto del préstamo:</strong> {{ number_format($ultimo->monto, 2) }}</p>
        <p><strong>Interés total:</strong> {{ number_format($ultimo->interes_total, 2) }}</p>
        <p><strong>Total a pagar (Monto + Interés):</strong> {{ number_format($ultimo->total_pagar, 2) }}</p>
        <p><strong>Fecha inicio:</strong> {{ $ultimo->fecha_inicio ? Carbon::parse($ultimo->fecha_inicio)->format('d/m/Y') : 'Sin fecha de inicio' }}</p>
        <p><strong>Fecha fin:</strong> {{ $ultimo->fecha_fin ? Carbon::parse($ultimo->fecha_fin)->format('d/m/Y') : 'Sin fecha de fin' }}</p>
        <p><strong>Estado actual:</strong> {{ ucfirst($ultimo->estado) }}</p>

        <button onclick="toggle('detalle-{{ $numero_prestamo }}')">Ver Detalle</button>
        <button onclick="toggle('historial-{{ $numero_prestamo }}')">Ver Historial</button>

        <!-- DETALLE DEL PRÉSTAMO ACTUAL -->
        <div id="detalle-{{ $numero_prestamo }}" class="detalle" style="display:none;">
            <h4>Detalle:</h4>
            <p><strong>Interés a pagar:</strong> {{ number_format($ultimo->interes_pagar, 2) }}</p>
            <small>(Interés correspondiente al mes actual)</small>
            <p><strong>Penalidades acumuladas:</strong> {{ number_format($ultimo->penalidades_acumuladas, 2) }}</p>
            <small>(Penalidad generada por no realizar el pago en la fecha establecida)</small>
            <p><strong>Interés acumulado:</strong> {{ number_format($ultimo->interes_acumulado, 2) }}</p>
            <small>(Interés generado por los meses anteriores que no fueron pagados)</small>
            <p><strong>Descripcion:{{ $ultimo->descripcion }}</strong></p>
            
            @if($fechaFin && $fechaFin->lessThanOrEqualTo($hoy))
                <div style="background: #ffe0e0; padding: 10px; border-radius: 5px; margin-top: 10px;">
                    <h4>Penalización vigente:</h4>
                    <p>Este préstamo ya venció y está sujeto a penalizaciones.</p>

                    <div class="penalidades">
                        <h4>Detalle de Penalidades:</h4>
                        @if($ultimo->penalidades->count() > 0)
                            <ul>
                                @foreach($ultimo->penalidades as $penalidad)
                                    <li>
                                        Penalización N° {{ $penalidad->numero_penalizacion }} |
                                        Interés Total: {{ number_format($penalidad->suma_interes, 2) }} |
                                        Interés penalidad: {{ number_format($penalidad->interes_penalidad) }}% |
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
            @endif
        </div>

        <!-- HISTORIAL -->
        <div id="historial-{{ $numero_prestamo }}" class="historial" style="display:none;">
            <h4>Historial:</h4>
            @foreach($historial->slice(1) as $version)
                @php
                    $fechaFinHist = $version->fecha_fin ? Carbon::parse($version->fecha_fin)->startOfDay() : null;
                @endphp

                <div class="prestamo" style="background: #fafafa; margin-bottom: 15px;">
                    <h3>Versión anterior ({{ $loop->iteration }})</h3>

                    <p><strong>Monto del préstamo:</strong> {{ number_format($version->monto, 2) }}</p>
                    <p><strong>Interés total:</strong> {{ number_format($version->interes_total, 2) }}</p>
                    <p><strong>Total a pagar (Monto + Interés):</strong> {{ number_format($version->total_pagar, 2) }}</p>
                    <p><strong>Fecha inicio:</strong> {{ $version->fecha_inicio ? Carbon::parse($version->fecha_inicio)->format('d/m/Y') : 'Sin fecha de inicio' }}</p>
                    <p><strong>Fecha fin:</strong> {{ $version->fecha_fin ? Carbon::parse($version->fecha_fin)->format('d/m/Y') : 'Sin fecha de fin' }}</p>
                    <p><strong>Estado:</strong> {{ ucfirst($version->estado) }}</p>

                    <button onclick="toggle('detalle-{{ $numero_prestamo }}-{{ $loop->index }}')">Ver Detalle</button>

                    <!-- DETALLE HISTORIAL -->
                    <div id="detalle-{{ $numero_prestamo }}-{{ $loop->index }}" class="detalle detalle-historial" style="display:none;">
                        <h4>Detalle del interés total:</h4>
                        <p><strong>Interés a pagar:</strong> {{ number_format($version->interes_pagar, 2) }}</p>
                        <small>(Interés correspondiente al mes actual)</small>
                        <p><strong>Penalidades acumuladas:</strong> {{ number_format($version->penalidades_acumuladas, 2) }}</p>
                        <small>(Penalidad generada por no realizar el pago en la fecha establecida)</small>
                        <p><strong>Interés acumulado:</strong> {{ number_format($version->interes_acumulado, 2) }}</p>
                        <small>(Interés generado por los meses anteriores que no fueron pagados)</small>
                        <p><strong>Descripcion:{{ $version->descripcion }}</strong></p>

                        @if($fechaFinHist && $fechaFinHist->lessThanOrEqualTo($hoy))
                            <div style="background: #ffe0e0; padding: 10px; border-radius: 5px; margin-top: 10px;">
                                <h4>Penalización vigente:</h4>
                                <p>Este préstamo vence {{ $fechaFinHist->format('d/m/Y') }} y está sujeto a penalizaciones.</p>

                                <div class="penalidades">
                                    <h4>Detalle de Penalidades:</h4>
                                    @if($version->penalidades->count() > 0)
                                        <ul>
                                            @foreach($version->penalidades as $penalidad)
                                                <li>
                                                    Penalización N° {{ $penalidad->numero_penalizacion }} |
                                                    Interés Total: {{ number_format($penalidad->suma_interes, 2) }} |
                                                    Interés penalidad: {{ number_format($penalidad->interes_penalidad) }}% |
                                                    Interés debe: {{ number_format($penalidad->interes_debe, 2) }} |
                                                    <!-- Tipo operación: {{ $penalidad->tipo_operacion }}-->
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p>Sin penalidades registradas.</p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endforeach



<script>
    function toggle(id) {
        const elem = document.getElementById(id);
        elem.style.display = (elem.style.display === 'none' || elem.style.display === '') ? 'block' : 'none';
    }

    function imprimirSeleccionados(conHistorial) {
        const prestamos = document.querySelectorAll('.prestamo');
        const seleccionados = document.querySelectorAll('.seleccion-prestamo:checked');

        if (seleccionados.length === 0) {
            alert('Por favor, selecciona al menos un préstamo para imprimir.');
            return;
        }

        console.log('Préstamos seleccionados:', seleccionados.length);
        console.log('Con historial:', conHistorial);

        // Primero ocultar todos los préstamos principales
        prestamos.forEach(p => {
            if (p.classList.contains('prestamo') && p.id && p.id.startsWith('prestamo-')) {
                p.style.display = 'none';
            }
        });

        // Ocultar todos los detalles e historiales
        document.querySelectorAll('.detalle').forEach(d => d.style.display = 'none');
        document.querySelectorAll('.historial').forEach(h => h.style.display = 'none');

        // Mostrar solo los préstamos seleccionados
        seleccionados.forEach(chk => {
            const numeroPrestamoId = chk.value;
            const prestamoDiv = document.getElementById('prestamo-' + numeroPrestamoId);
            
            console.log('Procesando préstamo:', numeroPrestamoId);
            console.log('Div encontrado:', prestamoDiv);

            if (prestamoDiv) {
                prestamoDiv.style.display = 'block';

                // Siempre mostrar el detalle del préstamo actual
                const detalleActual = document.getElementById(`detalle-${numeroPrestamoId}`);
                console.log('Detalle actual encontrado:', detalleActual);
                if (detalleActual) {
                    detalleActual.style.display = 'block';
                }

                if (conHistorial) {
                    // Mostrar historial completo
                    const historialDiv = document.getElementById(`historial-${numeroPrestamoId}`);
                    console.log('Historial div encontrado:', historialDiv);
                    
                    if (historialDiv) {
                        historialDiv.style.display = 'block';
                        
                        // Mostrar todos los detalles del historial dentro de este historial
                        const detallesHistorial = historialDiv.querySelectorAll('.detalle-historial');
                        console.log('Detalles historial encontrados:', detallesHistorial.length);
                        
                        detallesHistorial.forEach(detalle => {
                            detalle.style.display = 'block';
                            console.log('Mostrando detalle historial:', detalle.id);
                        });
                    } else {
                        console.log('No se encontró historial para préstamo:', numeroPrestamoId);
                    }
                }
            } else {
                console.log('No se encontró div para préstamo:', numeroPrestamoId);
            }
        });

        // Imprimir después de un pequeño delay
        setTimeout(() => {
            window.print();
            
            // Restaurar el estado original después de imprimir
            setTimeout(() => {
                // Mostrar todos los préstamos principales nuevamente
                prestamos.forEach(p => {
                    if (p.classList.contains('prestamo') && p.id && p.id.startsWith('prestamo-')) {
                        p.style.display = 'block';
                    }
                });
                // Ocultar todos los historiales y detalles
                document.querySelectorAll('.historial').forEach(h => h.style.display = 'none');
                document.querySelectorAll('.detalle').forEach(d => d.style.display = 'none');
            }, 500);
        }, 200);
    }

    // Agregar funcionalidad para seleccionar/deseleccionar todos
    function seleccionarTodos() {
        const checkboxes = document.querySelectorAll('.seleccion-prestamo');
        const todosSeleccionados = Array.from(checkboxes).every(cb => cb.checked);
        
        checkboxes.forEach(cb => {
            cb.checked = !todosSeleccionados;
        });
    }

    // Agregar botón para seleccionar todos (opcional)
    document.addEventListener('DOMContentLoaded', function() {
        const titulo = document.querySelector('h1');
        const btnSeleccionar = document.createElement('button');
        btnSeleccionar.textContent = 'Seleccionar/Deseleccionar Todos';
        btnSeleccionar.onclick = seleccionarTodos;
        btnSeleccionar.style.marginRight = '10px';
        titulo.parentNode.insertBefore(btnSeleccionar, titulo.nextSibling);
    });
</script>

</body>
</html>