@extends('layouts.app')

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container">
    <h2>Editar Compra</h2>

    @if($compra->pedido->estado->esFinal())
        <div class="alert alert-warning">
            ⚠️ No puedes editar compras de un pedido pagado.
        </div>
    @endif

    <form action="{{ route('compras.update', $compra->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Fecha --}}
        <div class="mb-3">
            <label class="form-label">Fecha</label>
            <input type="date" name="fecha"
                value="{{ old('fecha', \Carbon\Carbon::parse($compra->fecha)->format('Y-m-d')) }}"
                class="form-control">
        </div>

        {{-- Cantidad --}}
        <div class="mb-3">
            <label class="form-label">Cantidad</label>
            <input type="number" step="0.01" name="cantidad"
                value="{{ old('cantidad', $compra->cantidad) }}"
                class="form-control">
        </div>

        {{-- Unidad --}}
        <div class="mb-3">
            <label class="form-label">Unidad</label>
            <input type="text" name="unidad"
                value="{{ old('unidad', $compra->unidad) }}"
                class="form-control">
        </div>

        {{-- Descripción --}}
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <input type="text" name="descripcion"
                value="{{ old('descripcion', $compra->descripcion) }}"
                class="form-control">
        </div>

        {{-- Monto --}}
        <div class="mb-3">
            <label class="form-label">Monto</label>
            <input type="number" step="0.01" name="monto"
                value="{{ old('monto', $compra->monto) }}"
                class="form-control">
        </div>

        {{-- Proveedor --}}
        <div class="mb-3">
            <label class="form-label">Proveedor</label>
            <select name="proveedor_id" class="form-control">
                <option value="">Seleccione proveedor</option>
                @foreach($proveedores as $proveedor)
                    <option value="{{ $proveedor->id }}"
                        {{ old('proveedor_id', $compra->proveedor_id) == $proveedor->id ? 'selected' : '' }}>
                        {{ $proveedor->empresa }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary"
            {{ $compra->pedido->estado->esFinal() ? 'disabled' : '' }}>
            Guardar cambios
        </button>

        <a href="{{ route('pedidos.show', $compra->pedido_id) }}" class="btn btn-secondary">
            Cancelar
        </a>
    </form>
</div>

@endsection