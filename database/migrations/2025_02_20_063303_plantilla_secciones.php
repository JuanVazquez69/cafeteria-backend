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
        Schema::create('plantilla_secciones', function(Blueprint $table){
            $table->id('plantilla_seccion_id');
            $table->foreignId('plantilla_encabezado_id')->constrained('plantilla_encabezados')->references('plantilla_encabezado_id')->onDelete('cascade');
            $table->integer('orden', false, true);
            $table->string('nombre');
            $table->string('descripcion');
            $table->double('baja');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plantilla_secciones');
    }
};
