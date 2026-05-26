<?php

namespace App\Http\Controllers;
use App\Models\Departamento;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class DepartamentoController extends Controller
{
    public function buscar(Request $request)
    {
        $email = $request->email ? trim(strtolower($request->email)) : null;
        $telefono = $request->telefono ? preg_replace('/\D/', '', $request->telefono) : null;

        $departamento = null;

        if ($email) {
            $departamento = Departamento::whereRaw('LOWER(email) = ?', [$email])->first();
        }

        if (!$departamento && $telefono) {
            $departamento = Departamento::whereRaw("REGEXP_REPLACE(telefono, '[^0-9]', '') = ?", [$telefono])->first();
        }

        return response()->json($departamento); // 👈 CLAVE
    }
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
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'dependencia_id' => ['nullable', 'exists:dependencias,id'],
            'nombre_departamento' => ['required', 'string', 'max:255'],
            'responsable' => ['nullable', 'string', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'direccion' => ['nullable', 'string', 'max:255'],
        ]);

        $departamento = Departamento::create([
            'dependencia_id' => $validated['dependencia_id'] ?? null,
            'nombre_departamento' => trim($validated['nombre_departamento']),
            'responsable' => $validated['responsable'] ?? null,
            'telefono' => $validated['telefono'] ?? null,
            'email' => isset($validated['email']) ? strtolower(trim($validated['email'])) : null,
            'direccion' => $validated['direccion'] ?? null,
        ]);

        return response()->json([
            'id' => $departamento->id,
            'nombre' => $departamento->nombre_departamento,
        ], 201);
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
