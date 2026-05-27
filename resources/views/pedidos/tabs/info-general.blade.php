<div class="row">

    <!-- IDENTIFICACIÓN -->
    <div class="col-md-6 mb-3">
        <div class="card h-100">
            <div class="card-header">
                Identificación
            </div>

            <div class="card-body">

                <p>
                    <strong>Cotización:</strong><br>
                    {{ $pedido->cotizacion->folio_externo ?? '—' }}
                </p>

                <p>
                    <strong>Dependencia:</strong><br>
                    {{ $pedido->dependencia->nombre_oficial ?? '—' }}
                </p>

            </div>
        </div>
    </div>

    <!-- OPERACIÓN -->
    <div class="col-md-6 mb-3">
        <div class="card h-100">
            <div class="card-header">
                Operación
            </div>

            <div class="card-body">

                <p>
                    <strong>Tipo de días:</strong><br>
                    {{ ucfirst($pedido->tipo_dias) }}
                </p>

                <p class="mb-0">
                    <strong>Días de entrega:</strong><br>
                    {{ $pedido->dias_entrega ?? '—' }}
                </p>

            </div>
        </div>
    </div>

    <!-- CONDICIONES -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Condiciones
            </div>

            <div class="card-body">

                <p class="mb-0">
                    <strong>Días de crédito:</strong><br>
                    {{ $pedido->dias_credito ?? '—' }}
                </p>

            </div>
        </div>
    </div>

</div>