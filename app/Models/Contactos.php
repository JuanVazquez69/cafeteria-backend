<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contactos extends Model
{
    protected $table = 'contactos';
    protected $primarykey = 'contacto_id';
    public $timestamps = true;

    protected $fillable = [
        'clave',
        'user_id',
        'contacto_tipo_id',
        'contacto',
        'baja'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
