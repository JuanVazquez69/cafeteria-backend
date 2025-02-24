<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoContacto extends Model
{
    protected $table = 'tipo_contacto';
    protected $primaryKey = 'tipo_contacto_id';
    public $timestampos = true;

    protected $fillable = [
        'clave',
        'tipo',
        'baja'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected function contactos(){
        return $this->hasMany(Contactos::class, 'tipo_contacto_id', 'tipo_contacto_id');
    }
}
