<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntregaUbicacion extends Model
{
    protected $table = 'entrega_ubicacion';
    protected $primaryKey = 'entrega_ubicacion_id';
    public $timestamps = true;

    protected $fillable = [
        'clave',
        'entrega_ubicacion_id',
        'baja'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected function pedido(){
        return $this->hasMany(Pedidos::class, 'entrega_ubicacion_id', 'entrega_ubicacion_id');
    }
}
