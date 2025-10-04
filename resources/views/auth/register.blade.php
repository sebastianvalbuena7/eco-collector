@extends('layouts.app')

@section('title','Registro')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h2>Crear cuenta</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/register') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Correo</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button class="btn btn-success">Registrarse</button>
        </form>
    </div>
</div>
@endsection
