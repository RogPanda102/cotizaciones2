<div class="card">
    <div class="card-body">

        <h6 class="mb-3">Resumen financiero</h6>

        <div class="row mb-3">

            <div class="col-md-6">
                <p class="mb-2">
                    <strong>Monto aprobado:</strong><br>
                    ${{ number_format($pedido->monto_total_aprobado, 2) }}
                </p>
            </div>

            <div class="col-md-6">
                <p class="mb-2">
                    <strong>Total gastado:</strong><br>
                    ${{ number_format($pedido->costo_real, 2) }}
                </p>
            </div>

        </div>

        <hr>

        <h6 class="mb-3">Resultado</h6>

        @php $res = $pedido->resultado_formateado; @endphp

        <span class="badge bg-{{ $res['color'] }}">
            {{ $res['texto'] }}
        </span>

    </div>
</div>