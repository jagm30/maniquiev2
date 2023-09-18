<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCicloescolarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cicloescolars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('anio_inicio')->nullable();
            $table->integer('anio_fin')->nullable();
            $table->integer('periodo')->nullable();
            $table->string('descripcion',50);
            $table->string('denominacion',50);
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->string('status',10);
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
        Schema::dropIfExists('cicloescolars');
    }
}
