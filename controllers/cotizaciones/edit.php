<?php

require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/CotizacionModel.php';

$model = new CotizacionModel($pdo);
/*
|---------------------------------------------------------
| VALIDAR ID 
|---------------------------------------------------------
*/
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: /cotizaciones2/cotizaciones");
    exit;
}

/*
|---------------------------------------------------------
| OBTENER COTIZACION
|---------------------------------------------------------
*/

$cotizacion = $model->getById($id);

/*
|---------------------------------------------------------
| SI NO EXISTE
|---------------------------------------------------------
*/
if (!$cotizacion) {
    header("Location: /cotizaciones2/cotizaciones");
    exit;
}

/*
|---------------------------------------------------------
| GET FORM DATA (equivalente getFormData())
|---------------------------------------------------------
*/
$formData = $model->getFormData();

$empresas = $formData['empresas'];
$dependencias = $formData['dependencias'];
$departamentos = $formData['departamentos'];
$analistas = $formData['analistas'];

/*
|---------------------------------------------------------
| DATOS DE VISTA (equivalente $datos en Laravel)
|---------------------------------------------------------
*/
$nombre_pagina = '';
$tarea = 'Editar cotizacion';

$breadcrumb_array = [
    [
        'tarea' => 'Cotizaciones',
        'href' => '/cotizaciones2/cotizaciones'
    ],
    [
        'tarea' => 'Editar cotizacion',
        'href' => '#'
    ]
];

$breadcrumb = breadcrumb($tarea, $breadcrumb_array);

/*
|---------------------------------------------------------
| VISTA
|---------------------------------------------------------
*/
include __DIR__ . '/../../pages/cotizaciones/edit.php';