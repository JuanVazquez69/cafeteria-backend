<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('Pedidos', function(Blueprint $table){
            $table->id('pedido_id');
            $table->bigInteger('clave', false, true);
            $table->foreignId('tipo_pago_id')->constrained('tipo_pago')->references('tipo_pago_id')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->references('user_id')->onDelete('cascade');
            $table->foreignId('entrega_ubicacion_id')->constrained('ubicacion_entrega')->references('entrega_ubicacion_id')->onDelete('cascade');
            $table->integer('cantidad_articulos', false);
            $table->double('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Pedidos');
    }
};
