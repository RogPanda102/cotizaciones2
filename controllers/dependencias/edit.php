<?php

require_once __DIR__ . '/../../config/database.php';

$id = $_GET['id'] ?? null;

if(!$id) {

    die('ID no recibido');

}

$sql = "
    SELECT *
    FROM dependencias
    WHERE id = :id
";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':id' => $id
]);

$dependencia = $stmt->fetch(PDO::FETCH_OBJ);

if(!$dependencia) {

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


include __DIR__ . '/../../pages/dependencias/edit.php';