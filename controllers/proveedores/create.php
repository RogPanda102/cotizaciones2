<?php

/*
|--------------------------------------------------------------------------
| DATOS GENERALES
|--------------------------------------------------------------------------
*/
require_once __DIR__ . '/../../app/Enums/TipoAlerta.php';
use App\Enums\TipoAlerta;

$nombre_pagina = '';

$tarea = 'Crear proveedor';

$breadcrumb_array = [
    [
        'tarea' => 'Proveedores',
        'href' => route('proveedores.index')
    ],
    [
        'tarea' => 'Crear proveedor',
        'href' => '#'
    ]
];



$breadcrumb = breadcrumb($tarea, $breadcrumb_array);

include __DIR__ . '/../../pages/proveedores/create.php';