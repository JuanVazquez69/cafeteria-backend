<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantillaSeccionUsuarios extends Model
{
    protected $table = 'plantilla_seccion_usuarios';
    protected $primarykey = 'plantilla_seccion_usuario_id';
    public $timestamps = true;

    protected $fillable = [
        'plantilla_seccion_id',
        'usuario_id',
        'baja'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
