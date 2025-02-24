<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alimentos extends Model
{
    protected $table = 'alimentos';
    protected $primarykey = 'alimento_id';
    public $timestamps = true;

    protected $fillable = [
        'plantilla_encabezado_id',
        'clave',
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

    public function alimentoDetalles(){
        return $this->hasMany(AlimentosDetalles::class, 'alimento_id', 'alimento_id');
    }
}
