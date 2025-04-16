<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VWPedidosManager extends Model
{
    protected $table = 'vw_pedidos_manager';

    public $incrementing = false;
    public $timestamps = false;

    protected $primaryKey = 'pedido_id';

    protected $fillable = [
        'clave',
        'tipo_pago',
        'name',
        'edificio',
        'cantidad_articulos',
        'total'
    ];
}
