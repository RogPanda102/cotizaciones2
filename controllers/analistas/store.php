<?php

require_once __DIR__ . '/../../config/database.php';

$data =
    json_decode(
        file_get_contents('php://input'),
        true
    );

$sql = "
    INSERT INTO analistas (
        nombre,
        apellido_paterno,
        apellido_materno,
        telefono,
        email
    )
    VALUES (
        :nombre,
        :apellido_paterno,
        :apellido_materno,
        :telefono,
        :email
    )
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':nombre' => $data['nombre'],
    ':apellido_paterno' => $data['apellido_paterno'],
    ':apellido_materno' => $data['apellido_materno'] ?? null,
    ':telefono' => $data['telefono'] ?? null,
    ':email' => $data['email'] ?? null,
]);

$id = $pdo->lastInsertId();

$nombreCompleto = trim(
    implode(' ', array_filter([
        $data['nombre'],
        $data['apellido_paterno'],
        $data['apellido_materno'] ?? null
    ]))
);

header('Content-Type: application/json');

echo json_encode([
    'id' => $id,
    'nombre_departamento' => $data['nombre_departamento']
]);

exit;