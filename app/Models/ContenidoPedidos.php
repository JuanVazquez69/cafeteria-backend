<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContenidoPedidos extends Model
{
    protected $table = 'contenido_pedidos';
    protected $primaryKey = 'contenido_pedido_id';
    public $timestamps = true;

    protected $fillable = [
        'clave',
        'pedido_id',
        'alimento_detalle_id',
        'user_id',
        'cantidad'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected static function booted()
    {
        static::created(function ($contenido_pedido){
            //Acutalizamos el campo 'clave' con el id recién creado
            $contenido_pedido->update([
                'clave' => $contenido_pedido
            ]);
        });
    }

    public function pedido() {
        return $this->belongsTo(Pedidos::class, 'pedido_id', 'pedido_id');
    }

    public function alimentosDetalles() {
        return $this->belongsTo(AlimentosDetalles::class, 'alimento_detalle_id', 'alimento_detalle_id');
    }
}
