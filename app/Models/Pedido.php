<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\EstadoPedido;
use Carbon\Carbon;

class Pedido extends Model
{

    protected $casts = [
        'estado' => EstadoPedido::class,
        'fecha_adjudicacion' => 'date',
        'fecha_entrega' => 'date',
        'fecha_facturacion' => 'date',
        'dias_entrega' => 'integer',
        'fecha_pago' => 'date',
    ];

    protected $fillable = [
        'cotizacion_id',
        'dependencia_id',
        'empresa_id',
        'analista_id',
        'departamento_id',
        'proveedor_id',
        'lugar_entrega',
        'condiciones_entrega',
        'tipo',
        'monto_total_aprobado',
        'fecha_adjudicacion',
        'fecha_facturacion',
        'tipo_dias',
        'dias_credito',
        'dias_entrega',
        'estado'
    ];

    // Relaciones principales
    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class);
    }

    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class);
    }

    public function compras()
    {
        return $this->hasMany(Compra::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    // Relaciones por tipo de pedido

    public function servicio()
    {
        return $this->hasOne(PedidoServicio::class);
    }

    public function licencia()
    {
        return $this->hasOne(PedidoLicencia::class);
    }
    // Relacion para historial de estados
    public function historialEstados()
    {
        return $this->hasMany(PedidoEstado::class)->orderBy('created_at');
    }

    // Total gastado en compras | resultado para pedidos/tabs/compras
    public function totalGastado()
    {
        return match($this->tipo) {

            'mercadeo' => $this->compras->sum(function ($compra) {
                return $compra->cantidad * $compra->monto;
            }),

            'servicio' => $this->servicio->costo_servicio ?? 0,

            'licencia' => $this->licencia->costo_licencia ?? 0,

            default => 0,
        };
    }

    // Utilidad del pedido, calcula si hay ganancia
    public function utilidad()
    {
        return $this->monto_total_aprobado - $this->totalGastado();
    }

    // Indica si hubo pérdida
    public function tienePerdida()
    {
        return $this->utilidad() < 0;
    }

    protected static function booted()
    {
        static::saving(function ($pedido) {

            if (
                $pedido->fecha_adjudicacion &&
                $pedido->dias_entrega &&
                (
                    $pedido->isDirty('fecha_adjudicacion') ||
                    $pedido->isDirty('dias_entrega')
                )
            ) {

                $fecha = Carbon::parse($pedido->fecha_adjudicacion);
                $dias = $pedido->dias_entrega;

                if ($pedido->tipo_dias === 'naturales') {

                    $pedido->fecha_entrega = $fecha->copy()->addDays($dias);

                } else {

                    $agregados = 0;

                    while ($agregados < $dias) {
                        $fecha->addDay();

                        if (!$fecha->isWeekend()) {
                            $agregados++;
                        }
                    }

                    $pedido->fecha_entrega = $fecha;
                }
            }

            if (
            $pedido->estado->esFinal() &&
            $pedido->isDirty('estado')
            ) {

                $pedido->fecha_pago = now();

                if ($pedido->fecha_entrega) {

                    $diferencia = now()->diffInDays($pedido->fecha_entrega, false);

                    $pedido->dias_retraso = $diferencia < 0
                        ? abs($diferencia)
                        : 0;
                }
            }
        });
    }
    // Método para calcular los dias restantes para la entrega en compras
    public function getDiasRestantesEntregaAttribute()
    {
        if ($this->estado->esFinal()) {
        return null;
        }

        if (!$this->fecha_entrega) {
            return null;
        }

        $hoy = now()->copy()->startOfDay();
        $entrega = $this->fecha_entrega->copy()->startOfDay();

        return (int) $hoy->diffInDays($entrega, false);
    }
    // Método para calcular los dias restantes para la licencia
    public function getDiasRestantesLicenciaAttribute()
    {
        if (!$this->licencia || !$this->licencia->fecha_fin) {
            return null;
        }

        $hoy = now()->copy()->startOfDay();
        $fin = $this->licencia->fecha_fin->copy()->startOfDay();

        return (int) $hoy->diffInDays($fin, false);
    }

    public function getEstadoLicenciaAttribute()
    {
        if (!$this->licencia || !$this->licencia->fecha_fin) {
            return null;
        }

        return now()->greaterThan($this->licencia->fecha_fin)
            ? 'vencido'
            : 'vigente';
    }

    public function fechaEntregaReal()
    {
        $estado = $this->historialEstados()
            ->where('estado', 'entregado')
            ->first();

        return $estado?->created_at;
    }
    // Costo real del pedido, basado en su tipo | resultado para pedidos/tabs/finanzas
    public function getCostoRealAttribute()
    {
        return match($this->tipo) {
            'mercadeo' => $this->compras->sum('total'),
            'servicio' => $this->servicio?->costo_servicio ?? 0,
            'licencia' => $this->licencia?->costo_licencia ?? 0,
            default => 0
        };
    }

    public function getResultadoAttribute()
    {
        return $this->monto_total_aprobado - $this->costo_real;
    }

    public function getResultadoTipoAttribute()
    {
        if ($this->resultado > 0) return 'ganancia';
        if ($this->resultado < 0) return 'perdida';
        return 'equilibrio';
    }
    // función por tipo que muestra el resultado formateado para pedidos/tabs/finanzas
    public function getResultadoFormateadoAttribute()
    {
        if ($this->estado !== \App\Enums\EstadoPedido::PAGADO) {
            return [
                'texto' => 'Pendiente',
                'tipo' => 'pendiente',
                'color' => 'secondary'
            ];
        }

        return [
            'texto' => '$' . number_format($this->resultado, 2),
            'tipo' => $this->resultado_tipo,
            'color' => match($this->resultado_tipo) {
                'ganancia' => 'success',
                'perdida' => 'danger',
                default => 'secondary'
            }
        ];
    }
    // Funcion para bloquear las compras en mercadeo si el estado no es en proceso
    public function puedeEditarCompras(): bool
    {
        if ($this->tipo === 'mercadeo') {
            return !$this->estado->bloqueaCompras();
        }

        return true;
    }
}
