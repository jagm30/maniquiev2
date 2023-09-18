<?php

namespace App\Http\Controllers;
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
use App\Cobro;



class CuentaasignadaController extends Controller
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
        return view('cuentasasignadas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id_session_ciclo = session('session_cart');
        $planpagos =  Planpago::where('id_ciclo_escolar',$id_session_ciclo)
                    ->get();
        return view('cuentasasignadas.create',compact('planpagos'));
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
     * @param  \App\Cuentaasiganada  $cuentaasiganada
     * @return \Illuminate\Http\Response
     */
    public function show(Cuentaasiganada $cuentaasiganada)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cuentaasiganada  $cuentaasiganada
     * @return \Illuminate\Http\Response
     */
    public function edit(Cuentaasiganada $cuentaasiganada)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cuentaasiganada  $cuentaasiganada
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cuentaasiganada $cuentaasiganada)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cuentaasiganada  $cuentaasiganada
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $consultacobro  = Cobro::where('id_cuenta_asignada',$id)->get();
        $countcobros    = $consultacobro->count();
        if($countcobros > 0){
            return response()->json(['data' => 'No se puede eliminar, cancele primero los cobros']);   
        }else{
            $data = Cuentaasignada::findOrFail($id);
            $data->delete();        
            return response()->json(['data' => 'Eliminado correctamente...']);
        }
        
    }

    public function opcionAsignacion(Request $request, $id){
        if(request()->ajax())
        {
            if($id=='nivel'){
                $nivelescolars = Nivelescolar::all();
                return response()->json(['data' => $nivelescolars ]);
            }
            if($id=='grupo'){
                $id_session_ciclo = session('session_cart');
                // Alias de columnas de una table, inner join, nombres de columnas personalizadas
                $grupos = DB::table('grupos')
                    ->select('grupos.id AS id_grupo','descripcion','cupo_maximo','turno','clave_identificador','grado_semestre','diferenciador_grupo','denominacion_grado' )
                    ->join('nivelescolars', 'grupos.id_nivel_escolar', '=', 'nivelescolars.id')
                    ->join('cicloescolars', 'grupos.id_ciclo_escolar', '=', 'cicloescolars.id')
                    ->where('grupos.id_ciclo_escolar',$id_session_ciclo)
                    ->get();
                return response()->json(['data' => $grupos ]);
            }
            if($id=='alumno'){
                $id_session_ciclo = session('session_cart');
                $alumnos = DB::table('alumnos')
                    ->select('alumnos.id','alumnos.apaterno','alumnos.amaterno','alumnos.nombres','alumnos.curp','alumnos.email','alumnos.telefono','alumnos.foto','grupoalumnos.id_grupo','grupoalumnos.status', 'grupos.id_ciclo_escolar', 'grupos.id_nivel_escolar', 'grupos.grado_semestre', 'grupos.diferenciador_grupo' )
                    ->leftJoin('grupoalumnos', 'alumnos.id', '=', 'grupoalumnos.id_alumno')
                    ->leftJoin('grupos', 'grupoalumnos.id_grupo', '=', 'grupos.id')
                    ->leftJoin('nivelescolars', 'grupos.id_nivel_escolar', '=', 'nivelescolars.id')
                    ->leftJoin('cicloescolars', 'grupos.id_ciclo_escolar', '=', 'cicloescolars.id')
                    ->where('grupos.id_ciclo_escolar',$id_session_ciclo) //cambio realizado el 11-08-2020
                    ->get();
                return response()->json(['data' => $alumnos ]);
            }
        }
    }
    public function listarOpcionAsignacion(Request $request, $id, $subopc)
    {
        //$id_session_ciclo   = ;
        if($id=='nivel')
        {            
            $grupos = DB::table('grupos')
            ->select('grupos.id AS id_grupo','descripcion','cupo_maximo','turno','clave_identificador','grado_semestre','diferenciador_grupo','denominacion_grado' )
            ->join('nivelescolars', 'grupos.id_nivel_escolar', '=', 'nivelescolars.id')
            ->join('cicloescolars', 'grupos.id_ciclo_escolar', '=', 'cicloescolars.id')
            ->where('grupos.id_ciclo_escolar',session('session_cart'))
            ->where('grupos.id_nivel_escolar',$subopc)
            ->get();
            return response()->json(['data' => $grupos ]);
        }
        if($id=='alumno')
        {   
            $alumno = DB::table('alumnos')
                    ->select('alumnos.id AS id','grupoalumnos.status','id_alumno','id_grupo','alumnos.genero','alumnos.foto','grupos.grado_semestre','curp','grupos.diferenciador_grupo'
                        ,DB::raw("CONCAT(alumnos.apaterno,' ',alumnos.amaterno,' ',alumnos.nombres) as full_name"),DB::raw("CONCAT(alumnos.curp,' ',alumnos.genero) as otro"))
                    ->join('grupoalumnos', 'alumnos.id', '=', 'grupoalumnos.id_alumno')
                    ->join('grupos', 'grupoalumnos.id_grupo', '=', 'grupos.id')
                    ->where('alumnos.id',$subopc)
                    ->where('grupoalumnos.id_ciclo_escolar',session('session_cart'))//modificado el dia 11-08-2020
                    ->get();

            return response()->json(['data' => $alumno ]); 
        }
        if($id=='grupo')
        {
            $alumnos = DB::table('grupoalumnos')
                    ->select('grupoalumnos.id AS id','grupoalumnos.status','id_alumno','id_grupo','alumnos.genero','alumnos.foto','grupos.grado_semestre','grupos.diferenciador_grupo'
                        ,DB::raw("CONCAT(alumnos.apaterno,' ',alumnos.amaterno,' ',alumnos.nombres) as full_name"),DB::raw("CONCAT(alumnos.curp,' ',alumnos.genero) as otro"))
                    ->join('alumnos', 'grupoalumnos.id_alumno', '=', 'alumnos.id')
                    ->join('grupos', 'grupoalumnos.id_grupo', '=', 'grupos.id')
                    ->where('grupoalumnos.id_grupo',$subopc)
                    ->where('grupos.id_ciclo_escolar',session('session_cart'))
                    ->get();

            return response()->json(['data' => $alumnos ]);    
        }
    }
    public function guardarOpcionAsignacion(Request $request, $id, $subopc, $selected,$planpago,$conceptos)
    {
        $id_session_ciclo   = session('session_cart');
        $selected           = explode(",", $selected);
        $conceptos          = explode(",", $conceptos);
        $cont_alumnos       = 0;
        $cont_conceptos     = 0;
        $id_alumno          = 0;
        if($id=='grupo'){
            foreach ($selected as $id_alumno) {
                $cont_conceptos     = 0;
                foreach ($conceptos as $concepto) {
                    $cuentaasignada = new Cuentaasignada; 
                    $cuentaasignada->id_alumno              = $id_alumno;
                    $cuentaasignada->id_plan_pago           = $planpago;
                    $cuentaasignada->id_plan_concepto_cobro = $concepto;
                    $cuentaasignada->id_ciclo_escolar       = $id_session_ciclo;
                    $cuentaasignada->status                 = 'activo';
                    $cuentaasignada->save();
                    # code...
                    $cont_conceptos++;
                }
                $cont_alumnos++;
            }
            return response()->json(['data' => "Agregado: ".$cont_conceptos." concepto(s), a ".$cont_alumnos. " alumnos(s)" ]);
        }
        if($id=='nivel'){
            $grupo = 0;
            foreach ($selected as $grupo) {
                $grupo = DB::table('grupoalumnos')
                ->select('grupoalumnos.id AS id','grupoalumnos.status','id_alumno','id_grupo','alumnos.genero','alumnos.foto','grupos.grado_semestre','grupos.diferenciador_grupo'
                    ,DB::raw("CONCAT(alumnos.apaterno,' ',alumnos.amaterno,' ',alumnos.nombres) as full_name"),DB::raw("CONCAT(alumnos.curp,' ',alumnos.genero) as otro"))
                ->join('alumnos', 'grupoalumnos.id_alumno', '=', 'alumnos.id')
                ->join('grupos', 'grupoalumnos.id_grupo', '=', 'grupos.id')
                ->where('grupoalumnos.id_grupo',$grupo)
                ->get();
                foreach ($grupo as $alumno) {
                    $cont_conceptos     = 0;
                    foreach ($conceptos as $concepto) {
                        $cuentaasignada = new Cuentaasignada; 
                        $cuentaasignada->id_alumno              = $alumno->id_alumno;
                        $cuentaasignada->id_plan_pago           = $planpago;
                        $cuentaasignada->id_plan_concepto_cobro = $concepto;
                        $cuentaasignada->id_ciclo_escolar       = $id_session_ciclo;
                        $cuentaasignada->status                 = 'activo';
                        $cuentaasignada->save();
                        $cont_conceptos++;
                    }
                    $cont_alumnos++;
                }
            }
            return response()->json(['data' => "Agregado: ".$cont_conceptos." concepto(s), a ".$cont_alumnos. " alumno(s)" ]);
        }
        if($id=='alumno'){ 
            $cont_conceptos     = 0;          
            foreach ($conceptos as $concepto) {
                $cuentaasignada = new Cuentaasignada; 
                $cuentaasignada->id_alumno              = $selected[0];
                $cuentaasignada->id_plan_pago           = $planpago;
                $cuentaasignada->id_plan_concepto_cobro = $concepto;
                $cuentaasignada->id_ciclo_escolar       = $id_session_ciclo;
                $cuentaasignada->status                 = 'activo';
                $cuentaasignada->save();
                $cont_conceptos++;
            }
            return response()->json(['data' => "Agregado(s): ".$cont_conceptos." concepto(s)" ]);
        }
        
    }
    public function CuentasAsignadas(Request $request, $id, $opcion, $planpago)
    {
        $id_session_ciclo = session('session_cart');
        $conceptoscobro = DB::table('planpagoconceptos')
        ->select('planpagoconceptos.id','id_concepto_cobro','id_plan_pago','anio_corresponde','mes_pagar','no_parcialidad','periodo_inicio','periodo_vencimiento','cantidad', 'conceptocobros.descripcion')
        ->join('conceptocobros', 'planpagoconceptos.id_concepto_cobro', '=', 'conceptocobros.id')
        ->join('planpagos', 'planpagoconceptos.id_plan_pago', '=', 'planpagos.id')
        ->where('id_plan_pago',$planpago)
        ->where('planpagoconceptos.id_ciclo_escolar',$id_session_ciclo)
        ->get();

        return response()->json(['data' => $conceptoscobro ]);  
    }
}
