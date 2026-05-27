<?php

use App\Enums\TipoAlerta;

require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../config/database.php';

/*
|--------------------------------------------------------------------------
| DATOS PARA FORMULARIO
|--------------------------------------------------------------------------
*/

$sqlEmpresas = "SELECT id, nombre FROM empresas ORDER BY nombre ASC";
$empresas = $pdo->query($sqlEmpresas)->fetchAll(PDO::FETCH_OBJ);

$sqlDependencias = "SELECT id, nombre_oficial FROM dependencias ORDER BY nombre_oficial ASC";
$dependencias = $pdo->query($sqlDependencias)->fetchAll(PDO::FETCH_OBJ);

$sqlDepartamentos = "SELECT id, nombre_departamento FROM departamentos ORDER BY nombre_departamento ASC";
$departamentos = $pdo->query($sqlDepartamentos)->fetchAll(PDO::FETCH_OBJ);

$sqlAnalistas = "SELECT id, nombre FROM analistas ORDER BY nombre ASC";
$analistas = $pdo->query($sqlAnalistas)->fetchAll(PDO::FETCH_OBJ);

/*
|--------------------------------------------------------------------------
| DATOS GENERALES (equivalente a $datos[])
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