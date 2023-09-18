<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBecasAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('becaalumnos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_beca');
            $table->integer('id_alumno');
            $table->integer('id_ciclo_escolar');
            $table->integer('id_cuentaasignada');
            $table->string('status',30);
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
        Schema::dropIfExists('becaalumnos');
    }
}
