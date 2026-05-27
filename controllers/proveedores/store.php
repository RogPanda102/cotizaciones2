<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/Enums/TipoAlerta.php';
use App\Enums\TipoAlerta;

$empresa = trim($_POST['empresa'] ?? '');
$nombre_contacto = trim($_POST['nombre_contacto'] ?? '');
$telefono = trim($_POST['telefono'] ?? '');
$email = trim($_POST['email'] ?? '');

$errores = [];

if(empty($empresa)) {

    $errores[] = 'El nombre de la empresa es obligatorio';

}

if(strlen($empresa) > 100) {

    $errores[] = 'El nombre de la empresa es demasiado largo';

}

if(strlen($nombre_contacto) > 50) {

    $errores[] = 'El nombre del contacto es demasiado largo';

}

if(!empty($errores)) {

    echo '<pre>';
    print_r($errores);
    echo '</pre>';

    exit;
}

$sql = "
    INSERT INTO proveedores(
        empresa,
        nombre_contacto,
        telefono,
        email
    )
    VALUES(
        :empresa,
        :nombre_contacto,
        :telefono,
        :email
    )
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':empresa' => $empresa,
    ':nombre_contacto' => $nombre_contacto,
    ':telefono' => $telefono,
    ':email' => $email
]);

mensaje(
    'Proveedor creado correctamente',
    TipoAlerta::SUCCESS
);

header('Location: ' . route('proveedores.index'));

exit;