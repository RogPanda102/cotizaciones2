@if($pedido->estado->esFinal())

    <div class="alert alert-warning">
    Este pedido ya fue pagado y no puede modificarse.
    </div>

@else
    <h4>Cambiar estado</h4>
    <form id="update-form-{{ $pedido->id }}" action="{{ route('pedidos.update', $pedido->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Estado</label>
            <select name="estado" id="estadoSelect" class="form-control">
                <option value="{{ $pedido->estado->value }}" selected>
                    {{ $pedido->estado->label() }}
                </option>
                @foreach($pedido->estado->siguientesEstados() as $estado)
                    <option value="{{ $estado->value }}">
                    {{ $estado->label() }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3" id="fechaFacturacionGroup" style="display:none;">
            <label>Fecha facturación</label>
            <input type="date"
            name="fecha_facturacion"
            class="form-control"
            value="{{ old('fecha_facturacion', $pedido->fecha_facturacion) }}">
        </div>
        <button type="button" class="btn btn-primary" onclick="confirmUpdate({{ $pedido->id }})">
            Actualizar
        </button>
    </form>
    <script src="{{ asset(config('rutas.js_especificos') . 'pedidos/tabs/pedidos_acciones.js') }}"></script>
@endif
