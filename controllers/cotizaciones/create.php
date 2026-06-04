<?php

use App\Enums\TipoAlerta;

require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/CotizacionModel.php';

$model = new CotizacionModel($pdo);
/*
|--------------------------------------------------------------------------
| DATOS PARA FORMULARIO
|--------------------------------------------------------------------------
*/
$formData = $model->getFormData();
$empresas      = $formData['empresas'];
$dependencias  = $formData['dependencias'];
$departamentos = $formData['departamentos'];
$analistas     = $formData['analistas'];
/*
|--------------------------------------------------------------------------
| DATOS GENERALES
|--------------------------------------------------------------------------
*/
$nombre_pagina = '';
$tarea = 'Crear cotización';
$breadcrumb_array = [
    [
        'tarea' => 'Cotizaciones',
        'href' => route('cotizaciones.index')
    ],
    [
        'tarea' => 'Nueva cotización',
        'href' => '#'
    ]
];
$breadcrumb = breadcrumb($tarea, $breadcrumb_array);
/*
|--------------------------------------------------------------------------
| VISTA
|--------------------------------------------------------------------------
*/
include __DIR__ . '/../../pages/cotizaciones/create.php';