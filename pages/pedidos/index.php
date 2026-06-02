<?php include __DIR__ . '/../../includes/layout_start.php'; ?>
<?php /** @var array $pedidos */ ?>
<?php /** @var object $empresa */ ?>

<div class="d-flex justify-content-between align-items-center mb-3">

    <div class="d-flex align-items-center gap-3">

        <a
            href="<?= route('pedidos.create') ?>?empresa_id=<?= $empresa->id ?>"
            class="btn btn-success"
        >
            Crear Pedido
        </a>

        <div>

            <strong>Total de pedidos:</strong>

            <?= count($pedidos) ?>

        </div>

    </div>

</div>

<table class="table table-bordered table-hover">

    <tr>

        <th>Cotización</th>

        <th>Dependencia</th>

        <th>Monto</th>

        <th>Estado</th>

        <th>Acciones</th>

    </tr>

    <?php foreach($pedidos as $pedido): ?>

        <?php

            $clase = '';

            if($pedido->estado === 'pagado') {

                $clase = 'table-success';

            }

        ?>

        <tr class="<?= $clase ?>">

            <td>

                <?= $pedido->folio_externo ?>

            </td>

            <td>

                <?= $pedido->nombre_oficial ?>

            </td>

            <td>

                $<?= number_format($pedido->monto_total_aprobado, 2) ?>

            </td>

            <td>

                <span class="badge bg-secondary">

                    <?= ucfirst($pedido->estado) ?>

                </span>

            </td>

            <td>

                <a
                    href="<?= route('pedidos.show') ?>?id=<?= $pedido->id ?>"
                    class="btn btn-sm btn-primary"
                >
                    Ver
                </a>

                <a
                    href="<?= route('pedidos.edit') ?>?id=<?= $pedido->id ?>"
                    class="btn btn-sm btn-warning"
                >
                    Editar
                </a>

            </td>

        </tr>

    <?php endforeach; ?>

</table>

<script src="<?= asset(config('rutas.js_especificos') . 'pedidos/pedidos_index.js') ?>"></script>

<?php include __DIR__ . '/../../includes/layout_end.php'; ?>