<?php

use Illuminate\Database\Seeder;
use App\Planpago;

class PlanpagosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $planapago = new Planpago; 
        $planapago->codigo          = 'CAK_3.3';
        $planapago->descripcion     = 'COLEGIATURA ANUAL PREESCOLAR 3.3';
        $planapago->periocidad      = 'MENSUAL';
        $planapago->status          = 'activo';
        $planapago->id_ciclo_escolar= 1;
        $planapago->save();

        $planapago = new Planpago; 
        $planapago->codigo          = 'CK_3.3';
        $planapago->descripcion     = 'COLEGIATURA MENSUAL PREESCOLAR 3.3';
        $planapago->periocidad      = 'MENSUAL';
        $planapago->status          = 'activo';
        $planapago->id_ciclo_escolar= 1;
        $planapago->save();

        $planapago = new Planpago; 
        $planapago->codigo          = 'IK_3.3';
        $planapago->descripcion     = 'INSCRIPCION MENSUAL PREESCOLAR 3.3';
        $planapago->periocidad      = 'MENSUAL';
        $planapago->status          = 'activo';
        $planapago->id_ciclo_escolar= 1;
        $planapago->save();

        $planapago = new Planpago; 
        $planapago->codigo          = 'CAPR_3.3';
        $planapago->descripcion     = 'COLEGIATURA ANUAL PRIMARIA 3.3';
        $planapago->periocidad      = 'MENSUAL';
        $planapago->status          = 'activo';
        $planapago->id_ciclo_escolar= 1;
        $planapago->save();

        $planapago = new Planpago; 
        $planapago->codigo          = 'CPR_3.3';
        $planapago->descripcion     = 'COLEGIATURA MENSUAL PRIMARIA 3.3';
        $planapago->periocidad      = 'MENSUAL';
        $planapago->status          = 'activo';
        $planapago->id_ciclo_escolar= 1;
        $planapago->save();

        $planapago = new Planpago; 
        $planapago->codigo          = 'IPR_3.3';
        $planapago->descripcion     = 'INSCRIPCION MENSUAL PRIMARIA 3.3';
        $planapago->periocidad      = 'MENSUAL';
        $planapago->status          = 'activo';
        $planapago->id_ciclo_escolar= 1;
        $planapago->save();
    }
}