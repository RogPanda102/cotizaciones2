<?php include __DIR__ . '/../../includes/layout_start.php'; ?>
<?php /** @var array $cotizaciones */ ?>
<div class="d-flex justify-content-between align-items-center mb-3">

    <!-- IZQUIERDA -->
    <div class="d-flex align-items-center gap-3">

        <a href="<?= route('cotizaciones.create') ?>"
           class="btn btn-success">

            Nueva Cotización

        </a>

    </div>

</div>

<div x-data="{ openId: null }">

    <table class="table table-bordered table-hover">

        <thead>
            <tr>
                <th>ID</th>
                <th>Empresa</th>
                <th>Tipo</th>
                <th>Estado</th>
                <th>Monto</th>
                <th>Fecha envío</th>
                <th></th>
            </tr>
        </thead>

        <tbody>

            <?php foreach($cotizaciones as $cotizacion): ?>

                <tr class="align-middle">

                    <td><?= $cotizacion->folio_externo ?></td>

                    <td>
                        <?= $cotizacion->empresa_nombre ?? '-' ?>
                    </td>

                    <td>

                        <span class="badge bg-info">

                            <?= ucfirst(str_replace('_', ' ', $cotizacion->tipo_cotizacion)) ?>

                        </span>

                    </td>

                    <td>

                        <span class="badge bg-secondary">

                            <?= $cotizacion->estado ?? '-' ?>

                        </span>

                    </td>

                    <td>

                        <?= $cotizacion->monto_total
                            ? '$' . number_format($cotizacion->monto_total, 2)
                            : '-' ?>

                    </td>

                    <td>

                        <?= !empty($cotizacion->fecha_envio)
                            ? date('d/m/Y', strtotime($cotizacion->fecha_envio))
                            : '-' ?>

                    </td>

                    <td class="text-center">

                        <div class="d-inline-flex justify-content-center align-items-center gap-2">

                            <!-- BOTÓN VER -->
                            <button
                                @click="openId = openId === <?= $cotizacion->id ?> ? null : <?= $cotizacion->id ?>"
                                class="btn btn-sm btn-outline-primary"
                            >

                                <span
                                    x-text="openId === <?= $cotizacion->id ?> ? 'Ocultar' : 'Ver'">
                                </span>

                            </button>

                            <!-- BOTÓN EDITAR -->
                            <a href="<?= route('cotizaciones.edit') ?>?id=<?= $cotizacion->id ?>"
                               class="btn btn-sm btn-outline-warning">

                                Editar

                            </a>

                            <!-- BOTÓN ELIMINAR -->
                            <button
                                type="button"
                                class="btn btn-sm btn-outline-danger"
                                onclick="eliminarCotizacion(<?= $cotizacion->id ?>)"
                            >
                                Eliminar
                            </button>

                            <!-- FORM OCULTO -->
                            <form
                                id="delete-form-<?= $cotizacion->id ?>"
                                action="<?= route('cotizaciones.delete') ?>?id=<?= $cotizacion->id ?>"
                                method="POST"
                                style="display:none;"
                            ></form>

                        </div>

                    </td>

                </tr>

                <!-- FILA EXPANDIBLE -->
                <tr
                    x-show="openId === <?= $cotizacion->id ?>"
                    x-transition.opacity
                    x-cloak
                >

                    <td colspan="7">

                        <div class="p-3 bg-light rounded">

                            <div class="row">

                                <!-- GENERAL -->
                                <div class="col-md-4 mb-3">

                                    <div class="card shadow-sm">

                                        <div class="card-header fw-bold">

                                            Información general

                                        </div>

                                        <div class="card-body">

                                            <p>
                                                <strong>Dependencia:</strong>

                                                <?= $cotizacion->dependencia_nombre ?? '-' ?>
                                            </p>

                                            <p>
                                                <strong>Departamento:</strong>

                                                <?= $cotizacion->departamento_nombre ?? '-' ?>
                                            </p>

                                            <p>
                                                <strong>Analista:</strong>

                                                <?= $cotizacion->analista_nombre ?? '-' ?>
                                            </p>

                                        </div>

                                    </div>

                                </div>

                                <!-- FECHAS -->
                                <div class="col-md-4 mb-3">

                                    <div class="card shadow-sm">

                                        <div class="card-header fw-bold">

                                            Fechas

                                        </div>

                                        <div class="card-body">

                                            <p>

                                                <strong>Envío:</strong>

                                                <?= !empty($cotizacion->fecha_envio)
                                                    ? date('d/m/Y', strtotime($cotizacion->fecha_envio))
                                                    : '-' ?>

                                            </p>

                                            <p>

                                                <strong>Recepción:</strong>

                                                <?= !empty($cotizacion->fecha_recepcion)
                                                    ? date('d/m/Y', strtotime($cotizacion->fecha_recepcion))
                                                    : '-' ?>

                                            </p>

                                        </div>

                                    </div>

                                </div>

                                <!-- FINANCIEROS -->
                                <?php if($cotizacion->tipo_cotizacion === 'omg'): ?>

                                    <div class="col-md-4 mb-3">

                                        <div class="card shadow-sm">

                                            <div class="card-header fw-bold">

                                                Financieros

                                            </div>

                                            <div class="card-body">

                                                <p>

                                                    <strong>Monto:</strong>

                                                    <?= $cotizacion->monto_total
                                                        ? '$' . number_format($cotizacion->monto_total, 2)
                                                        : '-' ?>

                                                </p>

                                                <p>

                                                    <strong>Días crédito:</strong>

                                                    <?= $cotizacion->dias_credito ?? '-' ?>

                                                </p>

                                                <p>

                                                    <strong>Tipo días:</strong>

                                                    <?= $cotizacion->tipo_dias ?? '-' ?>

                                                </p>

                                                <p>

                                                    <strong>Garantía:</strong>

                                                    <?= $cotizacion->garantia ?? '-' ?>

                                                </p>

                                            </div>

                                        </div>

                                    </div>

                                <?php endif; ?>

                                <!-- IDENTIFICACIÓN -->
                                <div class="col-md-4 mb-3">

                                    <div class="card shadow-sm">

                                        <div class="card-header fw-bold">

                                            Identificación

                                        </div>

                                        <div class="card-body">

                                            <p>

                                                <strong>Folio externo:</strong>

                                                <?= $cotizacion->folio_externo ?? '-' ?>

                                            </p>

                                            <p>

                                                <strong>Número:</strong>

                                                <?= $cotizacion->numero_cotizacion ?? '-' ?>

                                            </p>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </td>

                </tr>

            <?php endforeach; ?>

        </tbody>

    </table>

</div>

<script src="<?= asset('public/js/especificos/cotizaciones/cotizaciones_index.js') ?>"></script>
<?php include __DIR__ . '/../../includes/layout_end.php'; ?>