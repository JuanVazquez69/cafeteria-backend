<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantillaEncabezados extends Model
{
    protected $table = 'plantilla_encabezados';
    protected $primarykey = 'plantilla_encabezado_id';
    public $timestamps = true;

    protected $fillable = [
        'tipo_plantilla_id',
        'clave_automatica',
        'clave',
        'principal',
        'nombre',
        'descripcion',
        'baja'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
