<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/Enums/TipoAlerta.php';
use App\Enums\TipoAlerta;

$id = $_POST['id'] ?? null;

if(!$id) {

    die('ID inválido');

}

/*
|--------------------------------------------------------------------------
| VALIDAR PEDIDOS RELACIONADOS
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT COUNT(*) as total
    FROM pedidos
    WHERE dependencia_id = :id
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':id' => $id
]);

$resultado = $stmt->fetch(PDO::FETCH_OBJ);

if($resultado->total > 0) {

    mensaje(
        'No puedes eliminar esta dependencia porque tiene pedidos relacionados',
        TipoAlerta::WARNING
    );

    header('Location: ' . route('dependencias.index'));

    exit;
}

/*
|--------------------------------------------------------------------------
| ELIMINAR
|--------------------------------------------------------------------------
*/

$sql = "
    DELETE FROM dependencias
    WHERE id = :id
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':id' => $id
]);

mensaje(
    'Dependencia eliminada correctamente',
    TipoAlerta::SUCCESS
);

header('Location: ' . route('dependencias.index'));

exit;