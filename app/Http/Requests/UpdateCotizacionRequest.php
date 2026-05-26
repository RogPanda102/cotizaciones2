<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCotizacionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'departamento_id' => ['nullable', 'exists:departamentos,id'],
            'dependencia_id' => ['nullable', 'exists:dependencias,id'],
            'empresa_id' => ['sometimes', 'exists:empresas,id'],

            'analista_id' => ['nullable', 'exists:analistas,id'],

            'folio_externo' => ['nullable', 'string', 'max:255'],
            'numero_cotizacion' => ['nullable', 'digits_between:1,6'],

            'fecha_recepcion' => ['nullable', 'date'],
            'fecha_envio' => ['nullable', 'date'],

            'garantia' => ['nullable', 'integer', 'min:0'],
            'monto_total' => ['nullable', 'numeric', 'min:0'],

            'dias_credito' => ['nullable', 'integer', 'min:0'],

            'tipo_dias' => ['nullable', 'in:naturales,habiles'],

            'tipo_cotizacion' => [
                'sometimes',
                'in:omg,dependencia_directa,cliente_externo'
            ],

            'estado' => [
                'sometimes',
                'in:enviado,respaldo,no_cotiza'
            ],
        ];
    }
}
