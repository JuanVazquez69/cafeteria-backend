<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPlantilla extends Model
{
    protected $table = 'tipos_plantillas';
    protected $primaryKey = 'tipo_plantilla_id';
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


    public function plantillaEncabezado(){
        return $this->hasMany(PlantillaEncabezados::class, 'tipo_plantilla_id', 'tipo_plantilla_id');
    }
}
