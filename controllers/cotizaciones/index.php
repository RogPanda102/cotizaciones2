<?php
use App\Enums\TipoAlerta;
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/CotizacionModel.php';

 $model = new CotizacionModel($pdo);
 $cotizaciones = $model->getAll();
/*
|--------------------------------------------------------------------------
| DATOS GENERALES
|--------------------------------------------------------------------------
*/
$nombre_pagina = '';
$tarea = 'Lista de cotizaciones';
$breadcrumb_array = [

    [
        'tarea' => 'Cotizaciones',
        'href' => '#'
    ]

];
$breadcrumb = breadcrumb($tarea, $breadcrumb_array);
/*
|--------------------------------------------------------------------------
| VISTA
|--------------------------------------------------------------------------
*/
include __DIR__ . '/../../pages/cotizaciones/index.php';