<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PedidoLicencia extends Model
{
    protected $fillable = [
        'pedido_id',
        'nombre_licencia',
        'tipo_licencia',
        'numero_usuarios',
        'costo_licencia',
        'costo_renovacion',
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
