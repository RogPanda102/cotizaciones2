<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cotizacion;
use App\Enums\EstadoCotizacion;
use App\Enums\TipoAlerta;
use App\Http\Requests\StoreCotizacionRequest;
use App\Http\Requests\UpdateCotizacionRequest;
use App\Services\CotizacionService;

class CotizacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datos = $this->cargar_datos();
        $cotizaciones = Cotizacion::with([
            'empresa',
            'dependencia',
            'departamento',
            'analista',
            'pedido'
        ])->latest()->get();
        return view('cotizaciones.index', array_merge($datos, compact('cotizaciones')));
    }

    private function getFormData(): array
    {
        return [
            'empresas' => \App\Models\Empresa::all(),
            'dependencias' => \App\Models\Dependencia::all(),
            'departamentos' => \App\Models\Departamento::all(),
            'analistas' => \App\Models\Analista::all(),
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        $datos = array();
        $datos['nombre_pagina'] = '';
        $datos['tarea'] = 'Crear cotizacion';

        $breadcrumb = array
        (
            array
            (
                'tarea' => 'Cotizaciones',
                'href' => route('cotizaciones.index')
            ),
            array
            (
                'tarea' => 'Nueva cotizacion',
                'href' => '#'
            )
        );
        $datos['breadcrumb'] = breadcrumb($datos['tarea'], $breadcrumb);

        return view('cotizaciones.create', $this->getFormData(), $datos);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCotizacionRequest $request, CotizacionService $service)
    {
        $cotizacion = $service->crearCotizacion($request->validated());

        mensaje('La cotizacion ha sido creada correctamente', TipoAlerta::SUCCESS);
        return redirect()
            ->route('cotizaciones.index', $cotizacion);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cotizacion $cotizacion)
    {
        $cotizacion->load([
            'empresa',
            'dependencia',
            'departamento',
            'analista',
            'pedido'
        ]);
        return redirect()->route('cotizaciones.index');
    } 

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cotizacion $cotizacion)
    {
        $datos = array();
        $datos['nombre_pagina'] = '';
        $datos['tarea'] = 'Editar cotizacion';

        $breadcrumb = array
        (
            array
            (
                'tarea' => 'Cotizaciones',
                'href' => route('cotizaciones.index')
            ),
            array
            (
                'tarea' => 'Editar Cotizacion',
                'href' => '#'
            )
        );
        $datos['breadcrumb'] = breadcrumb($datos['tarea'], $breadcrumb);
        
        return view('cotizaciones.edit', array_merge($datos, $this->getFormData(),['cotizacion' => $cotizacion]));
    } 

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCotizacionRequest $request, Cotizacion $cotizacion, CotizacionService $service)
    {
        $data = $request->validated();

        
        $cotizacion = $service->actualizarCotizacion($cotizacion, $data);

        mensaje('Cotizacion Actualizada', TipoAlerta::SUCCESS);
        return redirect()
            ->route('cotizaciones.index', $cotizacion);
    } 

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cotizacion $cotizacion)
    {
        // ESTA FUNCION VALIDA QUE NO SE ELIMINE UNA COTIZACION SI EXISTE RELACION CON UN PEDIDO
        if ($cotizacion->pedido) {

            mensaje('No puedes eliminar esta cotización porque tiene un pedido relacionado',TipoAlerta::WARNING);
            return redirect()->route('cotizaciones.index');
        }
        $cotizacion->delete();
        mensaje(
            'Cotización eliminada correctamente',
            TipoAlerta::SUCCESS
        );
        return redirect()->route('cotizaciones.index');
    }

    //ESTA FUNCION CONTROLA EL BREADCRUMB//
    private function cargar_datos()
    {
        $datos = array();
        $datos['nombre_pagina'] = '';
        $datos['tarea'] = 'Lista de cotizaciones';

        $breadcrumb = array
        (
            array
            (
                'tarea' => 'Cotizaciones',
                'href' => '#'
            )
        );
        $datos['breadcrumb'] = breadcrumb($datos['tarea'], $breadcrumb);
        return $datos;
    }
    //ESTA FUNCION CONTROLA EL BREADCRUMB//
}
