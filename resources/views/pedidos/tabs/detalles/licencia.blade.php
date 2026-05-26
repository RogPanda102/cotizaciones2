<div class="row">

    {{-- IDENTIDAD --}}
    <div class="col-md-6 mb-3">
        <div class="card h-100">
            <div class="card-header">
                Licencia
            </div>

            <div class="card-body">

                <p>
                    <strong>Nombre:</strong><br>
                    {{ $pedido->licencia->nombre_licencia ?? '—' }}
                </p>

                <p class="mb-0">
                    <strong>Tipo:</strong><br>
                    {{ $pedido->licencia->tipo_licencia ?? '—' }}
                </p>

            </div>
        </div>
    </div>

    {{-- USO --}}
    <div class="col-md-6 mb-3">
        <div class="card h-100">
            <div class="card-header">
                Uso
            </div>

            <div class="card-body">

                <p>
                    <strong>Número de usuarios:</strong><br>
                    {{ $pedido->licencia->numero_usuarios ?? '—' }}
                </p>

                <p class="mb-0">
                    <strong>Costo:</strong><br>
                    {{ $pedido->licencia->costo_licencia !== null 
                        ? '$' . number_format($pedido->licencia->costo_licencia, 2) 
                        : '—' }}
                </p>

            </div>
        </div>
    </div>

    {{-- VIGENCIA --}}
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Vigencia
            </div>

            <div class="card-body">

                <div class="row mb-3">

                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong>Fecha inicio:</strong><br>
                            {{ $pedido->licencia->fecha_inicio?->format('d/m/Y') ?? '—' }}
                        </p>
                    </div>

                    <div class="col-md-6">
                        <p class="mb-2">
                            <strong>Fecha fin:</strong><br>
                            {{ $pedido->licencia->fecha_fin?->format('d/m/Y') ?? '—' }}
                        </p>
                    </div>

                </div>

                {{-- 🔥 ESTADO --}}
                @if($pedido->estado_licencia === 'vencido')

                    <span class="badge bg-danger">
                        Vencido hace {{ abs($pedido->dias_restantes_licencia) }} días
                    </span>

                @else

                    <span class="badge bg-success">
                        {{ $pedido->dias_restantes_licencia }} días restantes
                    </span>

                @endif

            </div>
        </div>
    </div>

</div>