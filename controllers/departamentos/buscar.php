<?php

require_once __DIR__ . '/../../config/database.php';

$email = isset($_GET['email'])
    ? trim(strtolower($_GET['email']))
    : '';

$telefono = isset($_GET['telefono'])
    ? preg_replace('/\D/', '', $_GET['telefono'])
    : '';

$departamento = null;

if (!empty($email)) {

    $sql = "
        SELECT *
        FROM departamentos
        WHERE LOWER(email) = :email
        LIMIT 1
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':email' => $email
    ]);

    $departamento = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (!$departamento && !empty($telefono)) {

    $sql = "
        SELECT *
        FROM departamentos
        WHERE REPLACE(
            REPLACE(
                REPLACE(
                    REPLACE(telefono,'-',''),
                ' ',''),
            '(',''),
        ')','')
        = :telefono
        LIMIT 1
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':telefono' => $telefono
    ]);

    $departamento = $stmt->fetch(PDO::FETCH_ASSOC);
}

header('Content-Type: application/json');

echo json_encode($departamento ?: []);

exit;