<?php

require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/CotizacionModel.php';

use App\Enums\TipoAlerta;

$model = new CotizacionModel($pdo);

/*
|---------------------------------------------------------
| VALIDAR ID
|---------------------------------------------------------
*/
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: /cotizaciones2/cotizaciones");
    exit;
}

/*
|---------------------------------------------------------
| OBTENER DATOS DEL FORM
|---------------------------------------------------------
*/
$data = [

    'empresa_id' => $_POST['empresa_id'] ?? null,
    'tipo_cotizacion' => $_POST['tipo_cotizacion'] ?? null,
    'estado' => $_POST['estado'] ?? null,
    'numero_cotizacion' => $_POST['numero_cotizacion'] ?? null,
    'folio_externo' => $_POST['folio_externo'] ?? null,
    'dependencia_id' => $_POST['dependencia_id'] ?? null,
    'departamento_id' => $_POST['departamento_id'] ?? null,
    'analista_id' => $_POST['analista_id'] ?? null,
    'fecha_envio' => $_POST['fecha_envio'] ?? null,
    'fecha_recepcion' => $_POST['fecha_recepcion'] ?? null,
    'horario_de_entrega' => $_POST['horario_de_entrega'] ?? null,
    'lugar_de_entrega' => $_POST['lugar_de_entrega'] ?? null,
    'monto_total' => $_POST['monto_total'] ?? null,
    'dias_credito' => $_POST['dias_credito'] ?? null,

];

/*
|---------------------------------------------------------
| ACTUALIZAR
|---------------------------------------------------------
*/
$model->update($id, $data);

/*
|---------------------------------------------------------
| MENSAJE + REDIRECT
|---------------------------------------------------------
*/
mensaje(
    'Cotización actualizada correctamente',
    TipoAlerta::SUCCESS
);

header("Location: /cotizaciones2/cotizaciones");
exit;