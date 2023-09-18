<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoliticaPlanPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('politicaplanpagos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_ciclo_escolar');
            $table->integer('id_plan_pago');
            $table->integer('dias_limite_pronto_pago');
            $table->string('cant_porc_descuento',15);
            $table->decimal('valor_descuento',10,2);
            $table->string('cant_porc_recargo',15);
            $table->decimal('valor_recargo',10,2);
            $table->string('status',20);
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
        Schema::dropIfExists('politicaplanpagos');
    }
}
