<?php include __DIR__ . '/../../includes/layout_start.php'; ?>
<?php /** @var array $proveedores */ ?>
<div class="d-flex justify-content-between align-items-center mb-3">

    <div class="d-flex align-items-center gap-3">

        <a
            href="<?= route('proveedores.create') ?>"
            class="btn btn-success"
        >
            Nuevo Proveedor
        </a>

    </div>

</div>

<table class="table table-bordered table-hover">

    <thead>

        <tr>
            <th>Empresa</th>
            <th>Contacto</th>
            <th>Teléfono</th>
            <th>Email</th>
            <th>Acciones</th>
        </tr>

    </thead>

    <tbody>

        <?php foreach($proveedores as $proveedor): ?>

            <tr>

                <td>
                    <?= $proveedor->empresa ?>
                </td>

                <td>
                    <?= $proveedor->nombre_contacto ?>
                </td>

                <td>
                    <?= $proveedor->telefono ?>
                </td>

                <td>
                    <?= $proveedor->email ?>
                </td>

                <td class="text-center">

                    <div class="d-inline-flex gap-2">

                        <a
                            href="<?= route('proveedores.edit') ?>?id=<?= $proveedor->id ?>"
                            class="btn btn-outline-warning"
                        >
                            Editar
                        </a>

                        <button
                            type="button"
                            class="btn btn-outline-danger"
                            onclick="eliminarProveedor(<?= $proveedor->id ?>)"
                        >
                            Eliminar
                        </button>

                        <form
                            id="delete-form-<?= $proveedor->id ?>"
                            action="<?= route('proveedores.delete') ?>?id=<?= $proveedor->id ?>"
                            method="POST"
                            style="display: none;"
                        >
                        <input
                            type="hidden"
                            name="id"
                            value="<?= $proveedor->id ?>"
                        >
                        </form>

                    </div>

                </td>

            </tr>

        <?php endforeach; ?>

    </tbody>

</table>
<script src="<?= asset('assets/js/especificos/proveedores/proveedores_index.js') ?>"></script>
<?php include __DIR__ . '/../../includes/layout_end.php'; ?>