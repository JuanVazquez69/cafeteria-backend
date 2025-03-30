<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPago extends Model
{
    protected $table = 'tipo_pago';
    protected $primaryKey = 'tipo_pago_id';
    public $timestamps = true;

    protected $fillable = [
        'clave',
        'tipo_pago_id',
        'baja'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected function pedido() {
        return $this->hasMany(Pedidos::class, 'tipo_pago_id', 'tipo_pago_id');
    }
}
