<?php

require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../config/database.php';

use App\Enums\TipoAlerta;

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
| UPDATE SQL
|---------------------------------------------------------
*/
$sql = "
    UPDATE cotizaciones
    SET
        empresa_id = :empresa_id,
        tipo_cotizacion = :tipo_cotizacion,
        estado = :estado,
        numero_cotizacion = :numero_cotizacion,
        folio_externo = :folio_externo,
        dependencia_id = :dependencia_id,
        departamento_id = :departamento_id,
        analista_id = :analista_id,
        fecha_envio = :fecha_envio,
        fecha_recepcion = :fecha_recepcion,
        horario_de_entrega = :horario_de_entrega,
        lugar_de_entrega = :lugar_de_entrega,
        monto_total = :monto_total,
        dias_credito = :dias_credito
    WHERE id = :id
";

$stmt = $pdo->prepare($sql);

$data['id'] = $id;

$stmt->execute($data);

/*
|---------------------------------------------------------
| MENSAJE + REDIRECT
|---------------------------------------------------------
*/
mensaje('Cotización actualizada correctamente', TipoAlerta::SUCCESS);

header("Location: /cotizaciones2/cotizaciones");
exit;