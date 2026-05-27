<?php include __DIR__ . '/../../includes/layout_start.php'; ?>
<?php /** @var object $dependencia */ ?>

<h2>Editar Dependencia</h2>

<form
    action="<?= route('dependencias.update') ?>"
    method="POST"
>

    <input
        type="hidden"
        name="id"
        value="<?= $dependencia->id ?>"
    >

    <div class="mb-3">

        <label class="form-label">
            Nombre oficial
        </label>

        <input
            type="text"
            name="nombre_oficial"
            class="form-control"
            value="<?= $dependencia->nombre_oficial ?>"
        >

    </div>

    <div class="mb-3">

        <label class="form-label">
            Nombre corto
        </label>

        <input
            type="text"
            name="nombre_corto"
            class="form-control"
            value="<?= $dependencia->nombre_corto ?>"
        >

    </div>

    <button
        type="submit"
        class="btn btn-primary"
    >
        Actualizar
    </button>

</form>

<?php include __DIR__ . '/../../includes/layout_end.php'; ?>