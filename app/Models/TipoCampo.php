<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoCampo extends Model
{
    protected $table = 'tipo_campo';
    protected $primarykey = 'tipo_campo_id';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'valor',
        'baja'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
