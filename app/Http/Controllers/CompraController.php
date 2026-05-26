<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Compra;
use App\Models\Proveedor;
use App\Http\Requests\StoreCompraRequest;
use App\Http\Requests\UpdateCompraRequest;
use App\Enums\TipoAlerta;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompraRequest $request)
    {
        $pedido = Pedido::findOrFail($request->pedido_id);

        // Bloqueo para edicion
        if (!$pedido->puedeEditarCompras()) {
        return back()->with('error', 'Las compras están bloqueadas para este pedido.');
        // o abort(403);
    }

        Compra::create($request->validated());
        mensaje('Tu compra ha sido registrada',TipoAlerta::SUCCESS);
        return redirect()->route('pedidos.show', $pedido->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Compra $compra)
    {
        $proveedores = Proveedor::all();

        $pedido = $compra->pedido;

        $datos = array();
        $datos['nombre_pagina'] = '';
        $datos['tarea'] = 'Selecciona una empresa';

        $breadcrumb = array
        (
            array
            (
                'tarea' => 'Pedidos',
                'href' => route('empresas.pedidos',$pedido->empresa_id)
            ),
                        array
            (
                'tarea' => 'Detalles',
                'href' => route('pedidos.show', $pedido->id)
            ),
                        array
            (
                'tarea' => 'Editar Compra',
                'href' => '#'
            )
        );
            $datos['breadcrumb'] = breadcrumb($datos['tarea'], $breadcrumb);
            return view('compras.edit', array_merge($datos, compact('compra', 'proveedores')));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompraRequest $request, Compra $compra)
    {

        // Bloqueo
        $pedido = $compra->pedido;

        if (!$pedido->puedeEditarCompras()) {
            abort(403, 'Las compras están bloqueadas.');
        }

        $compra->update($request->validated());
        mensaje('Compra modificada',TipoAlerta::SUCCESS);
        return redirect()->route('pedidos.show', $compra->pedido_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Compra $compra)
    {
        $pedido = $compra->pedido;
        mensaje('Compra Eliminada Correctamente!', TipoAlerta::SUCCESS);

        if (!$pedido->puedeEditarCompras()) {
            abort(403, 'Las compras están bloqueadas.');
        }

        $pedidoId = $compra->pedido_id;
        $compra->delete();

        return redirect()->route('pedidos.show', $pedidoId);
    }

}
