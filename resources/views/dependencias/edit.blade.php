@extends('layouts.app')

@section('content')
    <h2>Editar Dependencia</h2>

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('dependencias.update', $dependencia) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nombre oficial:</label>
        <input type="text"
               name="nombre_oficial"
               value="{{ old('nombre_oficial', $dependencia->nombre_oficial) }}">

        <label>Nombre corto:</label>
        <input type="text"
               name="nombre_corto"
               value="{{ old('nombre_corto', $dependencia->nombre_corto) }}">

        <button type="submit">Actualizar</button>
    </form>
@endsection

