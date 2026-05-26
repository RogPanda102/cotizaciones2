@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <!-- IZQUIERDA -->
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('pedidos.create', ['empresa_id' => $empresa->id]) }}" 
           class="btn btn-success">
            Crear Pedido
        </a>
        <div>
            <strong>Total de pedidos:</strong> {{ $pedidos->total() }}
        </div>
    </div>

    <!-- DERECHA -->
    <form method="GET" class="d-flex gap-2">
        <input 
            type="text" 
            name="search" 
            class="form-control"
            placeholder="Buscar..."
            value="{{ request('search') }}"
        >
        <button type="submit" class="btn btn-primary">
            Buscar
        </button>
    </form>
</div>

<table class="table table-bordered table-hover">

    <tr>
        <th>Cotización</th>
        <th>Dependencia</th>
        <th>Monto</th>
        <th>Estado</th>
        <th>Fecha Limite</th>
        <th>Dias restantes</th>
        <th>Acciones</th>
    </tr>

    @foreach($pedidos as $pedido)

        @php

            $clase = '';

            if ($pedido->estado->esFinal()) 
            {
                $clase = 'table-success';
            } 
            elseif (!is_null($pedido->dias_restantes)) 
            {
                if ($pedido->dias_restantes < 0) 
                {
                    $clase = 'table-danger';
                } 
                elseif ($pedido->dias_restantes <= 3) 
                {
                    $clase = 'table-warning';
                }
            }
        @endphp

        <tr class="{{ $clase }}">
            <td>{{ $pedido->cotizacion->folio_externo }}</td>
            <td>{{ $pedido->dependencia->nombre_oficial }}</td>

            <td>
                ${{ number_format($pedido->monto_total_aprobado, 2) }}
                @if($pedido->resultado_tipo === 'perdida')
                    <span title="Pérdida">🔴</span>
                @elseif($pedido->resultado_tipo === 'ganancia')
                    <span title="Ganancia">🟢</span>
                @else
                    <span title="Equilibrio">⚪</span>
                @endif
            </td>
            <td>
                <span class="badge bg-{{ $pedido->estado->badge() }}">
                    {{ $pedido->estado->label() }}
                </span>
                <br>
                <span class="badge bg-secondary">
                    {{ ucfirst($pedido->tipo) }}
                </span>
            </td>

            <td>{{ $pedido->fecha_entrega?->format('d/m/Y') }}</td>
            
            <td>{{ $pedido->dias_restantes_entrega }}</td>

            
            
            
            

            <td>
                <a href="{{ route('pedidos.show', $pedido->id) }}">
                    <button class="btn btn-sm btn-primary">
                        Ver
                    </button>
                </a>
                <form 
                    id="delete-form-{{ $pedido->id }}"
                    action="{{ route('pedidos.destroy', $pedido->id) }}" 
                    method="POST"
                    style="display: inline">

                    @csrf
                    @method('DELETE')

                    <button 
                        type="button" 
                        class="btn btn-sm btn-danger"
                        onclick="confirmDelete({{ $pedido->id }})">
                        Eliminar
                    </button>
                </form>
            </td>
        </tr>
    @endforeach
</table>

<div style="margin-top: 20px;">
    {{ $pedidos->links() }}
</div>
<script src="{{ asset(config('rutas.js_especificos') . 'pedidos/pedidos_index.js') }}"></script>
@endsection