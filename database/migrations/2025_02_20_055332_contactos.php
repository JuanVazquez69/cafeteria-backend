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
        Schema::create('Contactos', function(Blueprint $table){
            $table->id('contacto_id');
            $table->bigInteger('clave', false, true);
            $table->foreignId('user_id')->constrained('users')->references('user_id')->onDelete('cascade');
            $table->foreignId('tipo_contacto_id')->constrained('tipo_contacto')->references('tipo_contacto_id')->onDelete('cascade');
            $table->string('contacto');
            $table->boolean('baja');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Contactos');
    }
};
