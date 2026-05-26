<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PedidoServicio extends Model
{
    protected $fillable = [
        'pedido_id',
        'descripcion_servicio',
        'alcance',
        'responsable',
        'entregables',
        'observaciones',
        'costo_servicio',
        'fecha_inicio',
        'fecha_fin',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}
