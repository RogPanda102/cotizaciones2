<?php

require_once __DIR__ . '/../../config/database.php';

$id = $_GET['id'] ?? null;

if(!$id) {

    die('ID no recibido');

}

$sql = "
    SELECT *
    FROM proveedores
    WHERE id = :id
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':id' => $id
]);

$proveedor = $stmt->fetch(PDO::FETCH_OBJ);

if(!$proveedor) {

    die('Proveedor no encontrado');

}
/*
|--------------------------------------------------------------------------
| DATOS GENERALES
|--------------------------------------------------------------------------
*/

$nombre_pagina = '';

$tarea = 'Editar proveedor';

$breadcrumb_array = [
    [
        'tarea' => 'Proveedores',
        'href' => route('proveedores.index')
    ],
    [
        'tarea' => 'Editar proveedor',
        'href' => '#'
    ]
];

$breadcrumb = breadcrumb($tarea, $breadcrumb_array);


include __DIR__ . '/../../pages/proveedores/edit.php';