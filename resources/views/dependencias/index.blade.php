@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <!-- IZQUIERDA -->
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('dependencias.create') }}" 
           class="btn btn-success">
            Nueva Dependencia
        </a>
    </div>
</div>

<table class="table table-bordered table-hover">
    <tr>
        <th>ID</th>
        <th>Nombre Oficial</th>
        <th>Nombre Corto</th>
        <th>Acciones</th>
    </tr>

    @foreach($dependencias as $dependencia)
        <tr>
            <td>{{ $dependencia->id }}</td>
            <td>{{ $dependencia->nombre_oficial }}</td>
            <td>{{ $dependencia->nombre_corto }}</td>
            <td class="text-center">
                <div class="d-inline-flex justify-content-center align-items-center gap-2">
                    <a href="{{ route('dependencias.edit', $dependencia) }}"
                    class="btn btn-outline-warning">
                        Editar
                    </a>
                    <button
                        type="button"
                        class="btn btn-outline-danger"
                        onclick="eliminarDependencia({{ $dependencia->id }})"
                    >
                        Eliminar
                    </button>

                    <form
                        id="delete-form-{{ $dependencia->id }}"
                        action="{{ route('dependencias.destroy', $dependencia->id) }}"
                        method="POST"
                        style="display: none;"
                    >
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </td>
        </tr>
    @endforeach
</table>

<script src="{{ asset(config('rutas.js_especificos') . 'dependencias/dependencias_index.js') }}"></script>

@endsection