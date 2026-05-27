<?php include __DIR__ . '/../../includes/layout_start.php'; ?>

<h2>Crear Dependencia</h2>

<form
    action="<?= route('dependencias.store') ?>"
    method="POST"
>

    <div class="mb-3">

        <label class="form-label">
            Nombre oficial
        </label>

        <input
            type="text"
            name="nombre_oficial"
            class="form-control"
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
        >

    </div>

    <button
        type="submit"
        class="btn btn-success"
    >
        Guardar
    </button>

</form>

<?php include __DIR__ . '/../../includes/layout_end.php'; ?>