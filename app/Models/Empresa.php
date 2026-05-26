<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $fillable = ['nombre', 'descripcion', 'logo'];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
}
