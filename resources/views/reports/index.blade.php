@extends('layouts.app')

@section('title','Reporte de recolecciones')

@section('content')
<div class="container">
    <h1>Reporte de recolecciones</h1>

    <div class="row mb-4">
        <div class="col-md-6">
            <h5>Estadísticas</h5>
            <ul>
                <li>Total recolecciones: {{ $statistics['total'] ?? 0 }}</li>
                <li>Pendientes: {{ $statistics['pending'] ?? 0 }}</li>
                <li>En progreso: {{ $statistics['in_progress'] ?? 0 }}</li>
                <li>Completadas: {{ $statistics['completed'] ?? 0 }}</li>
                <li>Total reciclado (kg): {{ $environmentalImpact['total_weight_recycled'] ?? 0 }}</li>
            </ul>
        </div>

        <div class="col-md-6">
            <h5>Impacto ambiental estimado</h5>
            <ul>
                <li>CO₂ evitado (kg): {{ $environmentalImpact['co2_saved'] ?? 0 }}</li>
                <li>Equivalente en árboles: {{ $environmentalImpact['trees_equivalent'] ?? 0 }}</li>
                <li>Energía estimada ahorrada (kWh): {{ $environmentalImpact['energy_saved'] ?? 0 }}</li>
            </ul>
            <a href="{{ route('reports.exportPDF') }}" class="btn btn-outline-primary">Descargar PDF</a>
        </div>
    </div>

    <h4>Próximas recolecciones</h4>
    @if($upcomingCollections && count($upcomingCollections))
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Residuo</th>
                    <th>Dirección</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($upcomingCollections as $c)
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

    <h4 class="mt-4">Estadísticas mensuales ({{ now()->year }})</h4>
    @if($monthlyStats && count($monthlyStats))
        <table class="table table-bordered">
            <thead><tr><th>Mes</th><th>Total</th></tr></thead>
            <tbody>
                @foreach($monthlyStats as $month => $total)
                    <tr>
                        <td>{{ \Carbon\Carbon::create(null, $month, 1)->format('F') }}</td>
                        <td>{{ $total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay datos mensuales aún.</p>
    @endif
</div>
@endsection