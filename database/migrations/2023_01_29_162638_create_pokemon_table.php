<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pokemon', function (Blueprint $table) {
            
            $table->id();
            $table->integer('pokemon_id');
            $table->string('nombre');
            $table->string('tipo');
            $table->integer('hp');
            $table->integer('ataque');
            $table->integer('defensa');

            $table->unsignedBigInteger('competidor_id');         
            $table->foreign('competidor_id')->references('id')->on('competidores');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pokemon');
    }
};