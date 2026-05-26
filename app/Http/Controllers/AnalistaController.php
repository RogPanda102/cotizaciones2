<?php

namespace App\Http\Controllers;

use App\Models\Analista;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnalistaController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'apellido_paterno' => ['required', 'string', 'max:255'],
            'apellido_materno' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:analistas,email'],
            'telefono' => ['nullable', 'string', 'max:50'],
        ]);

        $analista = Analista::create([
            'nombre' => $validated['nombre'],
            'apellido_paterno' => $validated['apellido_paterno'],
            'apellido_materno' => $validated['apellido_materno'] ?? null,
            'email' => $validated['email'] ?? null,
            'telefono' => $validated['telefono'] ?? null,
        ]);

        $displayName = trim(collect([
            $analista->nombre,
            $analista->apellido_paterno,
            $analista->apellido_materno,
        ])->filter()->join(' '));

        return response()->json([
            'id' => $analista->id,
            'nombre' => $displayName,
        ], 201);
    }
}
