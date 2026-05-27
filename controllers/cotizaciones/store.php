<?php

use App\Enums\TipoAlerta;

require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../config/database.php';

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

$empresa_id = $_POST['empresa_id'] ?? null;
$tipo_cotizacion = $_POST['tipo_cotizacion'] ?? null;
$estado = $_POST['estado'] ?? null;

$numero_cotizacion = $_POST['numero_cotizacion'] ?? null;
$folio_externo = $_POST['folio_externo'] ?? null;

$dependencia_id = $_POST['dependencia_id'] ?? null;
$departamento_id = $_POST['departamento_id'] ?? null;
$analista_id = $_POST['analista_id'] ?? null;

$fecha_envio = $_POST['fecha_envio'] ?? null;
$fecha_recepcion = $_POST['fecha_recepcion'] ?? null;

$garantia = $_POST['garantia'] ?? null;
$monto_total = $_POST['monto_total'] ?? null;

$horario_de_entrega = $_POST['horario_de_entrega'] ?? null;
$lugar_de_entrega = $_POST['lugar_de_entrega'] ?? null;

$dias_credito = $_POST['dias_credito'] ?? null;
$tipo_dias = $_POST['tipo_dias'] ?? null;

/*
|--------------------------------------------------------------------------
| INSERTAR
|--------------------------------------------------------------------------
*/

$empresa_id = !empty($_POST['empresa_id'])
    ? (int) $_POST['empresa_id']
    : null;

$dependencia_id = !empty($_POST['dependencia_id'])
    ? (int) $_POST['dependencia_id']
    : null;

$departamento_id = !empty($_POST['departamento_id'])
    ? (int) $_POST['departamento_id']
    : null;

$analista_id = !empty($_POST['analista_id'])
    ? (int) $_POST['analista_id']
    : null;
$sql = "
    INSERT INTO cotizaciones
    (
        empresa_id,
        tipo_cotizacion,
        estado,
        numero_cotizacion,
        folio_externo,
        dependencia_id,
        departamento_id,
        analista_id,
        fecha_envio,
        fecha_recepcion,
        garantia,
        monto_total,
        horario_de_entrega,
        lugar_de_entrega,
        dias_credito,
        tipo_dias
    )
    VALUES
    (
        :empresa_id,
        :tipo_cotizacion,
        :estado,
        :numero_cotizacion,
        :folio_externo,
        :dependencia_id,
        :departamento_id,
        :analista_id,
        :fecha_envio,
        :fecha_recepcion,
        :garantia,
        :monto_total,
        :horario_de_entrega,
        :lugar_de_entrega,
        :dias_credito,
        :tipo_dias
    )
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':empresa_id' => $empresa_id,
    ':tipo_cotizacion' => $tipo_cotizacion,
    ':estado' => $estado,
    ':numero_cotizacion' => $numero_cotizacion,
    ':folio_externo' => $folio_externo,
    ':dependencia_id' => $dependencia_id,
    ':departamento_id' => $departamento_id,
    ':analista_id' => $analista_id,
    ':fecha_envio' => $fecha_envio,
    ':fecha_recepcion' => $fecha_recepcion,
    ':garantia' => $garantia,
    ':monto_total' => $monto_total,
    ':horario_de_entrega' => $horario_de_entrega,
    ':lugar_de_entrega' => $lugar_de_entrega,
    ':dias_credito' => $dias_credito,
    ':tipo_dias' => $tipo_dias
]);

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