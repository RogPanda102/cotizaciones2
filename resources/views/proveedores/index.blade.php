@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <!-- IZQUIERDA -->
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('proveedores.create') }}" 
           class="btn btn-success">
            Nuevo Proveedor
        </a>
    </div>
</div>

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Empresa</th>
            <th>Nombre del Contacto</th>
            <th>Teléfono</th>
            <th>Email</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($proveedores as $proveedor)
            <tr>
                <td>{{ $proveedor->empresa }}</td>
                <td>{{ $proveedor->nombre_contacto }}</td>
                <td>{{ $proveedor->telefono }}</td>
                <td>{{ $proveedor->email }}</td>
                <td class="text-center">
                    <div class="d-inline-flex justify-content-center align-items-center gap-2">
                        <a href="{{ route('proveedores.edit', $proveedor) }}"
                        class="btn btn-outline-warning">
                            Editar
                        </a>
                        <button
                        type="button"
                        class="btn btn-outline-danger"
                        onclick="eliminarProveedor({{ $proveedor->id }})"
                        >
                        Eliminar
                        </button>
                        <form
                            id="delete-form-{{ $proveedor->id }}"
                            action="{{ route('proveedores.destroy', $proveedor->id) }}"
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
    </tbody>
</table>
<script src="{{ asset(config('rutas.js_especificos') . 'proveedores/proveedores_index.js') }}"></script>
@endsection