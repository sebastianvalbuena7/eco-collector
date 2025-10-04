<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Reporte de recolecciones</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #222; }
        header { text-align: center; margin-bottom: 12px; }
        h1 { font-size: 18px; margin-bottom: 4px; }
        .meta { font-size: 12px; color: #555; margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; font-size: 12px; }
        th { background: #f5f5f5; }
        ul { padding-left: 18px; }
    </style>
</head>
<body>
    <header>
        <h1>Reporte de recolecciones</h1>
        <div class="meta">
            Generado: {{ $data['generated_at'] ?? now()->toDateTimeString() }}
        </div>
    </header>

    <section>
        <h3>Estadísticas</h3>
        <ul>
            <li>Total recolecciones: {{ $data['statistics']['total'] ?? 0 }}</li>
            <li>Total reciclado (kg): {{ $data['environmental_impact']['total_weight_recycled'] ?? 0 }}</li>
            <li>CO₂ evitado (kg): {{ $data['environmental_impact']['co2_saved'] ?? 0 }}</li>
            <li>Equivalente en árboles: {{ $data['environmental_impact']['trees_equivalent'] ?? 0 }}</li>
        </ul>
    </section>

    <section>
        <h3>Estadísticas mensuales</h3>
        @if(!empty($data['monthly_data']))
            <table>
                <thead>
                    <tr><th>Mes</th><th>Total</th></tr>
                </thead>
                <tbody>
                    @foreach($data['monthly_data'] as $month => $total)
                        <tr>
                            <td>{{ \Carbon\Carbon::create(null, $month, 1)->format('F') }}</td>
                            <td>{{ $total }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No hay datos mensuales disponibles.</p>
        @endif
    </section>

    <section>
        <h3>Próximas recolecciones</h3>
        @if(!empty($data['upcoming_collections']))
            <table>
                <thead>
                    <tr><th>Fecha</th><th>Hora</th><th>Residuo</th><th>Dirección</th><th>Estado</th></tr>
                </thead>
                <tbody>
                    @foreach($data['upcoming_collections'] as $c)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($c->collection_date)->format('Y-m-d') }}</td>
                            <td>{{ \Carbon\Carbon::parse($c->collection_time)->format('H:i') }}</td>
                            <td>{{ ucfirst($c->waste_type) }}</td>
                            <td>{{ $c->address }}</td>
                            <td>{{ ucfirst($c->status) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No hay recolecciones próximas.</p>
        @endif
    </section>

    <footer style="position: fixed; bottom: 10px; left: 0; right: 0; text-align: center; font-size: 10px; color:#777;">
        EcoCollect — {{ now()->year }}
    </footer>
</body>
</html>