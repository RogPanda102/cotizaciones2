<?php

require_once __DIR__ . '/../../config/database.php';

$data =
    json_decode(
        file_get_contents('php://input'),
        true
    );

$sql = "
    INSERT INTO departamentos (
        dependencia_id,
        nombre_departamento,
        responsable,
        telefono,
        email,
        direccion
    )
    VALUES (
        :dependencia_id,
        :nombre_departamento,
        :responsable,
        :telefono,
        :email,
        :direccion
    )
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':dependencia_id' =>
        $data['dependencia_id'] ?: null,

    ':nombre_departamento' =>
        trim($data['nombre_departamento']),

    ':responsable' =>
        $data['responsable'] ?? null,

    ':telefono' =>
        $data['telefono'] ?? null,

    ':email' =>
        $data['email'] ?? null,

    ':direccion' =>
        $data['direccion'] ?? null,
]);

$id = $pdo->lastInsertId();

header('Content-Type: application/json');

echo json_encode([
    'id' => $id,
    'nombre' => $data['nombre_departamento']
]);

exit;