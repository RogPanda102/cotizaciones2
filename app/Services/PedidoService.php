<?php

namespace App\Services;

use App\Models\Pedido;
use App\Enums\EstadoPedido;
use App\Models\PedidoServicio;
use App\Models\PedidoLicencia;
use Illuminate\Support\Facades\DB;

class PedidoService
{

    public function crearPedido(array $data): Pedido
    {
        return DB::transaction(function () use ($data) {

            // Validación de seguridad (opcional pero pro)
            if (empty($data['departamento_id'])) {
                throw new \Exception('Debe seleccionar o crear un departamento.');
            }
            // asignar departamento al pedido

            $data['estado'] = EstadoPedido::EN_PROCESO;

            $pedidoData = collect($data)->only([
                'cotizacion_id',
                'dependencia_id',
                'empresa_id',
                'analista_id',
                'departamento_id',
                'proveedor_id',
                'lugar_entrega',
                'condiciones_entrega',
                'monto_total_aprobado',
                'fecha_adjudicacion',
                'dias_entrega',
                'tipo_dias',
                'dias_credito',
                'tipo',
                'estado'
            ])->toArray();

            $pedido = Pedido::create($pedidoData);

            $pedido->historialEstados()->create([
                'estado' => $pedido->estado
            ]);
            
            switch ($data['tipo']) {
                case 'servicio':
                    
                    $this->crearServicio($pedido, $data);
                    break;

                case 'licencia':
                    $this->crearLicencia($pedido, $data);
                    break;

                case 'mercadeo':
                    // no requiere nada extra
                    break;
            }

            return $pedido;
        });
    }

    private function crearServicio(Pedido $pedido, array $data): void
    {
        PedidoServicio::create([
            'pedido_id' => $pedido->id,
            'descripcion_servicio' => $data['descripcion_servicio'] ?? null,
            'alcance' => $data['alcance'] ?? null,
            'responsable' => $data['responsable'] ?? null,
            'entregables' => $data['entregables'] ?? null,
            'costo_servicio' => $data['costo_servicio'] ?? null,
            'observaciones' => $data['observaciones'] ?? null,
            'fecha_inicio' => $data['fecha_inicio'] ?? null,
            'fecha_fin' => $data['fecha_fin'] ?? null,
        ]);
    }

    private function crearLicencia(Pedido $pedido, array $data): void
    {
        PedidoLicencia::create([
            'pedido_id' => $pedido->id,
            'nombre_licencia' => $data['nombre_licencia'] ?? null,
            'tipo_licencia' => $data['tipo_licencia'] ?? null,
            'numero_usuarios' => $data['numero_usuarios'] ?? null,
            'costo_licencia' => $data['costo_licencia'] ?? null,
            'costo_renovacion' => $data['costo_renovacion'] ?? null,
            'fecha_inicio' => $data['fecha_inicio'] ?? null,
            'fecha_fin' => $data['fecha_fin'] ?? null,
        ]);
    }

    public function actualizarPedido(Pedido $pedido, array $data): Pedido
    {
        $nuevoEstado = EstadoPedido::from($data['estado']);
        $estadoActual = $pedido->estado;

        if ($estadoActual->esFinal()) {
            throw new \Exception('El pedido ya está pagado y no puede modificarse.');
        }

        // Validar transición de estado
        if (!$estadoActual->puedeCambiarA($nuevoEstado) && $estadoActual !== $nuevoEstado) {
            throw new \Exception("No se puede cambiar el estado de {$estadoActual->label()} a {$nuevoEstado->label()}.");
        }

        // Regla de negocio
        if ($nuevoEstado->requiereFechaFacturacion() && empty($data['fecha_facturacion'])) {
            throw new \Exception('Debe indicar la fecha de facturación cuando el pedido está facturado.');
        }

        if (!$nuevoEstado->requiereFechaFacturacion()) {
            $data['fecha_facturacion'] = null;
        }

        $pedido->update($data);

        if ($estadoActual !== $nuevoEstado) {
            $pedido->historialEstados()->create([
                'estado' => $nuevoEstado
            ]);
        }

        return $pedido;
    }
}