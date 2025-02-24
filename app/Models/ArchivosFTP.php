<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchivosFTP extends Model
{
    protected $table = 'archivos_ftp';
    protected $primaryKey = 'archivo_ftp_id';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'ubicacion',
        'baja'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function alimentoDetalles(){
        return $this->hasMany(AlimentosDetalles::class, 'archivo_ftp_id', 'archivo_ftp_id');
    }
}
