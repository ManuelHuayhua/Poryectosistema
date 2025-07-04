<table style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            <th style="border: 1px solid #000; padding: 4px;">#</th>
            <th style="border: 1px solid #000; padding: 4px;">Cliente</th>
            <th style="border: 1px solid #000; padding: 4px;">Semana</th>
            <th style="border: 1px solid #000; padding: 4px;">Fecha</th>
            <th style="border: 1px solid #000; padding: 4px;">Monto</th>
            <th style="border: 1px solid #000; padding: 4px;">Estado</th>
            <th style="border: 1px solid #000; padding: 4px;">Registrado</th>
        </tr>
    </thead>
    <tbody>
        @php
            $historial = $pagos->sortBy('fecha_pago')
                ->groupBy(fn ($p) => \Carbon\Carbon::parse($p->fecha_pago)->toDateString());
            $inicio = \Carbon\Carbon::parse($periodo->periodo_inicio)->startOfWeek(\Carbon\Carbon::SUNDAY);
        @endphp

        @foreach ($historial as $fecha => $grupo)
            @php
                $semana = $inicio->diffInWeeks(\Carbon\Carbon::parse($fecha)) + 1;
            @endphp
            @foreach ($grupo->sortBy('aporte.numero_cliente') as $i => $pago)
                <tr>
                    <td style="border: 1px solid #000; padding: 4px;">
                        {{ $loop->parent->iteration }}-{{ $i + 1 }}
                    </td>
                    <td style="border: 1px solid #000; padding: 4px;">
                        {{ $pago->aporte->numero_cliente }} {{ $pago->aporte->nombre }} {{ $pago->aporte->apellido }}
                    </td>
                    <td style="border: 1px solid #000; padding: 4px;">Semana {{ $semana }}</td>
                    <td style="border: 1px solid #000; padding: 4px;">
                        {{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y') }}
                    </td>
                    <td style="border: 1px solid #000; padding: 4px;">
                        {{ number_format($pago->monto, 2) }}
                    </td>
                    <td style="border: 1px solid #000; padding: 4px;">{{ ucfirst($pago->estado) }}</td>
                    <td style="border: 1px solid #000; padding: 4px;">
                        {{ $pago->created_at->format('d/m/Y H:i') }}
                    </td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
