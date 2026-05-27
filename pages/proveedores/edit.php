<?php include __DIR__ . '/../../includes/layout_start.php'; ?>
<?php /** @var object $proveedor */ ?>

<h2>Editar Proveedor</h2>

<form
    action="<?= route('proveedores.update') ?>"
    method="POST"
>

    <input
        type="hidden"
        name="id"
        value="<?= $proveedor->id ?>"
    >

    <div class="mb-3">

        <label class="form-label">
            Nombre de Empresa
        </label>

        <input
            type="text"
            name="empresa"
            class="form-control"
            value="<?= $proveedor->empresa ?>"
        >

    </div>

    <div class="mb-3">

        <label class="form-label">
            Nombre de contacto
        </label>

        <input
            type="text"
            name="nombre_contacto"
            class="form-control"
            value="<?= $proveedor->nombre_contacto ?>"
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
            value="<?= $proveedor->telefono ?>"
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
            value="<?= $proveedor->email ?>"
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