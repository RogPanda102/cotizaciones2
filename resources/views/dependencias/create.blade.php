@extends('layouts.app')
@section('content')

<form action="{{ route('dependencias.store') }}" method="POST">
    @csrf
    <label>Nombre oficial:</label>
    <input type="text" name="nombre_oficial">
    <label>Nombre corto:</label>
    <input type="text" name="nombre_corto">
    <button type="submit">
        Guardar
    </button>
</form>
@endsection