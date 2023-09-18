<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCobrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cobros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_alumno');
            $table->integer('id_user');
            $table->integer('id_ciclo_escolar');
            $table->integer('id_cuenta_asignada');
            $table->integer('id_planpagoconcepto');
            $table->decimal('cantidad_inicial',10,2);
            $table->decimal('descuento_pp',10,2);
            $table->decimal('descuento_adicional',10,2);
            $table->decimal('recargo',10,2);
            $table->date('fecha_pago');
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
        Schema::dropIfExists('cobros');
    }
}
