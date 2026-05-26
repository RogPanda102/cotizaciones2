<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $fillable = [
        'pedido_id',
        'fecha',
        'cantidad',
        'unidad',
        'proveedor_id',
        'descripcion',
        'monto',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function getTotalAttribute()
    {
        return $this->cantidad * $this->monto;
    }
}
