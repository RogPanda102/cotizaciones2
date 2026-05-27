<?php

require_once __DIR__ . '/../../config/database.php';

$query = $pdo->query("
    SELECT * FROM dependencias
");

$dependencias = $query->fetchAll(PDO::FETCH_OBJ);

/*
|--------------------------------------------------------------------------
| DATOS GENERALES
|--------------------------------------------------------------------------
*/

$nombre_pagina = '';

$tarea = 'Dependencias';

$breadcrumb_array = [
    [
        'tarea' => 'Dependencias',
        'href' => '#'
    ]
];

$breadcrumb = breadcrumb($tarea, $breadcrumb_array);

include  __DIR__ . '/../../pages/dependencias/index.php';