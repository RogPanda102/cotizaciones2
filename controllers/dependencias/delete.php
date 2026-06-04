<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/DependenciaModel.php';
require_once __DIR__ . '/../../app/Enums/TipoAlerta.php';
use App\Enums\TipoAlerta;
$model = new DependenciaModel($pdo);
$id = $_POST['id'] ?? null;
if (!$id) {

    die('ID inválido');

}
/*
|--------------------------------------------------------------------------
| VALIDAR PEDIDOS RELACIONADOS
|--------------------------------------------------------------------------
*/
if($model->tienePedidosRelacionados($id))
{
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
$model->delete($id);
mensaje(
    'Dependencia eliminada correctamente',
    TipoAlerta::SUCCESS
);
header('Location: ' . route('dependencias.index'));
exit;