<?php include __DIR__ . '/../../includes/layout_start.php'; ?>

<h2>Crear Proveedor</h2>

<form
    action="<?= route('proveedores.store') ?>"
    method="POST"
>

    <div class="mb-3">

        <label class="form-label">
            Nombre de la empresa
        </label>

        <input
            type="text"
            name="empresa"
            class="form-control"
        >

    </div>

    <div class="mb-3">

        <label class="form-label">
            Nombre del contacto
        </label>

        <input
            type="text"
            name="nombre_contacto"
            class="form-control"
        >

    </div>

    <div class="mb-3">

        <label class="form-label">
            Teléfono
        </label>

        <input
            type="text"
            name="telefono"
            class="form-control"
        >

    </div>

    <div class="mb-3">

        <label class="form-label">
            Email
        </label>

        <input
            type="email"
            name="email"
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