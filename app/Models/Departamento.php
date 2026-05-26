<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $fillable = [
        'dependencia_id',
        'nombre_departamento',
        'responsable',
        'telefono',
        'email',
        'direccion'
    ];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    public function dependencia()
    {
        return $this->belongsTo(Dependencia::class);
    }
}
