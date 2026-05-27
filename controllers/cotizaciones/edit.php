<?php

require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../config/database.php';

/*
|---------------------------------------------------------
| VALIDAR ID (equivalente Route Model Binding Laravel)
|---------------------------------------------------------
*/
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: /cotizaciones2/cotizaciones");
    exit;
}

/*
|---------------------------------------------------------
| OBTENER COTIZACION (equivalente Cotizacion::with())
|---------------------------------------------------------
*/
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

    WHERE cotizaciones.id = :id
    LIMIT 1
";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();

$cotizacion = $stmt->fetch(PDO::FETCH_OBJ);

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
$sqlEmpresas = "SELECT * FROM empresas";
$sqlDependencias = "SELECT * FROM dependencias";
$sqlDepartamentos = "SELECT * FROM departamentos";
$sqlAnalistas = "SELECT * FROM analistas";

$empresas = $pdo->query($sqlEmpresas)->fetchAll(PDO::FETCH_OBJ);
$dependencias = $pdo->query($sqlDependencias)->fetchAll(PDO::FETCH_OBJ);
$departamentos = $pdo->query($sqlDepartamentos)->fetchAll(PDO::FETCH_OBJ);
$analistas = $pdo->query($sqlAnalistas)->fetchAll(PDO::FETCH_OBJ);

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