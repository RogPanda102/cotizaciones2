<?php

require_once __DIR__ . '/../../config/database.php';

/*
|--------------------------------------------------------------------------
| EMPRESA ID
|--------------------------------------------------------------------------
*/

$empresaId = $_GET['empresa_id'] ?? null;

if (!$empresaId) {

    die('Empresa inválida');

}

/*
|--------------------------------------------------------------------------
| EMPRESA
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT *
    FROM empresas
    WHERE id = :id
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':id' => $empresaId
]);

$empresa = $stmt->fetch(PDO::FETCH_OBJ);

if (!$empresa) {

    die('Empresa no encontrada');

}

/*
|--------------------------------------------------------------------------
| COTIZACIONES
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT *
    FROM cotizaciones
    ORDER BY id DESC
";

$stmt = $pdo->query($sql);

$cotizaciones = $stmt->fetchAll(PDO::FETCH_OBJ);

/*
|--------------------------------------------------------------------------
| DEPENDENCIAS
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT *
    FROM dependencias
    ORDER BY nombre_oficial
";

$stmt = $pdo->query($sql);

$dependencias = $stmt->fetchAll(PDO::FETCH_OBJ);

/*
|--------------------------------------------------------------------------
| PROVEEDORES
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT *
    FROM proveedores
    ORDER BY empresa
";

$stmt = $pdo->query($sql);

$proveedores = $stmt->fetchAll(PDO::FETCH_OBJ);

/*
|--------------------------------------------------------------------------
| ANALISTAS
|--------------------------------------------------------------------------
*/

$sql = "
    SELECT *
    FROM analistas
    ORDER BY nombre
";

$stmt = $pdo->query($sql);

$analistas = $stmt->fetchAll(PDO::FETCH_OBJ);

/*
|--------------------------------------------------------------------------
| BREADCRUMB
|--------------------------------------------------------------------------
*/

$nombre_pagina = '';

$tarea = $empresa->nombre;

$breadcrumb_array = [
    [
        'tarea' => 'Pedidos',
        'href' => route('pedidos.index') . '?empresa_id=' . $empresaId
    ],
    [
        'tarea' => 'Crear pedido',
        'href' => '#'
    ]
];

$breadcrumb = breadcrumb($tarea, $breadcrumb_array);

/*
|--------------------------------------------------------------------------
| VISTA
|--------------------------------------------------------------------------
*/

include __DIR__ . '/../../pages/pedidos/create.php';