<?php

use Illuminate\Database\Seeder;
use App\Grupo;

class GrupoTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
       	$grupo = new Grupo();
        $grupo->id_ciclo_escolar 		= '1';
        $grupo->cupo_maximo 			= '25';
        $grupo->turno 					= 'MATUTINO';
        $grupo->id_nivel_escolar 		= '1';
        $grupo->grado_semestre 			= '1';
        $grupo->diferenciador_grupo 	= 'AZUL';
        $grupo->status 					= 'ACTIVO';
        $grupo->save();

        $grupo = new Grupo();
        $grupo->id_ciclo_escolar 		= '1';
        $grupo->cupo_maximo 			= '25';
        $grupo->turno 					= 'MATUTINO';
        $grupo->id_nivel_escolar 		= '1';
        $grupo->grado_semestre 			= '1';
        $grupo->diferenciador_grupo 	= 'AMARILLO';
        $grupo->status 					= 'ACTIVO';
        $grupo->save();

        $grupo = new Grupo();
        $grupo->id_ciclo_escolar 		= '1';
        $grupo->cupo_maximo 			= '25';
        $grupo->turno 					= 'MATUTINO';
        $grupo->id_nivel_escolar 		= '1';
        $grupo->grado_semestre 			= '2';
        $grupo->diferenciador_grupo 	= 'AZUL';
        $grupo->status 					= 'ACTIVO';
        $grupo->save();

        $grupo = new Grupo();
        $grupo->id_ciclo_escolar 		= '1';
        $grupo->cupo_maximo 			= '25';
        $grupo->turno 					= 'MATUTINO';
        $grupo->id_nivel_escolar 		= '1';
        $grupo->grado_semestre 			= '2';
        $grupo->diferenciador_grupo 	= 'AMARILLO';
        $grupo->status 					= 'ACTIVO';
        $grupo->save();

        $grupo = new Grupo();
        $grupo->id_ciclo_escolar 		= '1';
        $grupo->cupo_maximo 			= '25';
        $grupo->turno 					= 'MATUTINO';
        $grupo->id_nivel_escolar 		= '2';
        $grupo->grado_semestre 			= '1';
        $grupo->diferenciador_grupo 	= 'A';
        $grupo->status 					= 'ACTIVO';
        $grupo->save();

        $grupo = new Grupo();
        $grupo->id_ciclo_escolar 		= '1';
        $grupo->cupo_maximo 			= '25';
        $grupo->turno 					= 'MATUTINO';
        $grupo->id_nivel_escolar 		= '2';
        $grupo->grado_semestre 			= '1';
        $grupo->diferenciador_grupo 	= 'B';
        $grupo->status 					= 'ACTIVO';
        $grupo->save();
    }
}
