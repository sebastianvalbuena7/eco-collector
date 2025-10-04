@extends('layouts.app')

@section('title','Programar recolección')

@section('content')
<div class="container">
    <h1>Programar recolección</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('collections.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Fecha</label>
            <input type="date" name="collection_date" value="{{ old('collection_date') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Hora</label>
            <input type="time" name="collection_time" value="{{ old('collection_time') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tipo de residuo</label>
            <select name="waste_type" class="form-control" required>
                <option value="">Selecciona...</option>
                <option value="organic" {{ old('waste_type')=='organic' ? 'selected' : '' }}>Orgánico</option>
                <option value="recyclable" {{ old('waste_type')=='recyclable' ? 'selected' : '' }}>Reciclable</option>
                <option value="hazardous" {{ old('waste_type')=='hazardous' ? 'selected' : '' }}>Peligroso</option>
                <option value="electronic" {{ old('waste_type')=='electronic' ? 'selected' : '' }}>Electrónico</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Peso estimado (kg)</label>
            <input type="number" step="0.01" min="0" name="estimated_weight" value="{{ old('estimated_weight') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Dirección</label>
            <textarea name="address" class="form-control" required>{{ old('address') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Notas (opcional)</label>
            <textarea name="notes" class="form-control">{{ old('notes') }}</textarea>
        </div>

        <button class="btn btn-primary">Programar</button>
        <a href="{{ route('collections.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
