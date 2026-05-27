<h4>Compras relacionadas</h4>

<table class="table table-bordered">

<tr>
<th>Fecha</th>
<th>Monto</th>
<th>Cantidad</th>
<th>Unidad</th>
<th>Proveedor</th>
<th>Descripción</th>
<th>Acciones</th>
</tr>

@foreach($pedido->compras as $compra)

<tr>

<td>{{ $compra->fecha?->format('d/m/Y') }}</td>

<td>${{ number_format($compra->monto, 2) }}</td>

<td>{{ $compra->cantidad }}</td>

<td>{{ $compra->unidad }}</td>

<td>{{ $compra->proveedor->empresa }}</td>

<td>{{ $compra->descripcion }}</td>

<td>

@if($pedido->puedeEditarCompras())

<a class="btn btn-warning btn-sm" href="{{ route('compras.edit', $compra->id) }}" 
onclick="event.preventDefault(); editarCompra('{{ route('compras.edit', $compra->id) }}')">
Editar
</a>

<form id="delete-form-{{ $compra->id }}"
    action="{{ route('compras.destroy', $compra->id) }}"
    method="POST" style="display:inline;">
    @csrf
    @method('DELETE')

    <button type="button"
        class="btn btn-danger btn-sm"
        onclick="eliminarCompra({{ $compra->id }})">
        Eliminar
    </button>
</form>

@endif

</td>

</tr>

@endforeach

</table>

<div class="mt-3 text-end">

<strong>
Total gastado:

${{ number_format($pedido->totalGastado(), 2) }}

</strong>

</div>

@if(!$pedido->puedeEditarCompras())
    <div class="alert alert-warning">
        Las compras están bloqueadas porque el pedido ya fue facturado o posterior.
    </div>
@endif

<hr>
@if($pedido->puedeEditarCompras())
<h5>Agregar compra</h5>

    <form action="{{ route('compras.store') }}" method="POST">

        @csrf

        <input type="hidden" name="pedido_id" value="{{ $pedido->id }}">

        <div>

            <label>Fecha</label>
            <input type="date" name="fecha" class="form-control" required>

        </div>

        <div>

            <label>Cantidad</label>
            <input type="number" name="cantidad" min="1" class="form-control" required>

        </div>

        <div>

            <label>Unidad</label>
            <input type="text" name="unidad" class="form-control" required>

        </div>

        <div class="mb-3">

            <label>Descripción</label>

            <input type="text" name="descripcion" class="form-control" required>

        </div>

        <div class="mb-3">

            <label>Monto</label>

            <input type="number" step="0.01" name="monto" class="form-control" required>

        </div>

        <div class="mb-3">

            <label>Proveedor</label>

            <select name="proveedor_id" id="" class="form-control" required>
                <option value="">Seleccione proveedor</option>
                @foreach($proveedores as $proveedor)
                    <option value="{{ $proveedor->id }}">
                        {{ $proveedor->empresa }}
                    </option>
                @endforeach
            </select>

        </div>

        <button class="btn btn-primary">
            Guardar compra
        </button>

    </form>
@endif

        <!-- ESTE SCRIPT ES DE LOS JS ESPECIFICOS, NOTIFICACIONES -->
<script src="{{ asset('js/especificos/notificaciones_alertas.js') }}"></script> 
        <!-- ESTE SCRIPT ES DE LOS JS ESPECIFICOS, NOTIFICACIONES -->
        <script src="{{ asset(config('rutas.js_especificos') . 'pedidos/tabs/pedidos_compras.js') }}"></script>
