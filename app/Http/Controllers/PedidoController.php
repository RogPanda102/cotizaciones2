<?php

namespace App\Http\Controllers;

use App\Enums\TipoAlerta;
use App\Http\Requests\UpdatePedidoRequest;
use App\Http\Requests\StorePedidoRequest;
use App\Models\Pedido;
use App\Models\Dependencia;
use App\Services\PedidoService;
use App\Models\Empresa;
use App\Models\Departamento;
use App\Models\Cotizacion;
use App\Models\Proveedor;
use App\Models\Analista;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private $pedidoService;

    public function __construct(PedidoService $pedidoService)
    {
        $this->pedidoService = $pedidoService;
    }

    public function index()
    {
        
        return redirect()->route('empresas.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cotizaciones = Cotizacion::all();
        $empresas = Empresa::all(); // revisar posible redundancia
        $proveedores = Proveedor::all();
        $analistas = Analista::all();
        $empresaId = request('empresa_id');
        $empresa = Empresa::findOrFail($empresaId);
        $dependencias = Dependencia::with([
            'departamentos:id,dependencia_id,nombre_departamento,responsable'
        ])->get();

        $datos = array();
        $datos['nombre_pagina'] = '';
        $datos['tarea'] = $empresa->nombre; //ESCRIBIR AQUI NOMBRE DE LA EMPRESA

        $breadcrumb = array
        (
            array
            (
                'tarea' => 'Pedidos',
                'href' => route('empresas.pedidos',$empresaId)
            ),
            array
            (
                'tarea' => 'Crear pedido',
                'href' => '#'
            )
        );
        $datos['breadcrumb'] = breadcrumb($datos['tarea'], $breadcrumb);
        return view('pedidos.create', array_merge($datos, compact('cotizaciones', 'dependencias', 'empresas', 'proveedores', 'analistas', 'empresaId')));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePedidoRequest $request)
    {
        //dd($request->all());
        $pedido = $this->pedidoService->crearPedido(
            $request->validated()
        );
        mensaje('Tu pedido ha sido creado',TipoAlerta::SUCCESS);
        return redirect()->route('empresas.pedidos', $pedido->empresa_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pedido $pedido)
    {
        $pedido->load(['compras.proveedor', 'historialEstados']);
        $proveedores = Proveedor::all();

        $datos = array();
        $datos['nombre_pagina'] = '';
        $datos['tarea'] = $pedido->empresa->nombre; //ESCRIBIR AQUI NOMBRE DE LA EMPRESA

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
                'href' => '#'
            )
        );
        $datos['breadcrumb'] = breadcrumb($datos['tarea'], $breadcrumb);

        return view('pedidos.show', array_merge($datos, compact('pedido', 'proveedores')));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pedido $pedido)
    {
        $cotizaciones = Cotizacion::all();

        $empresas = Empresa::all();

        $proveedores = Proveedor::all();

        $analistas = Analista::all();

        $dependencias = Dependencia::with([
            'departamentos:id,dependencia_id,nombre_departamento,responsable'
        ])->get();

        return view('pedidos.edit', compact(
            'pedido',
            'cotizaciones',
            'empresas',
            'proveedores',
            'analistas',
            'dependencias'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePedidoRequest $request, Pedido $pedido, PedidoService $pedidoService)
    {
        $validated = $request->validated();

        try {

            $pedidoService->actualizarPedido($pedido, $validated);

        } catch (\Exception $e) {

            return back()
                ->withErrors(['fecha_facturacion' => $e->getMessage()])
                ->withInput();
        }

        mensaje('El estado ha sido modificado',TipoAlerta::WARNING);
        return redirect()->route('pedidos.show', $pedido->id);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pedido $pedido)
    {
        $pedido->delete();
        mensaje('Pedido Eliminado Correctamente!', TipoAlerta::SUCCESS);
        return redirect()->route('empresas.pedidos', $pedido->empresa_id);
    }

    public function porEmpresa($empresaId=0)
    {
        $empresa = Empresa::findOrFail($empresaId);
        $pedidos = Pedido::where('empresa_id', $empresaId)
            ->with(['cotizacion', 'dependencia'])
            ->latest()
            ->paginate(10);
            
        $datos = array();
        $datos['nombre_pagina'] = '';
        $datos['tarea'] = $empresa->nombre; //ESCRIBIR AQUI NOMBRE DE LA EMPRESA

        $breadcrumb = array
        (
            array
            (
                'tarea' => 'Pedidos',
                'href' => '#'
            ),
        );
        $datos['breadcrumb'] = breadcrumb($datos['tarea'], $breadcrumb);

        return view('pedidos.index', array_merge($datos, compact('pedidos', 'empresa')));
    }








}
