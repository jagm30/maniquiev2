<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConceptoCobroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conceptocobros', function (Blueprint $table) {
            //
            $table->bigIncrements('id');
            $table->string('codigo',50);
            $table->string('descripcion',200);
            $table->decimal('precio_regular',10,2);
            $table->integer('impuesto')->nullable();
            $table->string('unidad_medida',20)->nullable();
            $table->string('status',20)->nullable();
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
        Schema::dropIfExists('conceptocobros');
    }
}
