<?php

Router::get('/', 'empresas::index', [
    'as' => 'empresas.index'
]);

// =======================
// DEPENDENCIAS
// =======================
Router::get('/dependencias', 'dependencias::index', [
    'as' => 'dependencias.index'
]);

Router::get('/dependencias/create', 'dependencias::create', [
    'as' => 'dependencias.create'
]);

Router::post('/dependencias/store', 'dependencias::store', [
    'as' => 'dependencias.store'
]);

Router::get('/dependencias/edit', 'dependencias::edit', [
    'as' => 'dependencias.edit'
]);

Router::post('/dependencias/update', 'dependencias::update', [
    'as' => 'dependencias.update'
]);

Router::post('/dependencias/delete', 'dependencias::delete', [
    'as' => 'dependencias.delete'
]);

// =======================
// COTIZACIONES
// =======================
Router::get('/cotizaciones', 'cotizaciones::index', [
    'as' => 'cotizaciones.index'
]);

Router::get('/cotizaciones/create', 'cotizaciones::create', [
    'as' => 'cotizaciones.create'
]);

Router::post('/cotizaciones/store', 'cotizaciones::store', [
    'as' => 'cotizaciones.store'
]);

Router::get('/cotizaciones/edit', 'cotizaciones::edit', [
    'as' => 'cotizaciones.edit'
]);

Router::post('/cotizaciones/update', 'cotizaciones::update', [
    'as' => 'cotizaciones.update'
]);

// =======================
// PEDIDOS
// =======================
Router::get('/pedidos', 'pedidos::index', [
    'as' => 'pedidos.index'
]);

Router::get('/pedidos/create', 'pedidos::create', [
    'as' => 'pedidos.create'
]);

Router::post('/pedidos/store', 'pedidos::store', [
    'as' => 'pedidos.store'
]);

Router::get('/empresas/pedidos', 'pedidos::porEmpresa', [
    'as' => 'empresas.pedidos'
]);

// =======================
// COMPRAS
// =======================
Router::get('/compras', 'compras::index', [
    'as' => 'compras.index'
]);

Router::get('/compras/create', 'compras::create', [
    'as' => 'compras.create'
]);

Router::post('/compras/store', 'compras::store', [
    'as' => 'compras.store'
]);

// =======================
// PROVEEDORES
// =======================
Router::get('/proveedores', 'proveedores::index', [
    'as' => 'proveedores.index'
]);

Router::get('/proveedores/create', 'proveedores::create', [
    'as' => 'proveedores.create'
]);

Router::post('/proveedores/store', 'proveedores::store', [
    'as' => 'proveedores.store'
]);

// =======================
// EMPRESAS
// =======================
Router::get('/empresas', 'empresas::index', [
    'as' => 'empresas.index'
]);

// =======================
// ANALISTAS
// =======================
Router::post('/analistas', 'analistas::store', [
    'as' => 'analistas.store'
]);

// =======================
// DEPARTAMENTOS
// =======================
Router::get('/departamentos/buscar', 'departamentos::buscar', [
    'as' => 'departamentos.buscar'
]);

Router::post('/departamentos', 'departamentos::store', [
    'as' => 'departamentos.store'
]);