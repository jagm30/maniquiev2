<?php

use Illuminate\Database\Seeder;
use App\Cicloescolar;

class CicloescolarTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $cicloescolar = new Cicloescolar();
        $cicloescolar->anio_inicio 	= '2018';
        $cicloescolar->anio_fin 	= '2019';
        $cicloescolar->periodo 		= '0';
        $cicloescolar->descripcion 	= 'Ciclo anual - Nivel Basico';
        $cicloescolar->denominacion = 'Grado';
        $cicloescolar->fecha_inicio = '2018-08-01';
        $cicloescolar->fecha_fin 	= '2019-07-01';
        $cicloescolar->status 		= 'activo';
        $cicloescolar->save();

        $cicloescolar = new Cicloescolar();
        $cicloescolar->anio_inicio 	= '2018';
        $cicloescolar->anio_fin 	= '2019';
        $cicloescolar->periodo 		= '1';
        $cicloescolar->descripcion 	= 'Ciclo Semestral - Ago-Ene';
        $cicloescolar->denominacion = 'Semestre';
        $cicloescolar->fecha_inicio = '2018-08-01';
        $cicloescolar->fecha_fin 	= '2019-01-15';
        $cicloescolar->status 		= 'activo';
        $cicloescolar->save();
    }
}
