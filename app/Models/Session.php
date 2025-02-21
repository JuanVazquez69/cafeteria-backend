<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table = 'sessions'; // Nombre de la tabla
    protected $primaryKey = 'session_id'; // Especificar la clave primaria
    public $incrementing = false; // Evita que Laravel trate de autoincrementar la clave
    protected $keyType = 'string'; // Indicar que es un string
}
