<?php include __DIR__ . '/../../includes/layout_start.php'; ?>
<?php /** @var array $dependencias */ ?>
<div class="d-flex justify-content-between align-items-center mb-3">

    <div class="d-flex align-items-center gap-3">

        <a
            href="<?= route('dependencias.create') ?>"
            class="btn btn-success"
        >
            Nueva Dependencia
        </a>

    </div>

</div>

<table class="table table-bordered table-hover">

    <thead>

        <tr>
            <th>ID</th>
            <th>Nombre Oficial</th>
            <th>Nombre Corto</th>
            <th>Acciones</th>
        </tr>

    </thead>

    <tbody>

        <?php foreach($dependencias as $dependencia): ?>

            <tr>

                <td>
                    <?= $dependencia->id ?>
                </td>

                <td>
                    <?= $dependencia->nombre_oficial ?>
                </td>

                <td>
                    <?= $dependencia->nombre_corto ?>
                </td>

                <td class="text-center">

                    <div class="d-inline-flex gap-2">

                        <a
                            href="<?= route('dependencias.edit') ?>?id=<?= $dependencia->id ?>"
                            class="btn btn-outline-warning"
                        >
                            Editar
                        </a>

                        <button
                            type="button"
                            class="btn btn-outline-danger"
                            onclick="eliminarDependencia(<?= $dependencia->id ?>)"
                        >
                            Eliminar
                        </button>

                        <form
                            id="delete-form-<?= $dependencia->id ?>"
                            action="<?= route('dependencias.delete') ?>?id=<?= $dependencia->id ?>"
                            method="POST"
                            style="display: none;"
                        >
                        <input
        type="hidden"
        name="id"
        value="<?= $dependencia->id ?>"
    >
                        </form>

                    </div>

                </td>

            </tr>

        <?php endforeach; ?>

    </tbody>

</table>
<script src="<?= asset('assets/js/especificos/dependencias/dependencias_index.js') ?>"></script>
<?php include __DIR__ . '/../../includes/layout_end.php'; ?>