@extends('layouts.app')

@section('title','Mis recolecciones')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Mis recolecciones</h1>
    <div>
        <a href="{{ route('collections.create') }}" class="btn btn-success">Programar nueva</a>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">Ver reporte</a>
    </div>
</div>

@if($collections->count())
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Residuo</th>
                <th>Peso estimado (kg)</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($collections as $c)
            <tr>
                <td>{{ \Carbon\Carbon::parse($c->collection_date)->format('Y-m-d') }}</td>
                <td>{{ \Carbon\Carbon::parse($c->collection_time)->format('H:i') }}</td>
                <td>{{ ucfirst($c->waste_type) }}</td>
                <td>{{ $c->estimated_weight }}</td>
                <td>{{ ucfirst($c->status) }}</td>
                <td>
                    <a href="{{ route('collections.edit', $c->id) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('collections.destroy', $c->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <p>No tienes recolecciones registradas.</p>
@endif
@endsection
