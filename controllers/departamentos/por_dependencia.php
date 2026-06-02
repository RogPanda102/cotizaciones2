<?php
// Endpoint AJAX utilizado por pedidos_create.js
// Devuelve departamentos filtrados por dependencia.
require_once __DIR__ . '/../../config/database.php';

$dependenciaId = $_GET['dependencia_id'] ?? null;

if (!$dependenciaId) {

    echo json_encode([]);

    exit;
}

$sql = "
    SELECT
        id,
        nombre_departamento,
        responsable
    FROM departamentos
    WHERE dependencia_id = :dependencia_id
    ORDER BY nombre_departamento
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':dependencia_id' => $dependenciaId
]);

header('Content-Type: application/json');

echo json_encode(
    $stmt->fetchAll(PDO::FETCH_ASSOC)
);

exit;