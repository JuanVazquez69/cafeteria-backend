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
        Schema::create('plantilla_encabezados', function(Blueprint $table){
            $table->id('plantilla_encabezado_id');
            $table->bigInteger('clave', false, true);
            $table->bigInteger('tipo_plantilla_id');
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
        Schema::dropIfExists('plantilla_encabezados');
    }
};
