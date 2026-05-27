<?php

require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../config/database.php';
use App\Enums\TipoAlerta;

$id = $_GET['id'] ?? null;

if (!$id) {
    die('ID inválido');
}

/*
|--------------------------------------------------
| VALIDAR SI TIENE PEDIDO RELACIONADO
|--------------------------------------------------
*/

$sql = "SELECT COUNT(*) FROM pedidos WHERE cotizacion_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

$tienePedido = $stmt->fetchColumn();

if ($tienePedido > 0) {
    mensaje('No puedes eliminar esta cotización porque tiene un pedido relacionado', TipoAlerta::WARNING);
    header("Location: /cotizaciones2/cotizaciones");
    exit;
}

/*
|--------------------------------------------------
| ELIMINAR
|--------------------------------------------------
*/

$sql = "DELETE FROM cotizaciones WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

mensaje('Cotización eliminada correctamente', TipoAlerta::SUCCESS);
header("Location: /cotizaciones2/cotizaciones");
exit;