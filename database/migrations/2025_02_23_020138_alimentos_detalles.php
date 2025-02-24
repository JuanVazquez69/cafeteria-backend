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
            $table->foreignId('alimentos_id')->constrained('alimentos')->references('alimento_id')->onDelete('cascade');
            $table->foreignId('plantilla_seccion_id')->constrained('plantilla_secciones')->references('plantilla_seccion_id')->onDelete('cascade');
            $table->foreignId('plantilla_detalle_id')->constrained('plantilla_detalles')->references('plantilla_detalle_id')->onDelete('cascade');
            $table->string('valor');
            $table->foreignId('archivo_ftp_id')->constrained('archivos_ftp')->references('archivo_ftp_id')->onDelete('cascade');
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
