<?php include __DIR__ . '/../../includes/layout_start.php'; ?>
<?php /** @var array $cotizaciones */ ?>
<?php /** @var array $dependencias */ ?>   
<?php /** @var array $proveedores */ ?>
<?php /** @var array $analistas */ ?>
<?php /** @var object $empresa */ ?>



<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4">Crear Pedido</h4>

            <form id="formPedido" action="<?= route('pedidos.store') ?>" method="POST">
                <?php // CSRF token manual ?>
                <input type="hidden" name="_token">

                <!-- DATOS GENERALES -->
                <h5 class="mb-3">Datos generales</h5>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Cotización</label>
                        <select name="cotizacion_id" class="form-control w-100">
                            <?php foreach($cotizaciones as $cot): ?>
                                <option value="<?= $cot->id ?>"><?= htmlspecialchars($cot->folio_externo) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">

                        <label class="form-label">Empresa</label>

                        <input
                            type="hidden"
                            name="empresa_id"
                            value="<?= $empresa->id ?>"
                        >

                        <input
                            type="text"
                            class="form-control"
                            value="<?= htmlspecialchars($empresa->nombre) ?>"
                            readonly
                        >

                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Dependencia</label>
                        <select name="dependencia_id" id="dependenciaSelect" class="form-control">
                            <option value="">Seleccionar dependencia</option>
                            <?php foreach($dependencias as $dep): ?>
                                <option value="<?= $dep->id ?>" <?= old('dependencia_id') == $dep->id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($dep->nombre_oficial) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <hr>

                <!-- DEPARTAMENTO / PROVEEDOR -->
                <h5 class="mb-3">Departamento, analista y proveedor</h5>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Departamento</label>
                        <select name="departamento_id" id="departamentoSelect" class="form-control w-100">
                            <option value="">Selecciona departamento</option>
                            
                        </select>
                        <button type="button" class="btn btn-outline-secondary mt-2" data-bs-toggle="modal" data-bs-target="#modalDepartamento">
                            + Nuevo departamento
                        </button>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Analista</label>
                        <select name="analista_id" id="analistaSelect" class="form-control w-100">
                            <option value="">Selecciona analista</option>
                            <?php foreach($analistas as $analista): ?>
                                <?php
                                    $nombreCompleto = trim(implode(' ', array_filter([
                                        $analista->nombre,
                                        $analista->apellido_paterno,
                                        $analista->apellido_materno,
                                    ])));
                                ?>
                                <option value="<?= $analista->id ?>" <?= old('analista_id') == $analista->id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($nombreCompleto) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="button" class="btn btn-outline-secondary mt-2" data-bs-toggle="modal" data-bs-target="#modalAnalista">
                            + Nuevo analista
                        </button>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Proveedor</label>
                        <select name="proveedor_id" class="form-control w-100">
                            <option value="">Selecciona proveedor</option>
                            <?php foreach($proveedores as $proveedor): ?>
                                <option value="<?= $proveedor->id ?>" <?= old('proveedor_id') == $proveedor->id ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($proveedor->empresa) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <hr>

                <!-- TIPO DE PEDIDO -->
                <h5 class="mb-3">Tipo de pedido</h5>                  
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tipo</label>

                        <select name="tipo" id="tipoPedido" class="form-control">

                            <option value="">Selecciona tipo</option>

                            <option value="servicio"
                                <?= old('tipo') == 'servicio' ? 'selected' : '' ?>>
                                Servicio
                            </option>

                            <option value="licencia"
                                <?= old('tipo') == 'licencia' ? 'selected' : '' ?>>
                                Licencia
                            </option>

                            <option value="mercadeo"
                                <?= old('tipo') == 'mercadeo' ? 'selected' : '' ?>>
                                Mercadeo
                            </option>

                        </select>
                    </div>

                </div>

                <!-- SERVICIO -->
                <div id="servicioSection" style="display: none;">
                    <hr>
                    <h5>Datos del servicio</h5>

                    <label class="form-label">Descripción</label>
                    <input name="descripcion_servicio" class="form-control mb-2" placeholder="Descripción" value="<?= htmlspecialchars(old('descripcion_servicio') ?? '') ?>">
                    <label class="form-label">Alcance</label>
                    <input name="alcance" class="form-control mb-2" placeholder="Alcance" value="<?= htmlspecialchars(old('alcance') ?? '') ?>">
                    <label class="form-label">Responsable</label>
                    <input type="text" name="responsable" class="form-control mb-2" placeholder="Responsable" value="<?= htmlspecialchars(old('responsable') ?? '' ) ?>">
                    <label class="form-label">Entregables</label>
                    <input name="entregables" class="form-control mb-2" placeholder="Entregables" value="<?= htmlspecialchars(old('entregables') ?? '') ?>">
                    <label class="form-label">Observaciones</label>
                    <input name="observaciones" class="form-control mb-2" placeholder="Observaciones" value="<?= htmlspecialchars(old('observaciones') ?? '') ?>">

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Fecha de inicio</label>
                            <input type="date" name="fecha_inicio_servicio" class="form-control" value="<?= htmlspecialchars(old('fecha_inicio_servicio') ?? '') ?>">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Fecha de fin</label>
                            <input type="date" name="fecha_fin_servicio" class="form-control" value="<?= htmlspecialchars(old('fecha_fin_servicio') ?? '') ?>">
                        </div>
                    </div>
                    <label class="form-label">Costo del servicio</label>
                    <input type="number" name="costo_servicio" class="form-control mb-2" placeholder="Costo" value="<?= htmlspecialchars(old('costo_servicio') ?? '') ?>">
                </div>

                <!-- LICENCIA -->
                <div id="licenciaSection" style="display: none;">
                    <hr>
                    <h5>Datos de licencia</h5>

                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre_licencia" class="form-control mb-2" placeholder="Nombre" value="<?= htmlspecialchars(old('nombre_licencia') ?? '') ?>">
                    <label class="form-label">Tipo</label>
                    <input type="text" name="tipo_licencia" class="form-control mb-2" placeholder="Tipo" value="<?= htmlspecialchars(old('tipo_licencia') ?? '') ?>">
                    <label class="form-label">Número de usuarios</label>
                    <input type="number" name="numero_usuarios" class="form-control mb-2" placeholder="Número de usuarios" value="<?= htmlspecialchars(old('numero_usuarios') ?? '') ?>">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Costo de renovación</label>
                            <input type="number" name="costo_renovacion" class="form-control" placeholder="Costo de renovación" value="<?= htmlspecialchars(old('costo_renovacion') ?? '') ?>">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Costo de licencia</label>
                            <input type="number" name="costo_licencia" class="form-control" placeholder="Costo de licencia" value="<?= htmlspecialchars(old('costo_licencia') ?? '') ?>">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Fecha de inicio</label>
                            <input type="date" name="fecha_inicio_licencia" class="form-control" value="<?= htmlspecialchars(old('fecha_inicio_licencia') ?? '') ?>">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Fecha de fin</label>
                            <input type="date" name="fecha_fin_licencia" class="form-control" value="<?= htmlspecialchars(old('fecha_fin_licencia') ?? '') ?>">
                        </div>
                    </div>
                </div>

                <!-- MERCADEO -->
                <div id="mercadeoSection" style="display: none;">
                    <hr>
                    <p class="text-muted">
                        Este pedido se gestionará mediante compras después de crearlo.
                    </p>
                </div>

                <hr>

                <!-- FINANZAS Y FECHAS -->
                <h5 class="mb-3">Condiciones</h5>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Monto aprobado</label>
                        <input type="number" name="monto_total_aprobado" class="form-control" value="<?= htmlspecialchars(old('monto_total_aprobado')) ?>">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Días entrega</label>
                        <input type="number" name="dias_entrega" class="form-control" value="<?= htmlspecialchars(old('dias_entrega')) ?>">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Días crédito</label>
                        <input type="number" name="dias_credito" class="form-control" value="<?= htmlspecialchars(old('dias_credito')) ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Fecha adjudicación</label>
                        <input type="date" name="fecha_adjudicacion" class="form-control" value="<?= htmlspecialchars(old('fecha_adjudicacion')) ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Tipo de días</label>
                        <select name="tipo_dias" class="form-control">
                            <option value="naturales" <?= old('tipo_dias') == 'naturales' ? 'selected' : '' ?>>Naturales</option>
                            <option value="habiles" <?= old('tipo_dias') == 'habiles' ? 'selected' : '' ?>>Hábiles</option>
                        </select>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Lugar de entrega</label>

                        <input
                            type="text"
                            name="lugar_entrega"
                            class="form-control"
                            value="<?= htmlspecialchars(old('lugar_entrega') ?? '') ?>"
                            placeholder="Lugar de entrega"
                        >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Condición de entrega</label>

                        <input
                            name="condiciones_entrega"
                            class="form-control"
                            rows="1"
                            placeholder="Condiciones de entrega"
                            value="<?= htmlspecialchars(old('condiciones_entrega') ?? '') ?>"
                        >
                    </div>

                </div>

                <hr>

                <button type="submit" class="btn btn-primary">
                    Guardar Pedido
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Analista -->
<div class="modal fade" id="modalAnalista" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Analista</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <input type="text" id="nuevo_analista_nombre" class="form-control" placeholder="Nombre">
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="text" id="nuevo_analista_apellido_paterno" class="form-control" placeholder="Apellido paterno">
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="text" id="nuevo_analista_apellido_materno" class="form-control" placeholder="Apellido materno">
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="text" id="nuevo_analista_telefono" class="form-control" placeholder="Teléfono">
                    </div>
                    <div class="col-12 mb-3">
                        <input type="email" id="nuevo_analista_email" class="form-control" placeholder="Email">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarAnalista()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Departamento -->
<div class="modal fade" id="modalDepartamento" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Departamento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        
                        <input
                            type="hidden"
                            id="modalDependenciaId"
                        >
                        <input
                            type="text"
                            id="modalDependenciaNombre"
                            class="form-control"
                            readonly
                        >
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="text" id="nuevo_departamento" class="form-control" placeholder="Nombre del departamento">
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="text" id="nuevo_telefono" class="form-control" placeholder="Teléfono">
                    </div>
                    <div class="col-md-6 mb-3">
                        <input type="email" id="nuevo_email" class="form-control" placeholder="Email">
                    </div>
                    <div class="col-12 mb-3">
                        <input type="text" id="nuevo_responsable" class="form-control" placeholder="Responsable">
                    </div>
                    <div class="col-12 mb-3">
                        <input type="text" id="nueva_direccion" class="form-control" placeholder="Dirección">
                    </div>
                </div>
                <div id="departamento-existente" class="alert alert-warning d-none">
                    Departamento existente: <span id="departamento-info"></span>
                    <br>
                    <button type="button" class="btn btn-sm btn-primary mt-2" onclick="usarClienteExistente()">
                        Usar este departamento
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="guardarDepartamento()">Guardar</button>
            </div>
        </div>
    </div>
</div>





<script src="<?= asset('public/js/especificos/pedidos/pedidos_create.js') ?>?v=<?= time() ?>"></script>
<script>

window.routes = {
    departamentosPorDependencia:
        "<?= route('departamentos.por_dependencia') ?>",

    departamentosBuscar:
        "<?= route('departamentos.buscar') ?>",

    departamentosStore:
        "<?= route('departamentos.store') ?>",

    analistasStore:
        "<?= route('analistas.store') ?>"
};



</script>

<?php include __DIR__ . '/../../includes/layout_end.php'; ?>