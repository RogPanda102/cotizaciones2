@extends('layouts.app')

@section('content')

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('proveedores.update', $proveedor) }}">
        @csrf
        @method('PUT')

        <input
            type="text"
            name="empresa"
            placeholder="Empresa"
            value="{{ old('empresa', $proveedor->empresa) }}"
            required>

        <input
            type="text"
            name="nombre_contacto"
            placeholder="Nombre del Contacto"
            value="{{ old('nombre_contacto', $proveedor->nombre_contacto) }}">

        <input
            type="text"
            name="telefono"
            placeholder="Teléfono"
            value="{{ old('telefono', $proveedor->telefono) }}">

        <input
            type="email"
            name="email"
            placeholder="Email"
            value="{{ old('email', $proveedor->email) }}">

        <button type="submit">Actualizar</button>
    </form>
@endsection

