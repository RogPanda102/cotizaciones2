<?php

namespace App\Services;

use App\Models\Cotizacion;
use App\Enums\EstadoCotizacion;
use Illuminate\Support\Facades\DB;

class CotizacionService
{
    public function crearCotizacion(array $data): Cotizacion
    {
        return DB::transaction(function () use ($data) {

            $this->validarDatosBase($data);
            $data = $this->normalizarCampos($data);

            $data = $this->aplicarReglasPorTipo($data);
            $data = $this->aplicarReglasPorEstado($data);
           

            $cotizacion = Cotizacion::create($this->filtrarCampos($data));

            return $cotizacion;
        });  
    }
    public function actualizarCotizacion(Cotizacion $cotizacion, array $data): Cotizacion
    {
        return DB::transaction(function () use ($cotizacion, $data) {
            $contextoValidacion = array_merge($cotizacion->toArray(), $data);
            $this->validarDatosBase($contextoValidacion);

            $data = $this->normalizarCampos($data, $cotizacion->toArray());
            $data = $this->aplicarReglasPorTipo($data, $cotizacion);
            $data = $this->aplicarReglasPorEstado($data);

            $cotizacion->update($this->filtrarCampos($data));

            return $cotizacion;
        });
    }

    // =========================
    // 🔹 REGLAS DE NEGOCIO
    // =========================

    private function validarDatosBase(array $data): void
    {
        if (empty($data['empresa_id'])) {
            throw new \Exception('Debe seleccionar una empresa.');
        }
    }

    private function normalizarCampos(array $data, array $base = []): array
    {
        foreach (['horario_de_entrega', 'lugar_de_entrega'] as $campo) {
            if (!array_key_exists($campo, $data)) {
                $data[$campo] = $base[$campo] ?? null;
            }
        }

        return $data;
    }

    private function aplicarReglasPorTipo(array $data, ?Cotizacion $cotizacion = null): array
    {
        $tipo = $data['tipo_cotizacion'] ?? $cotizacion?->tipo_cotizacion;

        if (!$tipo) {
            throw new \Exception('Tipo de cotización inválido.');
        }
        switch ($tipo) {
            case 'omg':
                if (empty($data['analista_id'])) {
                    throw new \Exception('OMG requiere analista.');
                }
                break;

            case 'dependencia_directa':
                $data['analista_id'] = null;
                $data = $this->limpiarCamposFinancieros($data);
                break;

            case 'cliente_externo':
                $data['analista_id'] = null;
                $data['dependencia_id'] = null;
                $data['departamento_id'] = null;
                $data['lugar_de_entrega'] = null;
                $data['horario_de_entrega'] = null;
                $data = $this->limpiarCamposFinancieros($data);
                break;
        }

        return $data;
    }

    private function aplicarReglasPorEstado(array $data): array
    {
        if (!isset($data['estado'])) {
            return $data;
        }
        // 🔥 Regla 1: no cotiza → no hay monto
        if ($data['estado'] === EstadoCotizacion::NO_COTIZA->value) {
            $data['monto_total'] = null;
        }

        // 🔥 Regla 2: enviada → debe tener fecha_envio
        if ($data['estado'] === EstadoCotizacion::ENVIADO->value) {
            if (empty($data['fecha_envio'])) {
                throw new \Exception('Debe indicar la fecha de envío.');
            }
        }

        if ($data['estado'] !== EstadoCotizacion::ENVIADO->value) {
            $data['fecha_envio'] = null;
        }

        return $data;
    }

    private function limpiarCamposFinancieros(array $data): array
    {
        $data['dias_credito'] = null;
        $data['tipo_dias'] = null;

        return $data;
    }

    private function filtrarCampos(array $data): array
    {
        return collect($data)->only([
            'departamento_id',
            'dependencia_id',
            'empresa_id',
            'analista_id', // se queda en dependencia directa y debe ser editable
            'folio_externo',
            'numero_cotizacion',
            'fecha_recepcion',
            'fecha_envio',
            'garantia',
            'horario_de_entrega',
            'lugar_de_entrega',
            'monto_total',
            'dias_credito',
            'tipo_dias',
            'tipo_cotizacion',
            'estado',
        ])->toArray();
    }
}