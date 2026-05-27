<?php
use App\Enums\TipoAlerta;
require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../config/database.php';


$sql = "
    SELECT
        cotizaciones.*,

        empresas.nombre AS empresa_nombre,
        dependencias.nombre_oficial AS dependencia_nombre,
        departamentos.nombre_departamento AS departamento_nombre,
        analistas.nombre AS analista_nombre

    FROM cotizaciones

    LEFT JOIN empresas
        ON empresas.id = cotizaciones.empresa_id

    LEFT JOIN dependencias
        ON dependencias.id = cotizaciones.dependencia_id

    LEFT JOIN departamentos
        ON departamentos.id = cotizaciones.departamento_id

    LEFT JOIN analistas
        ON analistas.id = cotizaciones.analista_id

    ORDER BY cotizaciones.id DESC
";



$stmt = $pdo->query($sql);

$cotizaciones = $stmt->fetchAll(PDO::FETCH_OBJ);

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