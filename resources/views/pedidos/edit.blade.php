@extends('layouts.app')

@section('content')

<div class="container">
    <h2>Editar Pedido</h2>

    @if($pedido->estado->esFinal())
        <div class="alert alert-warning">
            <p class="text-danger mb-0">
                ⚠️ Este pedido ya está pagado y no puede modificarse.
            </p>
        </div>
    @endif

    <form action="{{ route('pedidos.update', $pedido->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Estado --}}
        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select name="estado" class="form-control">
                <option value="{{ $pedido->estado->value }}" selected>
                    {{ $pedido->estado->label() }}
                </option>

                @foreach($pedido->estado->siguientesEstados() as $estado)
                    <option value="{{ $estado->value }}">
                        {{ $estado->label() }}
                    </option>
                @endforeach
            </select>

            @error('estado')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        {{-- Fecha Facturación --}}
        <div class="mb-3">
            @if($pedido->estado === App\Enums\EstadoPedido::FACTURADO)
            <label for="fecha_facturacion" class="form-label">
                Fecha de facturación
            </label>

                <input type="date" name="fecha_facturacion"
                    value="{{ old('fecha_facturacion', $pedido->fecha_facturacion) }}">
            @endif

            @error('fecha_facturacion')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary"
            {{ $pedido->estado === App\Enums\EstadoPedido::PAGADO ? 'disabled' : '' }}>
            Actualizar Pedido
        </button>

        <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">
            Cancelar
        </a>
    </form>
</div>
@endsection