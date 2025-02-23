<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantillaSecciones extends Model
{
    protected $table = "plantilla_secciones";
    protected $primarykey = "plantilla_secciones_id";
    public $timestamps = true;

    protected $fillable = [
        'plantilla_encabezado_id',
        'orden',
        'nombre',
        'descripcion',
        'baja'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
