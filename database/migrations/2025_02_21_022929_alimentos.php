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
        Schema::create('alimentos', function(Blueprint $table){
            $table->id('alimento_id');
            $table->string('clave');
            $table->foreignId('plantilla_encabezado_id')->constrained('plantilla_encabezados')->references('plantilla_encabezado_id')->onDelete('cascade');
            $table->string('descripcion');
            $table->boolean('baja');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alimentos');
    }
};
