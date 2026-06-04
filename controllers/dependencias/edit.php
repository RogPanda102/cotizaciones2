<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/DependenciaModel.php';

$model = new DependenciaModel($pdo);

$id = $_GET['id'] ?? null;

if (!$id)
{
    die('ID no recibido');
}

$dependencia = $model->getById($id);

if (!$dependencia)
{
    die('Dependencia no encontrada');
}

/*
|--------------------------------------------------------------------------
| DATOS GENERALES
|--------------------------------------------------------------------------
*/

$nombre_pagina = '';

$tarea = 'Editar dependencia';

$breadcrumb_array = [
    [
        'tarea' => 'Dependencias',
        'href' => route('dependencias.index')
    ],
    [
        'tarea' => 'Editar dependencia',
        'href' => '#'
    ]
];

$breadcrumb = breadcrumb($tarea, $breadcrumb_array);

/*
|--------------------------------------------------------------------------
| VISTA
|--------------------------------------------------------------------------
*/

include __DIR__ . '/../../pages/dependencias/edit.php';