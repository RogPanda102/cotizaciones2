<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Analista extends Model
{
    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'email',
        'telefono',
    ];
}
