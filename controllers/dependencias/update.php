<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/Enums/TipoAlerta.php';
use App\Enums\TipoAlerta;

$id = $_POST['id'] ?? null;

$nombre_oficial = trim($_POST['nombre_oficial'] ?? '');

$nombre_corto = trim($_POST['nombre_corto'] ?? '');

if(!$id) {

    die('ID inválido');

}

$errores = [];

if(empty($nombre_oficial)) {

    $errores[] = 'El nombre oficial es obligatorio';

}

if(strlen($nombre_oficial) > 255) {

    $errores[] = 'El nombre oficial es demasiado largo';

}

if(strlen($nombre_corto) > 255) {

    $errores[] = 'El nombre corto es demasiado largo';

}

if(!empty($errores)) {

    echo '<pre>';
    print_r($errores);
    echo '</pre>';

    exit;
}

$sql = "
    UPDATE dependencias
    SET
        nombre_oficial = :nombre_oficial,
        nombre_corto = :nombre_corto
    WHERE id = :id
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':nombre_oficial' => $nombre_oficial,
    ':nombre_corto' => $nombre_corto,
    ':id' => $id
]);

mensaje(
    'Dependencia creada correctamente',
    TipoAlerta::SUCCESS
);

header('Location: ' . route('dependencias.index'));

exit;