@switch($pedido->tipo)

    @case('servicio')
        @include('pedidos.tabs.detalles.servicio')
        @break

    @case('licencia')
        @include('pedidos.tabs.detalles.licencia')
        @break

@endswitch