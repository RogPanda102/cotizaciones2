<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/DependenciaModel.php';

$model = new DependenciaModel($pdo);
$dependencias = $model->getAll();
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
/*
|--------------------------------------------------------------------------
| VISTA
|--------------------------------------------------------------------------
*/
include __DIR__ . '/../../pages/dependencias/index.php';