<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDescuentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descuentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_cuentaasignada');
            $table->integer('id_alumno');
            $table->date('fecha_descuento');            
            $table->integer('id_ciclo_escolar'); 
            $table->integer('cantidad');
            $table->string('observaciones',30);
            $table->string('status',30);
            $table->integer('id_usuario');
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
        Schema::dropIfExists('descuentos');
    }
}
