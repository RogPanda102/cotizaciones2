<?php include __DIR__ . '/../../includes/layout_start.php'; ?>

<?php
    /** @var array $empresas */
    /** @var array $departamentos */
    /** @var array $analistas */
    /** @var array $dependencias */
?>

 <!-- =======================================================
    ERRORES DE VALIDACIÓN
=======================================================  -->
<?php if (!empty($errors) && is_array($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?= $error ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div
    class="container"
    x-data="cotizacionForm()"
>

    <!-- =======================================================
        FORMULARIO
    ======================================================= -->
    <form
        id="formCotizacion"
        method="POST"
        action="<?= route('cotizaciones.store') ?>"
    >

        <!-- =======================================================
            INFORMACIÓN BASE
        ======================================================= -->
        <div class="card mb-3">

            <div class="card-header fw-bold">
                Información base
            </div>

            <div class="card-body row">

                <!-- EMPRESA -->
                <div class="col-md-4">
                    <label>Empresa</label>

                    <select
                        name="empresa_id"
                        class="form-control"
                        required
                    >
                        <option value="">
                            Seleccionar
                        </option>

                        <?php foreach($empresas as $empresa): ?>

                            <option value="<?= $empresa->id ?>">
                                <?= $empresa->nombre ?>
                            </option>

                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- TIPO -->
                <div class="col-md-4">
                    <label>Tipo de cotización</label>

                    <select
                        name="tipo_cotizacion"
                        class="form-control"
                        x-model="tipo"
                        required
                    >
                        <option value="">
                            Seleccionar
                        </option>

                        <option value="omg">
                            OMG
                        </option>

                        <option value="dependencia_directa">
                            Dependencia directa
                        </option>

                        <option value="cliente_externo">
                            Cliente externo
                        </option>
                    </select>
                </div>

                <!-- ESTADO -->
                <div class="col-md-4">
                    <label>Estado</label>

                    <select
                        name="estado"
                        class="form-control"
                        x-model="estado"
                        required
                        @change="if (estado !== 'enviado') fechaEnvio = ''"
                    >
                        <option value="enviado">
                            Enviado
                        </option>

                        <option value="respaldo">
                            Respaldo
                        </option>

                        <option value="no_cotiza">
                            No cotiza
                        </option>
                    </select>
                </div>

                <!-- NÚMERO -->
                <div class="col-md-6 mt-3">
                    <label>Número de cotización</label>

                    <input
                        type="number"
                        name="numero_cotizacion"
                        class="form-control"
                    >
                </div>

                <!-- FOLIO -->
                <div class="col-md-6 mt-3">
                    <label>Folio externo</label>

                    <input
                        type="text"
                        name="folio_externo"
                        class="form-control"
                    >
                </div>

            </div>
        </div>

        <!-- =======================================================
            RELACIONES
        ======================================================= -->
        <div
            class="card mb-3"
            x-show="tipo !== 'cliente_externo'"
        >

            <div class="card-header fw-bold">
                Relaciones
            </div>

            <div class="card-body row">

                <!-- DEPENDENCIA -->
                <div class="col-md-4">

                    <label>Dependencia</label>

                    <select
                        name="dependencia_id"
                        class="form-control"
                    >
                        <option value="">
                            Seleccionar
                        </option>

                        <template
                            x-for="dep in dependencias"
                            :key="dep.id"
                        >
                            <option
                                :value="dep.id"
                                x-text="dep.nombre"
                            ></option>
                        </template>
                    </select>

                </div>

                <!-- DEPARTAMENTO -->
                <div class="col-md-4">

                    <label>Departamento</label>

                    <select
                        name="departamento_id"
                        class="form-control"
                        x-model="departamentoId"
                    >
                        <option value="">
                            Seleccionar
                        </option>

                        <template
                            x-for="dep in departamentos"
                            :key="dep.id"
                        >
                            <option
                                :value="dep.id"
                                x-text="dep.nombre"
                            ></option>
                        </template>
                    </select>

                    <button
                        type="button"
                        class="btn btn-outline-primary mt-2"
                        data-bs-toggle="modal"
                        data-bs-target="#modalDepartamento"
                    >
                        Nuevo departamento +
                    </button>

                </div>

                <!-- ANALISTA -->
                <div class="col-md-4">

                    <label>Analista</label>

                    <select
                        name="analista_id"
                        class="form-control"
                        x-model="analistaId"
                    >
                        <option value="">
                            Seleccionar
                        </option>

                        <template
                            x-for="analista in analistas"
                            :key="analista.id"
                        >
                            <option
                                :value="analista.id"
                                x-text="analista.nombre"
                            ></option>
                        </template>
                    </select>

                    <button
                        type="button"
                        class="btn btn-outline-primary mt-2"
                        data-bs-toggle="modal"
                        data-bs-target="#modalAnalista"
                    >
                        Nuevo analista +
                    </button>

                </div>

            </div>
        </div>

        <!-- =======================================================
            FECHAS
        ======================================================= -->
        <div class="card mb-3">

            <div class="card-header fw-bold">
                Fechas
            </div>

            <div class="card-body row">

                <!-- FECHA ENVÍO -->
                <div class="col-md-6">

                    <label>Fecha envío</label>

                    <input
                        type="date"
                        name="fecha_envio"
                        class="form-control"
                        x-model="fechaEnvio"
                        :readonly="estado !== 'enviado'"
                        :required="estado === 'enviado'"
                    >
                </div>

                <!-- FECHA RECEPCIÓN -->
                <div class="col-md-6">

                    <label>Fecha recepción</label>

                    <input
                        type="date"
                        name="fecha_recepcion"
                        class="form-control"
                    >
                </div>

            </div>
        </div>

        <!-- =======================================================
            GARANTÍA
        ======================================================= -->
        <div class="card mb-3">

            <div class="card-header fw-bold">
                Garantía
            </div>

            <div class="card-body row">

                <div class="col-md-6">

                    <label>Garantía</label>

                    <input
                        type="number"
                        name="garantia"
                        class="form-control"
                    >
                </div>

                <div class="col-md-6">

                    <label>Monto total</label>

                    <input
                        type="number"
                        step="0.01"
                        name="monto_total"
                        class="form-control"
                    >
                </div>

            </div>
        </div>

        <!-- =======================================================
            ENTREGA
        ======================================================= -->
        <div
            class="card mb-3"
            x-show="tipo !== 'cliente_externo'"
        >

            <div class="card-header fw-bold">
                Entrega
            </div>

            <div class="card-body row">

                <div class="col-md-6">

                    <label>Horario de entrega</label>

                    <input
                        type="time"
                        name="horario_de_entrega"
                        class="form-control"
                    >
                </div>

                <div class="col-md-6">

                    <label>Lugar de entrega</label>

                    <input
                        type="text"
                        name="lugar_de_entrega"
                        class="form-control"
                    >
                </div>

            </div>
        </div>

        <!-- =======================================================
            FINANCIEROS
        ======================================================= -->
        <div
            class="card mb-3"
            x-show="tipo === 'omg'"
        >

            <div class="card-header fw-bold">
                Financieros
            </div>

            <div class="card-body row">

                <div class="col-md-3">

                    <label>Días crédito</label>

                    <input
                        type="number"
                        name="dias_credito"
                        class="form-control"
                    >
                </div>

                <div class="col-md-3">

                    <label>Tipo días</label>

                    <select
                        name="tipo_dias"
                        class="form-control"
                    >
                        <option value="naturales">
                            Naturales
                        </option>

                        <option value="habiles">
                            Hábiles
                        </option>
                    </select>
                </div>

            </div>
        </div>

        <!-- =======================================================
            BOTÓN GUARDAR
        ======================================================= -->
        <div class="text-end">

            <button
                type="submit"
                class="btn btn-primary"
            >
                Guardar cotización
            </button>

        </div>

    </form>

    <!-- =======================================================
        MODAL ANALISTA
    ======================================================= -->
    <div
        class="modal fade"
        id="modalAnalista"
        tabindex="-1"
    >
        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Nuevo Analista
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>Nombre</label>

                            <input
                                type="text"
                                id="nuevo_nombre"
                                class="form-control"
                            >
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Apellido paterno</label>

                            <input
                                type="text"
                                id="nuevo_apellido_paterno"
                                class="form-control"
                            >
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Apellido materno</label>

                            <input
                                type="text"
                                id="nuevo_apellido_materno"
                                class="form-control"
                            >
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Teléfono</label>

                            <input
                                type="text"
                                id="nuevo_telefono"
                                class="form-control"
                            >
                        </div>

                        <div class="col-12 mb-3">
                            <label>Email</label>

                            <input
                                type="email"
                                id="nuevo_email"
                                class="form-control"
                            >
                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cancelar
                    </button>

                    <button
                        type="button"
                        class="btn btn-primary"
                        onclick="guardarAnalista()"
                    >
                        Guardar
                    </button>

                </div>

            </div>
        </div>
    </div>

    <!-- =======================================================
        MODAL DEPARTAMENTO
    ======================================================= -->
    <div
        class="modal fade"
        id="modalDepartamento"
        tabindex="-1"
    >
        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Nuevo Departamento
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                    ></button>

                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label>Nombre departamento</label>

                            <input
                                type="text"
                                id="nuevo_departamento"
                                class="form-control"
                            >
                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Responsable</label>

                            <input
                                type="text"
                                id="nuevo_responsable"
                                class="form-control"
                            >
                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Teléfono</label>

                            <input
                                type="text"
                                id="nuevo_departamento_telefono"
                                class="form-control"
                            >
                        </div>

                        <div class="col-md-6 mb-3">

                            <label>Email</label>

                            <input
                                type="email"
                                id="nuevo_departamento_email"
                                class="form-control"
                            >
                        </div>

                        <div class="col-12 mb-3">

                            <label>Dirección</label>

                            <input
                                type="text"
                                id="nuevo_departamento_direccion"
                                class="form-control"
                            >
                        </div>

                    </div>

                    <!-- ALERTA DEPARTAMENTO EXISTENTE -->
                    <div
                        id="departamento-existente"
                        class="alert alert-warning d-none"
                    >
                        Departamento existente:
                        <span id="departamento-info"></span>

                        <br>

                        <button
                            type="button"
                            class="btn btn-sm btn-primary mt-2"
                            onclick="usarDepartamentoExistente()"
                        >
                            Usar este departamento
                        </button>
                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cancelar
                    </button>

                    <button
                        type="button"
                        class="btn btn-primary"
                        onclick="guardarDepartamento()"
                    >
                        Guardar
                    </button>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- =======================================================
    ESTILOS
======================================================= -->
<style>
    [x-cloak] {
        display: none !important;
    }
</style>
<!-- =======================================================
    DATOS PARA JAVASCRIPT
======================================================= -->

<?php

$analistasJson = [];

foreach ($analistas as $a)
{
    $nombreCompleto = trim(
        $a->nombre . ' ' .
        ($a->apellido_paterno ?? '') . ' ' .
        ($a->apellido_materno ?? '')
    );

    $analistasJson[] = [
        'id' => $a->id,
        'nombre' => $nombreCompleto
    ];
}

$dependenciasJson = [];

foreach ($dependencias as $d)
{
    $dependenciasJson[] = [
        'id' => $d->id,
        'nombre' => $d->nombre_oficial
    ];
}

$departamentosJson = [];

foreach ($departamentos as $d)
{
    $departamentosJson[] = [
        'id' => $d->id,
        'nombre' => $d->nombre_departamento
    ];
}

?>

<script>

window.cotizacionData = {

    old: {

        tipo: '',
        estado: 'enviado',
        fechaEnvio: '',
        dependenciaId: '',
        analistaId: '',
        departamentoId: ''

    },

    dependencias: <?= json_encode($dependenciasJson) ?>,

    analistas: <?= json_encode($analistasJson) ?>,

    departamentos: <?= json_encode($departamentosJson) ?>,

    routes: {

        analistasStore:
            "<?= route('analistas.store') ?>",

        departamentosStore:
            "<?= route('departamentos.store') ?>",

        departamentosBuscar:
            "<?= route('departamentos.buscar') ?>"

    }

};

</script>

<script src="<?= asset('assets/js/especificos/cotizaciones/cotizaciones_create.js') ?>"></script>

<?php include __DIR__ . '/../../includes/layout_end.php'; ?>