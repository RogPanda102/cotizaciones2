<?php

namespace App\Http\Controllers;

use App\Enums\TipoAlerta;
use Illuminate\Http\Request;
use App\Models\Dependencia;

class DependenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dependencias = Dependencia::all();
        $datos = $this->cargarDatos(
            'Dependencias',
            [
                [
                    'tarea' => 'Dependencias',
                    'href' => '#',
                ]
            ]
        );
        return view('dependencias.index', array_merge($datos, compact('dependencias')));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $datos = $this->cargarDatos(
            'Crear dependenciass',
            [
                [
                    'tarea' => 'Dependencias',
                    'href' => route('dependencias.index'),
                ],
                [
                    'tarea' => 'Crear dependencia',
                    'href' => '#',
                ]
            ]
        );
        return view('dependencias.create', $datos);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_oficial' => 'required|string|max:255',
            'nombre_corto' => 'nullable|string|max:255',
        ]);

        Dependencia::create(
            $request->only([
                'nombre_oficial',
                'nombre_corto',
            ])
        );
        mensaje('La dependencia ha sido creada', TipoAlerta::SUCCESS);
        return redirect()->route('dependencias.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dependencia $dependencia)
    {
        $datos = $this->cargarDatos(
            'Editar dependencia',
            [
                [
                    'tarea' => 'Dependencias',
                    'href' => route('dependencias.index'),
                ],
                [
                    'tarea' => 'Editar dependencia',
                    'href' => '#',
                ]
            ]
        );

        return view('dependencias.edit', array_merge($datos, compact('dependencia')));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dependencia $dependencia)
    {
        $request->validate([
            'nombre_oficial' => 'required|string|max:255',
            'nombre_corto'   => 'nullable|string|max:255',
        ]);

        $dependencia->update($request->only(['nombre_oficial', 'nombre_corto']));
        mensaje('Dependencia actualizada',TipoAlerta::SUCCESS);
        return redirect()->route('dependencias.index');
    }

    private function cargarDatos(string $tarea, array $breadcrumb)
    {
        return [
            'nombre_pagina' => '',
            'tarea' => $tarea,
            'breadcrumb' => breadcrumb($tarea, $breadcrumb),
        ];
    }

public function destroy(Dependencia $dependencia)
{
    // ESTA FUNCION VALIDA QUE NO SE ELIMINE UNA DEPENDENCIA SI EXISTE RELACION CON UN PEDIDO
    if ($dependencia->pedidos()->exists()) 
    {
        mensaje(
            'No puedes eliminar esta dependencia porque tiene pedidos relacionados',
            TipoAlerta::WARNING
        );
        return redirect()
            ->route('dependencias.index');
    }
    $dependencia->delete();
    mensaje(
        'Dependencia eliminada',
        TipoAlerta::SUCCESS
    );
    return redirect()
        ->route('dependencias.index');
    }

}
