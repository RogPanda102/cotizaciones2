<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\EstadoCotizacion;

class Cotizacion extends Model
{
    protected $table = 'cotizaciones';

    protected $casts = [
        'estado' => EstadoCotizacion::class,
        'fecha_recepcion' => 'date',
        'fecha_envio' => 'date',
        'monto_total' => 'decimal:2',
        'horario_de_entrega' => 'datetime:H:i', //pendiente a revision
    ];

    protected $fillable = [
        'departamento_id',
        'dependencia_id',
        'empresa_id',
        'analista_id',
        'numero_cotizacion',
        'folio_externo',
        'garantia',
        'horario_de_entrega',
        'lugar_de_entrega',
        'estado',
        'fecha_recepcion',
        'fecha_envio',
        'monto_total',
        'dias_credito',
        'tipo_dias',
        'tipo_cotizacion',

    ];

    

    public function pedido()
    {
        return $this->hasOne(Pedido::class);
    }
    
    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function analista()
    {
        return $this->belongsTo(Analista::class);
    }
    
    public function edit(Cotizacion $cotizacion)
    {
        return view('cotizaciones.edit', [
            'cotizacion' => $cotizacion,
            'empresas' => Empresa::all(),
            'dependencias' => Dependencia::all(),
            'departamentos' => Departamento::all(),
            'analistas' => Analista::all(),
        ]);
    }
}
