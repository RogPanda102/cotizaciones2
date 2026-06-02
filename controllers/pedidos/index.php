<?php

require_once __DIR__ . '/../../config/database.php';



/*
|--------------------------------------------------------------------------
| OBTENER EMPRESA
|--------------------------------------------------------------------------
*/

$empresaId = $_GET['empresa_id'] ?? null;

if(!$empresaId) {

    die('Empresa inválida');

}

/*
|--------------------------------------------------------------------------
| EMPRESA
|--------------------------------------------------------------------------
*/

$sqlEmpresa = "
    SELECT *
    FROM empresas
    WHERE id = :id
";

$stmtEmpresa = $pdo->prepare($sqlEmpresa);

$stmtEmpresa->execute([
    ':id' => $empresaId
]);

$empresa = $stmtEmpresa->fetch(PDO::FETCH_OBJ);

if(!$empresa) {

    die('Empresa no encontrada');

}

/*
|--------------------------------------------------------------------------
| PEDIDOS
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT
        pedidos.*,
        cotizaciones.folio_externo,
        dependencias.nombre_oficial
    FROM pedidos

    LEFT JOIN cotizaciones
        ON cotizaciones.id = pedidos.cotizacion_id

    LEFT JOIN dependencias
        ON dependencias.id = pedidos.dependencia_id

    WHERE pedidos.empresa_id = :empresa_id

    ORDER BY pedidos.id DESC
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':empresa_id' => $empresaId
]);

$pedidos = $stmt->fetchAll(PDO::FETCH_OBJ);

/*
|--------------------------------------------------------------------------
| BREADCRUMB
|--------------------------------------------------------------------------
*/

$tarea = $empresa->nombre;

$breadcrumb_array = [
    [
        'tarea' => 'Pedidos',
        'href' => '#'
    ]
];

$breadcrumb = breadcrumb($tarea, $breadcrumb_array);

/*
|--------------------------------------------------------------------------
| VIEW
|--------------------------------------------------------------------------
*/

include __DIR__ . '/../../pages/pedidos/index.php';