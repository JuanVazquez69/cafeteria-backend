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
        Schema::create('plantilla_seccion_usuarios', function(Blueprint $table){
            $table->id('plantilla_secccion_usuario_id');
            $table->foreignId('plantilla_seccion_id')->constrained('plantilla_secciones')->references('plantilla_seccion_id')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->references('user_id')->onDelete('cascade');
            $table->boolean('baja');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plantilla_seccion_usuarios');
    }
};
