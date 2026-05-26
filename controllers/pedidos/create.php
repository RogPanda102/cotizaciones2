<?php

    require_once '../../config/database.php';

    $query = $conexion->query("SELECT * FROM empresas");
    $empresas = $query->fetchAll(PDO::FETCH_OBJ);

    $query2 = $conexion->query("SELECT * FROM proveedores");
    $proveedores = $query2->fetchAll(PDO::FETCH_OBJ);

    include '../../pages/pedidos/create.php';