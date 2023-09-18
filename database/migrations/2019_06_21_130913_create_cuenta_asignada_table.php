<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuentaAsignadaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuentaasignadas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_alumno');
            $table->integer('id_plan_pago');
            $table->integer('id_plan_concepto_cobro');
            $table->integer('id_ciclo_escolar');
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
        Schema::dropIfExists('cuentaasignadas');
    }
}
