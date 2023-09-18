<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanPagoConceptosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planpagoconceptos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_plan_pago');
            $table->integer('id_concepto_cobro');
            $table->integer('anio_corresponde');
            $table->string('mes_pagar',20);
            $table->integer('no_parcialidad');
            $table->date('periodo_inicio');
            $table->date('periodo_vencimiento');
            $table->decimal('cantidad',10,2);
            $table->string('status',20);
            $table->integer('id_ciclo_escolar');
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
        Schema::dropIfExists('planpagoconceptos');
    }
}
