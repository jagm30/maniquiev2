<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBecasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('becas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo',50);
            $table->string('descripcion',150);
            $table->string('porc_o_cant',15);
            $table->decimal('cantidad',10,2);
            $table->integer('id_ciclo_escolar');
            $table->integer('id_nivel');
            $table->string('status',15);
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
        Schema::dropIfExists('becas');
    }
}
