<?php

use Illuminate\Database\Seeder;
use App\Alumno;

class AlumnoTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $alumno = new Alumno();
        $alumno->apaterno 		= 'Gijon';
        $alumno->amaterno 		= 'Muñoz';
        $alumno->nombres 		= 'Jose Antonio';
        $alumno->genero 		= 'Hombre';
        $alumno->fecha_nac 		= '1989-11-30';
        $alumno->lugar_nac 		= 'Tuxtla Gutierrez';
        $alumno->edo_civil 		= 'casado';
        $alumno->curp 			= 'GIMA891130HCSJXN08';
        $alumno->domicilio 		= 'Calle Santa Maria 240, Bienestar Social';
        $alumno->ciudad 		= 'Tuxtla Gutierrez';
        $alumno->estado 		= 'Chiapas';
        $alumno->email 			= 'josegijon30@hotmail.com';
        $alumno->telefono 		= '9191123147';
        $alumno->cp 			= '29077';
        $alumno->telefono2 		= '';
        $alumno->foto 			= '';
        $alumno->status 		= 'activo';
        $alumno->save();

        $alumno = new Alumno();
        $alumno->apaterno 		= 'Encinos';
        $alumno->amaterno 		= 'Vazquez';
        $alumno->nombres 		= 'Eduardo';
        $alumno->genero 		= 'Hombre';
        $alumno->fecha_nac 		= '1986-08-12';
        $alumno->lugar_nac 		= 'Tuxtla Gutierrez';
        $alumno->edo_civil 		= 'casado';
        $alumno->curp 			= 'EVJE871230HCSJXN08';
        $alumno->domicilio 		= 'Calle Santa Maria 240,Albania';
        $alumno->ciudad 		= 'Tuxtla Gutierrez';
        $alumno->estado 		= 'Chiapas';
        $alumno->email 			= 'prodinet6@hotmail.com';
        $alumno->telefono 		= '9611123147';
        $alumno->cp 			= '29077';
        $alumno->telefono2 		= '';
        $alumno->foto 			= '';
        $alumno->status 		= 'activo';
        $alumno->save();
    }
}
