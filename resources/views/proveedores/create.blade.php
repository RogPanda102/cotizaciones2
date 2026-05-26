@extends('layouts.app')

@section('content')

<form method="POST" action="{{ route('proveedores.store') }}">
    @csrf

    <input type="text" name="empresa" placeholder="Empresa" required>

    <input type="text" name="nombre_contacto" placeholder="Nombre del Contacto">

    <input type="text" name="telefono" placeholder="Teléfono">

    <input type="email" name="email" placeholder="Email">

    <button type="submit">Guardar</button>
</form>
@endsection