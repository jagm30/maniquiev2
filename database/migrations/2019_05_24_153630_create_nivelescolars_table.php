<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNivelescolarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nivelescolars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('clave_identificador',20);
            $table->string('acuerdo_incorporacion',20);
            $table->date('fecha_incorporacion');
            $table->string('zona_escolar',20);
            $table->string('denominacion_grado',150);
            $table->string('status',20)->nullable();
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
        Schema::dropIfExists('nivelescolars');
    }
}
