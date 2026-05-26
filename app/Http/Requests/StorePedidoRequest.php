<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\EstadoPedido;

class StorePedidoRequest extends FormRequest
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
        
        $tipo = $this->input('tipo');
        $rules = [
            'cotizacion_id' => 'required|exists:cotizaciones,id',
            'dependencia_id' => 'required|exists:dependencias,id',
            'empresa_id' => 'required|exists:empresas,id',
            'departamento_id' => 'required|exists:departamentos,id',
            'analista_id' => 'nullable|exists:analistas,id',
            'proveedor_id' => 'nullable|exists:proveedores,id',
            'lugar_entrega' => 'nullable|string|max:255',
            'condiciones_entrega' => 'nullable|string',

            'monto_total_aprobado' => 'required|numeric|min:0',
            'fecha_adjudicacion' => 'required|date',
            'dias_entrega' => 'required|integer|min:1',
            'tipo_dias' => 'required|in:naturales,habiles',
            'dias_credito' => 'required|integer|min:0',

            'tipo' => 'required|in:servicio,licencia,mercadeo',
        ];

        // Reglas dinámicas
        if ($tipo === 'licencia') {
            $rules = array_merge($rules, [
                'nombre_licencia' => 'required|string|max:255',
                'tipo_licencia' => 'nullable|string|max:100',
                'numero_usuarios' => 'nullable|integer|min:1',
                'costo_licencia' => 'required|numeric|min:0',
                'costo_renovacion' => 'nullable|numeric|min:0',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            ]);
        }

        if ($tipo === 'servicio') {
            $rules = array_merge($rules, [
                'descripcion_servicio' => 'required|string',
                'alcance' => 'nullable|string',
                'responsable' => 'nullable|string|max:255',
                'entregables' => 'nullable|string',
                'costo_servicio' => 'required|numeric|min:0',
                'observaciones' => 'nullable|string',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            ]);
        }

        return $rules;

    }
    protected function prepareForValidation()
    {
        if ($this->tipo === 'servicio') {
            $this->merge([
                'fecha_inicio' => $this->fecha_inicio_servicio,
                'fecha_fin'    => $this->fecha_fin_servicio,
            ]);
        }

        if ($this->tipo === 'licencia') {
            $this->merge([
                'fecha_inicio' => $this->fecha_inicio_licencia,
                'fecha_fin'    => $this->fecha_fin_licencia,
            ]);
        }
    }
}
