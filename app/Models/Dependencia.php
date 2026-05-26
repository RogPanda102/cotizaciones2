<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Dependencia extends Model
{
    protected $table = 'dependencias';

    protected $fillable = [
        'nombre_oficial',
        'nombre_corto',
    ];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
    public function departamentos()
    {
        return $this->hasMany(Departamento::class);
    }
}
