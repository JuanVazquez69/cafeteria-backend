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
        Schema::create('plantilla_detalles', function(Blueprint $table){
            $table->id('plantilla_detalle_id');
            $table->foreignId('plantilla_seccion_id')->constrained('plantilla_secciones')->references('plantilla_seccion_id')->onDelete('cascade');
            $table->integer('orden', false, true);
            $table->string('etiqueta');
            $table->text('descripcion');
            $table->foreignId('tipo_campo_id')->constrained('tipo_campo')->references('tipo_campo_id')->onDelete('cascade');
            $table->text('longitud');
            $table->text('obligatorio');
            $table->text('valor_default');
            $table->text('valor_minimo');
            $table->text('valor_maximo');
            $table->text('valor_ideal');
            $table->boolean('baja');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plantilla_detalles');
    }
};
