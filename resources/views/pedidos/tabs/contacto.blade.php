<div class="row">

    <!-- DEPARTAMENTO -->
    <div class="col-md-6 mb-3">
        <div class="card h-100">
            <div class="card-header">
                Departamento 
            </div>

            <div class="card-body">

                <p>
                    <strong>Nombre del departamento:</strong><br>
                    {{ $pedido->departamento->nombre_departamento ?? '—' }}
                </p>

                <p>
                    <strong>Nombre de contacto:</strong><br>
                    {{ $pedido->departamento->responsable ?? '—' }}
                </p>

                <p>
                    <strong>Teléfono:</strong><br>
                    {{ $pedido->departamento->telefono ?? '—' }}
                </p>

                <p>
                    <strong>Email:</strong><br>
                    {{ $pedido->departamento->email ?? '—' }}
                </p>

                <p class="mb-0">
                    <strong>Dirección:</strong><br>
                    {{ $pedido->departamento->direccion ?? '—' }}
                </p>

            </div>
        </div>
    </div>

    <!-- PROVEEDOR -->
    <div class="col-md-6 mb-3">
        <div class="card h-100">
            <div class="card-header">
                Proveedor
            </div>

            <div class="card-body">

                <p>
                    <strong>Nombre de empresa:</strong><br>
                    {{ $pedido->proveedor->empresa ?? '—' }}
                </p>

                <p>
                    <strong>Nombre de contacto:</strong><br>
                    {{ $pedido->proveedor->nombre_contacto ?? '—' }}
                </p>

                <p>
                    <strong>Email:</strong><br>
                    {{ $pedido->proveedor->email ?? '—' }}
                </p>

                <p>
                    <strong>Teléfono:</strong><br>
                    {{ $pedido->proveedor->telefono ?? '—' }}
                </p>
                <!-- agrega más campos si tienes -->
                <!-- teléfono, contacto, etc. -->

            </div>
        </div>
    </div>

</div>