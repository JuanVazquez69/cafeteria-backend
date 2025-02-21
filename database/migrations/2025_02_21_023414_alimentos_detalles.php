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
        Schema::create('alimentos_detalles', function(Blueprint $table){
            $table->id('alimento_detalle_id');
            $table->bigInteger('alimentos_id');
            $table->bigInteger('plantilla_seccion_id');
            $table->bigInteger('plantilla_detalle_id');
            $table->string('valor');
            $table->bigInteger('archivo_ftp');
            $table->boolean('baja');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alimentos_detalles');
    }
};
