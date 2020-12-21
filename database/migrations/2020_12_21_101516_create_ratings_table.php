<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->float('score'); //donde guardamos la puntuacion
            $table->morphs('rateable'); 
            // dentro de la tabla polimórfica es necesario tener una id y tipo
            // para saber con que modelo me tengo que conectar
            //rateable hace referencia a la entidad que quiero puntuar
            // morphs es lo mismo que hacer
            // $table->unsignedBigInteger('rateable_id');
            // $table->string('rateable_type');

            $table->morphs('qualifier'); 
            // la tabla intermedia tiene con quien tengo relacionado los usuarios
            //qualifier hace referencia a la entidad que está calificando
            // morphs equivalente a escribir
            // $table->integer('qualifier_id');
            // $table->string('qualifier_type');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ratings');
    }
}
