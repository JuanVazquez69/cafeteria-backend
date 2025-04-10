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
        Schema::create('Contenido_Pedidos', function(Blueprint $table){
            $table->id('contenido_pedido_id');
            $table->bigInteger('clave', false, true);
            $table->foreignId('pedido_id')->constrained('pedidos')->references('pedido_id')->onDelete('cascade');
            $table->foreignId('plantilla_detalle_id')->constrained('plantilla_detalles')->references('plantilla_detalle_id')->onDelete('cascade');
            $table->integer('cantidad', false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Contenido_Pedidos');
    }
};
