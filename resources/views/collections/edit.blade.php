@extends('layouts.app')

@section('title','Editar recolección')

@section('content')
<div class="container">
    <h1>Editar recolección</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('collections.update', $collection->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Fecha</label>
            <input type="date" name="collection_date" value="{{ old('collection_date', $collection->collection_date) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Hora</label>
            <input type="time" name="collection_time" value="{{ old('collection_time', $collection->collection_time) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tipo de residuo</label>
            <select name="waste_type" class="form-control" required>
                <option value="organic"   {{ old('waste_type', $collection->waste_type)=='organic' ? 'selected' : '' }}>Orgánico</option>
                <option value="recyclable"{{ old('waste_type', $collection->waste_type)=='recyclable' ? 'selected' : '' }}>Reciclable</option>
                <option value="hazardous" {{ old('waste_type', $collection->waste_type)=='hazardous' ? 'selected' : '' }}>Peligroso</option>
                <option value="electronic"{{ old('waste_type', $collection->waste_type)=='electronic' ? 'selected' : '' }}>Electrónico</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Peso estimado (kg)</label>
            <input type="number" step="0.01" min="0" name="estimated_weight" value="{{ old('estimated_weight', $collection->estimated_weight) }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Peso real (kg)</label>
            <input type="number" step="0.01" min="0" name="actual_weight" value="{{ old('actual_weight', $collection->actual_weight) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Dirección</label>
            <textarea name="address" class="form-control" required>{{ old('address', $collection->address) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Estado</label>
            <select name="status" class="form-control" required>
                <option value="pending"     {{ $collection->status=='pending' ? 'selected' : '' }}>Pendiente</option>
                <option value="in_progress" {{ $collection->status=='in_progress' ? 'selected' : '' }}>En proceso</option>
                <option value="completed"   {{ $collection->status=='completed' ? 'selected' : '' }}>Completada</option>
                <option value="cancelled"   {{ $collection->status=='cancelled' ? 'selected' : '' }}>Cancelada</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Notas</label>
            <textarea name="notes" class="form-control">{{ old('notes', $collection->notes) }}</textarea>
        </div>

        <button class="btn btn-success">Guardar cambios</button>
        <a href="{{ route('collections.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection