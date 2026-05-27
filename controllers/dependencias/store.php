<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/Enums/TipoAlerta.php';
use App\Enums\TipoAlerta;

$nombre_oficial = trim($_POST['nombre_oficial'] ?? '');
$nombre_corto = trim($_POST['nombre_corto'] ?? '');

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
    INSERT INTO dependencias(
        nombre_oficial,
        nombre_corto
    )
    VALUES(
        :nombre_oficial,
        :nombre_corto
    )
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':nombre_oficial' => $nombre_oficial,
    ':nombre_corto' => $nombre_corto
]);

mensaje(
    'Dependencia creada correctamente',
    TipoAlerta::SUCCESS
);

header('Location: ' . route('dependencias.index'));

exit;