<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('apaterno',50);
            $table->string('amaterno',50);
            $table->string('nombres',50);
            $table->string('genero',50)->nullable();
            $table->date('fecha_nac')->nullable();
            $table->string('lugar_nac',50)->nullable();
            $table->string('edo_civil',50)->nullable();
            $table->string('curp',50)->nullable();
            $table->string('domicilio',100)->nullable();
            $table->string('ciudad',50)->nullable();
            $table->string('estado',50)->nullable();
            $table->string('email',50);
            $table->string('telefono',50)->nullable();
            $table->string('cp',50)->nullable();
            $table->string('telefono2',50)->nullable();
            $table->string('foto',200)->nullable();
            $table->string('status',50)->nullable();
            $table->string('nombre_tutor',100)->nullable();
            $table->string('parentesco_tutor',30)->nullable();
            $table->string('telefono_tutor',30)->nullable();
            $table->string('razon_social',100)->nullable();
            $table->string('rfc',30)->nullable();
            $table->string('uso_cfdi',100)->nullable();
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
        Schema::dropIfExists('alumnos');
    }
}
