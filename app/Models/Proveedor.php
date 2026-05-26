<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    protected $fillable = [
        'empresa',
        'nombre_contacto',
        'telefono',
        'email'
    ];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    public function compras()
    {
        return $this->hasMany(Compra::class);
    }
}
