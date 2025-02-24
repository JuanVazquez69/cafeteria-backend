<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlantillaSeccionUsuarios extends Model
{
    protected $table = 'plantilla_seccion_usuarios';
    protected $primaryKey = 'plantilla_seccion_usuario_id';
    public $timestamps = true;

    protected $fillable = [
        'plantilla_seccion_id',
        'usuario_id',
        'baja'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function users(){
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function plantillaSecciones(){
        return $this->belongsTo(PlantillaSecciones::class, 'plantilla_seccion_id', 'plantilla_seccion_id');
    }
}
