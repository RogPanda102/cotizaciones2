<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\EstadoPedido;

class PedidoEstado extends Model
{
    protected $fillable = [
        'pedido_id',
        'estado',
    ];

    protected $casts = [
        'estado' => EstadoPedido::class,
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }
}
