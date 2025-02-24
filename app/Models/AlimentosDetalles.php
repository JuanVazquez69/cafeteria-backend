<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlimentosDetalles extends Model
{
    protected $table = 'alimentos_detalles';
    protected $primaryKey = 'alimento_detalle_id';
    public $timestamps = true;

    protected $fillable =[
        'alimento_id',
        'plantilla_seccion_id',
        'plantilla_detalle_id',
        'valor',
        'baja',
        'archivo_ftp_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function alimentos(){
        return $this->belongsTo(Alimentos::class, 'alimento_id', 'alimento_id');
    }

    public function plantillaSeccion(){
        return $this->belongsTo(PlantillaSecciones::class, 'plantilla_seccion_id', 'plantilla_seccion_id');
    }

    public function plantillaDetalles(){
        return $this->belongsTo(PlantillaDetalles::class, 'plantilla_detalle_id', 'plantilla_detalle_id');
    }

    public function archivosFTP(){
        return $this->belongsTo(ArchivosFTP::class, 'archivo_ftp_id', 'archivo_ftp_id');
    }
}
