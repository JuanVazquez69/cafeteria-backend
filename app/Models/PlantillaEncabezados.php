<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantillaEncabezados extends Model
{
    protected $table = 'plantilla_encabezados';
    protected $primaryKey = 'plantilla_encabezado_id';
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

    public function tipoPlantilla(){
        return $this->belongsTo(TipoPlantilla::class, 'tipo_plantilla_id', 'tipo_plantilla_id');
    }

    public function plantillaSecciones(){
        return $this->hasMany(PlantillaSecciones::class, 'plantilla_encabezado_id', 'plantilla_encabezado_id');
    }

    public function alimentos(){
        return $this->hasMany(Alimentos::class, 'plantilla_encabezado_id', 'plantilla_encabezado_id');
    }
}
