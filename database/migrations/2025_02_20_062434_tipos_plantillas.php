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
        Schema::create('tipos_plantillas', function(Blueprint $table){
            $table->id('tipo_plantilla_id');
            $table->bigInteger('clave', false, true);
            $table->string('tipo_plantilla');
            $table->boolean('baja');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_plantillas');
    }
};
