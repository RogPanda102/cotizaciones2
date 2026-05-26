<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompraRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'pedido_id' => 'required|exists:pedidos,id',
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha' => 'required|date',
            'cantidad' => 'required|integer|min:1',
            'unidad' => 'required|string|max:50',
            'descripcion' => 'required|string|max:1000',
            'monto' => 'required|numeric|min:0',
        ];
    }
}
