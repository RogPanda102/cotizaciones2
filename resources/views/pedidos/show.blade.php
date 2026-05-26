@extends('layouts.app')

@section('content')

<div class="container">

<div class="row">

    <div class="col-md-8">

        <h2>Pedido #{{ $pedido->id }}</h2>

        <div class="card mb-3">

            <div class="card-body">

                <p>
                <strong>Dependencia:</strong>
                    {{ $pedido->dependencia->nombre_oficial }}
                </p>

                <p>
                    <strong>Estado:</strong>
                    <span class="badge bg-{{ $pedido->estado->badge() }}">
                        {{ $pedido->estado->label() }}
                    </span>
                </p>

                <p>
                    <strong>Fecha entrega:</strong>
                    {{ $pedido->fecha_entrega?->format('d/m/Y') ?? '—' }}
                </p>

            </div>

        </div>
    </div>

    <div class="col-md-4">

        <div class="card">

            <div class="card-header">
                Historial de estados
            </div>

            <div class="card-body">

                <table class="table table-sm table-striped">

                    <thead>
                        <tr>
                        <th>Estado</th>
                        <th>Fecha</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($pedido->historialEstados as $estado)

                            <tr>

                                <td>
                                    <span class="badge bg-{{ $estado->estado->badge() }}">
                                        {{ $estado->estado->label() }}
                                    </span>
                                </td>

                                <td>
                                    {{ $estado->created_at->format('d/m/Y') }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<div class="row mt-4">

    <div class="col-12">

        <ul class="nav nav-tabs" id="pedidoTabs" role="tablist">

            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button">
                Info general
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link" id="contacto-tab" data-bs-toggle="tab" data-bs-target="#contacto" type="button">
                    Contacto
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link" id="finanzas-tab" data-bs-toggle="tab" data-bs-target="#finanzas" type="button">
                Finanzas
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link" id="plazos-tab" data-bs-toggle="tab" data-bs-target="#plazos" type="button">
                Plazos
                </button>
            </li>

            @if(in_array($pedido->tipo, ['servicio', 'licencia']))
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="detalles-tab" data-bs-toggle="tab" data-bs-target="#detalles" type="button">
                        Detalles
                    </button>
                </li>
            @endif

            @if($pedido->tipo === 'mercadeo')
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="compras-tab" data-bs-toggle="tab" data-bs-target="#compras" type="button">
                    Compras
                    </button>
                </li>
            @endif

            <li class="nav-item" role="presentation">
                <button class="nav-link" id="acciones-tab" data-bs-toggle="tab" data-bs-target="#acciones" type="button">
                Acciones
                </button>
            </li>

        </ul>


        <div class="tab-content mt-4" id="pedidoTabsContent">

            <div class="tab-pane fade show active" id="info" role="tabpanel">
            @include('pedidos.tabs.info-general')
            </div>

            <div class="tab-pane fade" id="contacto" role="tabpanel">
                @include('pedidos.tabs.contacto')
            </div>

            <div class="tab-pane fade" id="finanzas" role="tabpanel">
            @include('pedidos.tabs.finanzas')
            </div>

            <div class="tab-pane fade" id="plazos" role="tabpanel">
            @include('pedidos.tabs.plazos')
            </div>

            @if(in_array($pedido->tipo, ['servicio', 'licencia']))
                <div class="tab-pane fade" id="detalles" role="tabpanel">
                    @include('pedidos.tabs.detalles')
                </div>
            @endif

            @if($pedido->tipo === 'mercadeo')
                <div class="tab-pane fade" id="compras" role="tabpanel">
                    @include('pedidos.tabs.compras')
                </div>
            @endif

            <div class="tab-pane fade" id="acciones" role="tabpanel">
            @include('pedidos.tabs.acciones')
            </div>

        </div>

    </div>

</div>

@endsection