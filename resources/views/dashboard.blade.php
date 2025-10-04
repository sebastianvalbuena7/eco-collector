@extends('layouts.app')

@section('title','Dashboard')

@section('content')
<h1>Dashboard</h1>
<p>Bienvenido {{ auth()->user()->name ?? 'Usuario' }}</p>
<p><a href="{{ route('collections.index') }}" class="btn btn-primary">Mis recolecciones</a></p>
@endsection