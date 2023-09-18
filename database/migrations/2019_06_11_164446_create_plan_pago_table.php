<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlanPagoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planpagos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo',50);
            $table->string('descripcion',200);
            $table->string('periocidad',20)->nullable();
            $table->string('status',20)->nullable();
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
        Schema::dropIfExists('planpagos');
    }
}
