<?php include __DIR__ . '/../../includes/layout_start.php'; ?>

<?php
/** @var object $cotizacion */
/** @var array $empresas */
/** @var array $dependencias */
/** @var array $departamentos */
/** @var array $analistas */
?>

<div x-data="cotizacionForm({
    tipo: '<?= $cotizacion->tipo_cotizacion ?>',
    estado: '<?= $cotizacion->estado ?>'
})" class="container">

<form method="POST" action="<?= route('cotizaciones.update') ?>?id=<?= $cotizacion->id ?>">

    <div class="card mb-3">

        <div class="card-header fw-bold">

            Información base

        </div>

        <div class="card-body row">

            <div class="col-md-4">

                <label>Empresa</label>

                <select name="empresa_id" class="form-control" required>

                    <?php foreach($empresas as $empresa): ?>

                        <option
                            value="<?= $empresa->id ?>"
                            <?= $cotizacion->empresa_id == $empresa->id ? 'selected' : '' ?>
                        >

                            <?= $empresa->nombre ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

            <div class="col-md-4">

                <label>Tipo</label>

                <select
                    name="tipo_cotizacion"
                    x-model="tipo"
                    class="form-control"
                    required
                >

                    <option value="omg">OMG</option>
                    <option value="dependencia_directa">Dependencia directa</option>
                    <option value="cliente_externo">Cliente externo</option>

                </select>

            </div>

            <div class="col-md-4">

                <label>Estado</label>

                <select
                    name="estado"
                    x-model="estado"
                    class="form-control"
                    required
                >

                    <option value="enviado">Enviado</option>
                    <option value="respaldo">Respaldo</option>
                    <option value="no_cotiza">No cotiza</option>

                </select>

            </div>

            <div class="col-md-6 mt-3">

                <label>Número</label>

                <input
                    type="number"
                    name="numero_cotizacion"
                    value="<?= $cotizacion->numero_cotizacion ?>"
                    class="form-control"
                >

            </div>

            <div class="col-md-6 mt-3">

                <label>Folio</label>

                <input
                    type="text"
                    name="folio_externo"
                    value="<?= $cotizacion->folio_externo ?>"
                    class="form-control"
                >

            </div>

        </div>

    </div>

    <!-- RELACIONES -->
    <div class="card mb-3">

        <div class="card-body row">

            <div class="col-md-4">

                <label>Dependencia</label>

                <select
                    name="dependencia_id"
                    class="form-control"
                    x-bind:disabled="tipo === 'cliente_externo'"
                >

                    <?php foreach($dependencias as $dep): ?>

                        <option
                            value="<?= $dep->id ?>"
                            <?= $cotizacion->dependencia_id == $dep->id ? 'selected' : '' ?>
                        >

                            <?= $dep->nombre_oficial ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

            <div class="col-md-4">

                <label>Departamento</label>

                <select
                    name="departamento_id"
                    class="form-control"
                    x-bind:disabled="tipo === 'cliente_externo'"
                >

                    <?php foreach($departamentos as $dep): ?>

                        <option
                            value="<?= $dep->id ?>"
                            <?= $cotizacion->departamento_id == $dep->id ? 'selected' : '' ?>
                        >

                            <?= $dep->nombre_departamento ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

            <div
                class="col-md-4"
                x-show="tipo !== 'cliente_externo'"
            >

                <label>Analista</label>

                <select
                    name="analista_id"
                    class="form-control"
                    x-bind:disabled="tipo === 'cliente_externo'"
                >

                    <?php foreach($analistas as $a): ?>

                        <option
                            value="<?= $a->id ?>"
                            <?= $cotizacion->analista_id == $a->id ? 'selected' : '' ?>
                        >

                            <?= $a->nombre ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

        </div>

    </div>

    <!-- FECHAS -->
    <div class="card mb-3">

        <div class="card-body row">

            <div class="col-md-6">

                <label>Fecha envío</label>

                <input
                    type="date"
                    name="fecha_envio"
                    value="<?= $cotizacion->fecha_envio ?>"
                    class="form-control"
                    x-bind:disabled="estado !== 'enviado'"
                >

            </div>

            <div class="col-md-6">

                <label>Fecha recepción</label>

                <input
                    type="date"
                    name="fecha_recepcion"
                    value="<?= $cotizacion->fecha_recepcion ?>"
                    class="form-control"
                >

            </div>

        </div>

    </div>

    <!-- ENTREGA -->
    <div
        class="card mb-3"
        x-show="tipo !== 'cliente_externo'"
    >

        <div class="card-body row">

            <div class="col-md-6">

                <label>Horario</label>

                <input
                    type="time"
                    name="horario_de_entrega"
                    value="<?= substr($cotizacion->horario_de_entrega, 0, 5) ?>"
                    class="form-control"
                    x-bind:disabled="tipo === 'cliente_externo'"
                >

            </div>

            <div class="col-md-6">

                <label>Lugar</label>

                <input
                    type="text"
                    name="lugar_de_entrega"
                    value="<?= $cotizacion->lugar_de_entrega ?>"
                    class="form-control"
                    x-bind:disabled="tipo === 'cliente_externo'"
                >

            </div>

        </div>

    </div>

    <!-- FINANCIEROS -->
    <div
        class="card mb-3"
        x-show="tipo === 'omg'"
    >

        <div class="card-body row">

            <div class="col-md-6">

                <label>Monto total</label>

                <input
                    type="number"
                    name="monto_total"
                    value="<?= $cotizacion->monto_total ?>"
                    class="form-control"
                    x-bind:disabled="tipo !== 'omg'"
                >

            </div>

            <div class="col-md-6">

                <label>Días crédito</label>

                <input
                    type="number"
                    name="dias_credito"
                    value="<?= $cotizacion->dias_credito ?>"
                    class="form-control"
                    x-bind:disabled="tipo !== 'omg'"
                >

            </div>

        </div>

    </div>

    <button class="btn btn-primary">

        Actualizar

    </button>

</form>

</div>

<script>

function cotizacionForm(data)
{
    return {
        tipo: data.tipo,
        estado: data.estado
    }
}

</script>

<?php include __DIR__ . '/../../includes/layout_end.php'; ?>