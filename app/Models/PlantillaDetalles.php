<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantillaDetalles extends Model
{
    protected $table = 'plantilla_detalles';
    protected $primarykey = 'plantilla_detalle_id';
    public $timestamps = true;

    protected $fillable = [
        'plantilla_seccion_id',
        'orden',
        'etiqueta',
        'descripcion',
        'tipo_campo_id',
        'longitud',
        'obligatorio',
        'valor_default',
        'valor_minimo',
        'valor_maximo',
        'valor_ideal',
        'baja'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
