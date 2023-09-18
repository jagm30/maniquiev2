<?php

namespace App\Http\Controllers;

use App\Becaalumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

use App\Cuentaasignada;
use App\Cicloescolar;
use App\Planpago;
use App\Nivelescolar;
use App\Grupo;
use App\Alumno;
use App\Grupoalumno;
use App\Planpagoconcepto;
use App\Conceptocobro;

class BecaalumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        //
        return "Becas asignadas";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Becaalumno  $becaalumno
     * @return \Illuminate\Http\Response
     */
    public function show(Becaalumno $becaalumno)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Becaalumno  $becaalumno
     * @return \Illuminate\Http\Response
     */
    public function edit(Becaalumno $becaalumno)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Becaalumno  $becaalumno
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Becaalumno $becaalumno)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Becaalumno  $becaalumno
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $count_beca = DB::table('becaalumnos')
            ->select('id')            
            ->where('id_beca',$id)
            ->count();
        if($count_beca>0){
            return "No se puede eliminar, Beca asignada a uno o mas alumnos!!";
        }else{
            $becaalumno = Becaalumno::findOrFail($id);
            $becaalumno->delete();
            return redirect("/alumnos/becas/".$becaalumno->id_alumno);
        } 

        
    }
    public function RegistrarBeca(Request $request, $id_beca, $selected, $id_alumno, $id_grupo)
    {
        $id_session_ciclo   = session('session_cart');
        $selected           = explode(",", $selected);
        $mensaje = '';
        foreach ($selected as $id_cuentaasignada) {
        $cont = 0;
        $cont =  DB::table('becaalumnos')
                ->where('id_beca', $id_beca)
                ->where('id_alumno', $id_alumno)
                ->where('id_ciclo_escolar', $id_session_ciclo)
                ->where('id_cuentaasignada', $id_cuentaasignada)
                ->count();
            if($cont >=1 ){
                $mensaje .= '|| no se registro: '.$id_beca.' || ';
            }else{
                $becaalumno = new Becaalumno;
                $becaalumno->id_beca             = $id_beca;
                $becaalumno->id_alumno           = $id_alumno;
                $becaalumno->id_ciclo_escolar    = $id_session_ciclo;
                $becaalumno->id_cuentaasignada   = $id_cuentaasignada;
                $becaalumno->status              = 'activo';
                $becaalumno->save();

            }            
        }    
        return response()->json(['data' => "Operacion ejecutada. ".$mensaje ]);  
    }
}
