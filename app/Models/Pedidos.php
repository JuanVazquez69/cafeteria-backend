<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'pedido_id';
    public $timestamps = true;

    protected $fillable = [
        'clave',
        'tipo_pago_id',
        'user_id',
        'entrega_ubicacion_id',
        'cantidad_articulos',
        'total',
        'estado'
    ];

    protected $hidden = [
        'created_at', //Para mostar cuando se realizo el pedido
        'updated_at'
    ];

    protected static function booted()
    {
        static::created(function ($pedido){
            //Actualiza el campo 'clave con el id recien generado
            $pedido->update([
                'clave' => $pedido->pedido_id
            ]);
        });
    }

    public function tipoPago(){
        return $this->belongsTo(TipoPago::class, 'tipo_pago_id', 'tipo_pago_id');
    }

    public function contenidoPedido() {
        return $this->hasMany(ContenidoPedidos::class, 'pedido_id', 'pedido_id');
    }

    public function usuario(){
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
