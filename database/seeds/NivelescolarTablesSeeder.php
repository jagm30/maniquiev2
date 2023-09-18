<?php

use Illuminate\Database\Seeder;
use App\Nivelescolar;

class NivelescolarTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $nivelescolar = new Nivelescolar();
        $nivelescolar->clave_identificador 		= 'PREE';
        $nivelescolar->acuerdo_incorporacion 	= 'PREE28282';
        $nivelescolar->fecha_incorporacion 		= '1990-01-01';
        $nivelescolar->zona_escolar 			= '01';
        $nivelescolar->denominacion_grado 		= 'PREESCOLAR';
        $nivelescolar->status 					= 'ACTIVO';
        $nivelescolar->save();

        $nivelescolar = new Nivelescolar();
        $nivelescolar->clave_identificador 		= 'PRIM';
        $nivelescolar->acuerdo_incorporacion 	= 'PRI28282';
        $nivelescolar->fecha_incorporacion 		= '1990-01-01';
        $nivelescolar->zona_escolar 			= '01';
        $nivelescolar->denominacion_grado 		= 'PRIMARIA';
        $nivelescolar->status 					= 'ACTIVO';
        $nivelescolar->save();

        $nivelescolar = new Nivelescolar();
        $nivelescolar->clave_identificador 		= 'SEC';
        $nivelescolar->acuerdo_incorporacion 	= 'SEC28282';
        $nivelescolar->fecha_incorporacion 		= '1990-01-01';
        $nivelescolar->zona_escolar 			= '01';
        $nivelescolar->denominacion_grado 		= 'SECUNDARIA';
        $nivelescolar->status 					= 'ACTIVO';
        $nivelescolar->save();

        $nivelescolar = new Nivelescolar();
        $nivelescolar->clave_identificador 		= 'PREP';
        $nivelescolar->acuerdo_incorporacion 	= 'PREPA9898';
        $nivelescolar->fecha_incorporacion 		= '1990-01-01';
        $nivelescolar->zona_escolar 			= '01';
        $nivelescolar->denominacion_grado 		= 'PREPARATORIA';
        $nivelescolar->status 					= 'ACTIVO';
        $nivelescolar->save();

    }
}
