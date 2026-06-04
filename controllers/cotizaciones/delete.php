<?php
    require_once __DIR__ . '/../../config/app.php';
    require_once __DIR__ . '/../../config/database.php';
    require_once __DIR__ . '/../../models/CotizacionModel.php';
    use App\Enums\TipoAlerta;
    $model = new CotizacionModel($pdo);
    $id = $_GET['id'] ?? null;
    if (!$id)
    {
        die('ID inválido');
    }
    /*
    |--------------------------------------------------------------------------
    | VALIDAR PEDIDOS RELACIONADOS
    |--------------------------------------------------------------------------
    */
    if ($model->tienePedidos($id))
    {
        mensaje(
            'No puedes eliminar esta cotización porque tiene un pedido relacionado',
            TipoAlerta::WARNING
        );
        header('Location: ' . route('cotizaciones.index'));
        exit;
    }
    /*
    |--------------------------------------------------------------------------
    | ELIMINAR
    |--------------------------------------------------------------------------
    */
    $model->delete($id);
    mensaje(
        'Cotización eliminada correctamente',
        TipoAlerta::SUCCESS
    );
    header('Location: ' . route('cotizaciones.index'));
    exit;