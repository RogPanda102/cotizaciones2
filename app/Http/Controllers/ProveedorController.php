<?php

namespace App\Http\Controllers;

use App\Enums\TipoAlerta;
use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\Empresa;
use App\Models\Departamento;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedores = Proveedor::all();

        return view('proveedores.index', array_merge($this->cargar_datos(), compact('proveedores')));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $proveedores = Proveedor::all();
        $empresas = Empresa::all();
        $departamentos = Departamento::all();

        return view('proveedores.create', array_merge(
            $this->cargar_datos2(),
            compact('empresas', 'departamentos', 'proveedores')
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'empresa' => 'required|string|max:255',
            'nombre_contacto' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
        ]);

        Proveedor::create($request->all());
        mensaje('Proovedor Agregado',TipoAlerta::SUCCESS);
        return redirect()->route('proveedores.index');
        
    }
    
    public function edit(Proveedor $proveedor)
    {
        $empresas = Empresa::all();
        $departamentos = Departamento::all();

        return view('proveedores.edit', array_merge(
            $this->cargar_datos3(),
            compact(
                'proveedor',
                'empresas',
                'departamentos'
            )
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proveedor $proveedor)
    {
        $request->validate([
            'empresa' => 'required|string|max:255',
            'nombre_contacto' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
        ]);

        $proveedor->update(
            $request->only([
                'empresa',
                'nombre_contacto',
                'telefono',
                'email'
            ])
        );
        mensaje('El Proveedor Ha Sido Actualizado', TipoAlerta::SUCCESS);
        return redirect()
            ->route('proveedores.index');
    }

    //ESTA FUNCION CONTROLA EL BREADCRUMB DEL PROGRAMA
    private function cargar_datos()
    {
        $datos = array();
        $datos['nombre_pagina'] = '';
        $datos['tarea'] = 'Proveedores';

        $breadcrumb = array
        (
            array
            (
                'tarea' => 'Proveedores',
                'href' => '#'
            )
        );
        $datos['breadcrumb'] = breadcrumb($datos['tarea'], $breadcrumb);
        return $datos;
    }
    //ESTA FUNCION CONTROLA EL BREADCRUMB DEL PROGRAMA
    //ESTA FUNCION CONTROLA EL BREADCRUMB DEL PROGRAMA
    private function cargar_datos2()
    {
        $datos = array();
        $datos['nombre_pagina'] = '';
        $datos['tarea'] = 'Nuevo Proveedor';

        $breadcrumb = array
        (
            array
            (
                'tarea' => 'Proveedores',
                'href' => route('proveedores.index')
            ),
                        array
            (
                'tarea' => 'Nuevo Proveedor',
                'href' => '#'
            )
        );
        $datos['breadcrumb'] = breadcrumb($datos['tarea'], $breadcrumb);
        return $datos;
    }
    //ESTA FUNCION CONTROLA EL BREADCRUMB DEL PROGRAMA
    private function cargar_datos3()
    {
        $datos = [];
        $datos['nombre_pagina'] = '';
        $datos['tarea'] = 'Editar Proveedor';
        $breadcrumb = [
            [
                'tarea' => 'Proveedores',
                'href' => route('proveedores.index')
            ],
            [
                'tarea' => 'Editar Proveedor',
                'href' => '#'
            ]
        ];
        $datos['breadcrumb'] = breadcrumb(
            $datos['tarea'],
            $breadcrumb
        );
        return $datos;
    }

    public function destroy(Proveedor $proveedor)
    {
        // ESTA FUNCION VALIDA QUE NO SE ELIMINE UNA PROVEEDOR SI EXISTE RELACION CON UN PEDIDO
        if ($proveedor->pedidos()->exists()) {
        mensaje('No puedes eliminar este proveedor porque tiene pedidos relacionados',TipoAlerta::WARNING);
        return redirect()->route('proveedores.index');}
        $proveedor->delete();
        mensaje('Proveedor eliminado correctamente',TipoAlerta::SUCCESS);
        return redirect()->route('proveedores.index');
    }
}