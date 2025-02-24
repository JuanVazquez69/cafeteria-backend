<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'perfiles';
    protected $primaryKey = 'perfil_id';
    public $timestamps = true;


    protected $fillable = [
        'clave',
        'perfil',
        'baja',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function users(){
        return $this->hasMany(User::class, 'perfil_id', 'perfil_id');
    }
}
