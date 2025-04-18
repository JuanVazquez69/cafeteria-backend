<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantillaSecciones extends Model
{
    protected $table = "plantilla_secciones";
    protected $primaryKey = "plantilla_seccion_id";
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

    public function plantillaEncabezados(){
        return $this->belongsTo(PlantillaEncabezados::class, 'plantilla_encabezado_id', 'plantilla_encabezado_id');
    }

    public function plantillaSeccionUsuarios(){
        return $this->hasMany(PlantillaSeccionUsuarios::class, 'plantilla_seccion_id', 'plantilla_seccion_id');
    }

    public function alimentoDetalles(){
        return $this->hasMany(AlimentosDetalles::class, 'plantilla_seccion_id', 'plantilla_seccion_id');
    }
}
