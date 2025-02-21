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
        Schema::create('Perfiles', function (Blueprint $table){
            $table->id('perfil_id');
            $table->bigInteger("clave", false, true);
            $table->string("perfil");
            $table->boolean("baja");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Perfiles');
    }
};
