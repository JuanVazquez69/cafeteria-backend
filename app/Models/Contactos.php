<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contactos extends Model
{
    protected $table = 'contactos';
    protected $primaryKey = 'contacto_id';
    public $timestamps = true;

    protected $fillable = [
        'clave',
        'user_id',
        'tipo_contacto_id',
        'contacto',
        'baja'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected static function booted()
    {
        static::created(function ($contacto){
            // Actualiza el campo 'clave' con el ID recién generado
            $contacto->update([
                'clave' => $contacto->contacto_id
            ]);
        });
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function tipoContacto(){
        return $this->belongsTo(TipoContacto::class, 'tipo_contacto_id', 'tipo_contacto_id');
    }
}
