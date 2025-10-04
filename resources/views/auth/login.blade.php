@extends('layouts.app')

@section('title','Iniciar sesión')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h2>Iniciar sesión</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Correo</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input id="password" type="password" class="form-control" name="password" required>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="remember" id="remember">
                <label class="form-check-label" for="remember">Recordarme</label>
            </div>

            <button type="submit" class="btn btn-primary">Entrar</button>
        </form>
    </div>
</div>
@endsection
