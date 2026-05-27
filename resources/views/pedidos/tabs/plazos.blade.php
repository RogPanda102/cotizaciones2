<div class="card">
    <div class="card-body">

        <!-- FECHAS -->
        <h6 class="mb-3">Fechas</h6>

        <div class="row">

            <div class="col-md-6">
                <p class="mb-2">
                    <strong>Adjudicación:</strong><br>
                    {{ $pedido->fecha_adjudicacion?->format('d/m/Y') ?? '—' }}
                </p>

                <p class="mb-2">
                    <strong>Entrega:</strong><br>
                    {{ $pedido->fecha_entrega?->format('d/m/Y') ?? '—' }}
                </p>
            </div>

            <div class="col-md-6">
                <p class="mb-2">
                    <strong>Facturación:</strong><br>
                    @if($pedido->fecha_facturacion)
                        {{ $pedido->fecha_facturacion->format('d/m/Y') }}
                    @else
                        <span class="text-muted">Sin registrar</span>
                    @endif
                </p>

                <p class="mb-2">
                    <strong>Pago:</strong><br>
                    @if($pedido->fecha_pago)
                        {{ $pedido->fecha_pago->format('d/m/Y') }}
                    @else
                        <span class="text-muted">No pagado</span>
                    @endif
                </p>
            </div>

        </div>

        <hr>

        <!-- ESTADO DE TIEMPO -->
        <h6 class="mb-3">Estado de tiempo</h6>

        @if($pedido->estado->esFinal())

            <p class="mb-2">
                <strong>Pagado el:</strong>
                {{ $pedido->fecha_pago?->format('d/m/Y') }}
            </p>

            @if($pedido->dias_retraso > 0)
                <span class="badge bg-danger">
                    {{ $pedido->dias_retraso }} días de retraso
                </span>
            @else
                <span class="badge bg-success">
                    Sin retraso
                </span>
            @endif

        @else

            @if($pedido->tipo === 'licencia')

                @if($pedido->estado_licencia === 'vencido')

                    <span class="badge bg-danger">
                        Vencido hace {{ abs($pedido->dias_restantes_licencia) }} días
                    </span>

                @else

                    <span class="badge bg-success">
                        {{ $pedido->dias_restantes_licencia }} días restantes
                    </span>

                @endif

            @else

                @if($pedido->dias_restantes_entrega < 0)

                    <span class="badge bg-danger">
                        Atrasado {{ abs($pedido->dias_restantes_entrega) }} días
                    </span>

                @else

                    <span class="badge bg-success">
                        {{ $pedido->dias_restantes_entrega }} días restantes para la entrega
                    </span>

                @endif

            @endif

        @endif

    </div>
</div>