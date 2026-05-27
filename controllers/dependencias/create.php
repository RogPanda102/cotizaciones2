<?php

/*
|--------------------------------------------------------------------------
| DATOS GENERALES
|--------------------------------------------------------------------------
*/
require_once __DIR__ . '/../../app/Enums/TipoAlerta.php';
use App\Enums\TipoAlerta;

$nombre_pagina = '';

$tarea = 'Crear dependencia';

$breadcrumb_array = [
    [
        'tarea' => 'Dependencias',
        'href' => route('dependencias.index')
    ],
    [
        'tarea' => 'Crear dependencia',
        'href' => '#'
    ]
];



$breadcrumb = breadcrumb($tarea, $breadcrumb_array);

include __DIR__ . '/../../pages/dependencias/create.php';