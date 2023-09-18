<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrupoAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grupoalumnos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_alumno');
            $table->integer('id_grupo');
            $table->string('status',20)->nullable();
            $table->integer('id_nivel_escolar');
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
        Schema::dropIfExists('grupoalumnos');
    }
}
