<?php

use App\Enums\TipoAlerta;

require_once __DIR__ . '/../../config/app.php';
require_once __DIR__ . '/../../config/database.php';

$sql = "SELECT * FROM empresas ORDER BY nombre ASC";

$stmt = $pdo->query($sql);
$empresas = $stmt->fetchAll(PDO::FETCH_OBJ);

$nombre_pagina = '';
$tarea = 'Selecciona una empresa';

$breadcrumb_array = [
    [
        'tarea' => 'Inicio',
        'href' => '#'
    ]
];

$breadcrumb = breadcrumb($tarea, $breadcrumb_array);

// mensaje('Pedro que gusto de verTE',TipoAlerta::SUCCESS); 
// ES UN EJEMPLO DE UN MENSAJE

include __DIR__ . '/../../pages/empresas/index.php';