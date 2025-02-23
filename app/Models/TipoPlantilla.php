<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPlantilla extends Model
{
    protected $table = 'tipo_plantilla';
    protected $primarykey = 'tipo_plantilla_id';
    public $timestamps = true;

    protected $fillable = [
        'clave',
        'tipo_plantilla',
        'baja'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
