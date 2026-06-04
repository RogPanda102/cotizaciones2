<?php

use App\Enums\TipoAlerta;

require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/CotizacionModel.php';

$model = new CotizacionModel($pdo);
/*
|--------------------------------------------------------------------------
| VALIDAR MÉTODO
|--------------------------------------------------------------------------
*/
if ($_SERVER['REQUEST_METHOD'] !== 'POST')
{
    header('Location: ' . route('cotizaciones.index'));
    exit;
}
/*
|--------------------------------------------------------------------------
| DATOS
|--------------------------------------------------------------------------
*/
$data = [

    'empresa_id' => !empty($_POST['empresa_id'])
        ? (int) $_POST['empresa_id']
        : null,
    'tipo_cotizacion' => $_POST['tipo_cotizacion'] ?? null,
    'estado' => $_POST['estado'] ?? null,
    'numero_cotizacion' => $_POST['numero_cotizacion'] ?? null,
    'folio_externo' => $_POST['folio_externo'] ?? null,
    'dependencia_id' => !empty($_POST['dependencia_id'])
        ? (int) $_POST['dependencia_id']
        : null,
    'departamento_id' => !empty($_POST['departamento_id'])
        ? (int) $_POST['departamento_id']
        : null,
    'analista_id' => !empty($_POST['analista_id'])
        ? (int) $_POST['analista_id']
        : null,
    'fecha_envio' => $_POST['fecha_envio'] ?? null,
    'fecha_recepcion' => $_POST['fecha_recepcion'] ?? null,
    'garantia' => $_POST['garantia'] ?? null,
    'monto_total' => $_POST['monto_total'] ?? null,
    'horario_de_entrega' => $_POST['horario_de_entrega'] ?? null,
    'lugar_de_entrega' => $_POST['lugar_de_entrega'] ?? null,
    'dias_credito' => $_POST['dias_credito'] ?? null,
    'tipo_dias' => $_POST['tipo_dias'] ?? null
];
/*
|--------------------------------------------------------------------------
| GUARDAR
|--------------------------------------------------------------------------
*/
$model->create($data);
/*
|--------------------------------------------------------------------------
| MENSAJE
|--------------------------------------------------------------------------
*/
mensaje(
    'La cotización ha sido creada correctamente',
    TipoAlerta::SUCCESS
);
/*
|--------------------------------------------------------------------------
| REDIRECT
|--------------------------------------------------------------------------
*/
header('Location: ' . route('cotizaciones.index'));
exit;