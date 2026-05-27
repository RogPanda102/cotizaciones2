<?php

require_once __DIR__ . '/../../config/database.php';

$query = $pdo->query("
    SELECT * FROM proveedores
");

$proveedores = $query->fetchAll(PDO::FETCH_OBJ);

/*
|--------------------------------------------------------------------------
| DATOS GENERALES
|--------------------------------------------------------------------------
*/

$nombre_pagina = '';

$tarea = 'Proveedores';

$breadcrumb_array = [
    [
        'tarea' => 'Proveedores',
        'href' => '#'
    ]
];

$breadcrumb = breadcrumb($tarea, $breadcrumb_array);

include  __DIR__ . '/../../pages/proveedores/index.php';