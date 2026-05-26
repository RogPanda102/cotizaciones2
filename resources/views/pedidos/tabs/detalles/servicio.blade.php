<div class="row">

    {{-- INFORMACIÓN DEL SERVICIO --}}
    <div class="col-md-6 mb-3">
        <div class="card h-100">
            <div class="card-header">
                Información del servicio
            </div>

            <div class="card-body">

                <p>
                    <strong>Descripción:</strong><br>
                    {{ $pedido->servicio->descripcion_servicio ?? '—' }}
                </p>

                <p class="mb-0">
                    <strong>Alcance:</strong><br>
                    {{ $pedido->servicio->alcance ?? '—' }}
                </p>

            </div>
        </div>
    </div>

    {{-- EJECUCIÓN --}}
    <div class="col-md-6 mb-3">
        <div class="card h-100">
            <div class="card-header">
                Ejecución
            </div>

            <div class="card-body">

                <p>
                    <strong>Responsable:</strong><br>
                    {{ $pedido->servicio->responsable ?? '—' }}
                </p>

                <p class="mb-0">
                    <strong>Entregables:</strong><br>
                    {{ $pedido->servicio->entregables ?? '—' }}
                </p>

            </div>
        </div>
    </div>

    {{-- TIEMPO --}}
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Tiempo
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong>Fecha inicio:</strong><br>
                            {{ $pedido->servicio->fecha_inicio?->format('d/m/Y') ?? '—' }}
                        </p>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong>Fecha fin:</strong><br>
                            {{ $pedido->servicio->fecha_fin?->format('d/m/Y') ?? '—' }}
                        </p>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>