<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Alumno;
use App\Http\Requests\StoreAlumnos;
use App\Grupoalumno;
use App\Grupo;
use App\Cicloescolar;
use App\Nivelescolar;
use App\Cuentaasignada;
use App\Planpago;
use App\Planpagoconcepto;
use App\Conceptocobro;
use App\Beca;
use PDF;
use Illuminate\Support\Facades\Auth;
class AlumnoController extends Controller
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
    public function index(Request $request)
    {
       /* if(!Auth::check()){
           return redirect('/login');
        }*/
        //
        //return "Controlador alumnos.... a";
        $request->user()->authorizeRoles(['admin','caja']); 
        //$request->user()->authorizeRoles('user');
        //$alumnos = Alumno::all();

        $id_session_ciclo = session('session_cart');
        if(request()->ajax()){
        return datatables()->of(DB::table('alumnos')
            ->select('alumnos.id','alumnos.apaterno','alumnos.amaterno','alumnos.nombres','alumnos.curp','alumnos.email','alumnos.telefono','alumnos.foto','alumnos.status','grupoalumnos.id_grupo as idgpo', 'grupos.id_ciclo_escolar', 'grupos.id_nivel_escolar', 'grupos.grado_semestre', 'grupos.diferenciador_grupo',DB::raw("CONCAT(alumnos.apaterno,' ',alumnos.amaterno,' ',alumnos.nombres) as full_name"),DB::raw("CONCAT(grado_semestre,' ',diferenciador_grupo) as grado_grupo"))
            ->leftJoin('grupoalumnos', 'alumnos.id', '=', 'grupoalumnos.id_alumno')

            ->leftJoin('grupos', function($leftJoin){
                $leftJoin->on('grupoalumnos.id_grupo', '=', 'grupos.id')
                    ->where('grupos.id_ciclo_escolar',session('session_cart'));
            })
            ->where('grupoalumnos.id_ciclo_escolar',session('session_cart'))            
            ->get())
        ->addColumn('action', function($data){
                        $button = '<a href="/alumnos/'.$data->id.'/edit"><button type="button" name="edit" class="btn btn-primary btn-xs" style="width:100px;margin-bottom:2px;">Editar</button></a> <a href="alumnos/'.$data->id.'"><button type="button" class="btn btn-success btn-xs" style="width: 100px;margin-bottom: 2px;">Estado de cuenta</button></a> ';

                        return $button;
                    })
        ->addColumn('action2', function($data){
                        $button = '<a href="javascript:void(0);" id="delete-product" data-toggle="tooltip" data-original-title="Delete" data-id="'.$data->id.'" class="delete btn btn-danger btn-xs" style="width: 100px;margin-bottom: 2px;"> 
                      Eliminar
                  
                    </a>
                    <a href="/alumnos/becas/'.$data->id.'"><button type="button" class="btn btn-info btn-xs" style="width: 100px;margin-bottom: 2px;">Becas</button></a> ';
                        return $button;
                    })
        ->addColumn('image', function ($data) { 
            $url= asset('images/'.$data->foto);
            return '<img src="'.$url.'" border="0" width="50" height="50" class="img-rounded" align="center" />';
        })
                    ->rawColumns(['action','action2','image'])
                    ->make(true);
        }
        return view("alumnos.index");
        //return view('grupoalumnos.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id_session_ciclo = session('session_cart');
        $grupos = DB::table('grupos')
                ->select('grupos.id','id_ciclo_escolar','turno','id_nivel_escolar','grado_semestre','diferenciador_grupo','grupos.status','denominacion_grado')                
                ->join('nivelescolars', 'nivelescolars.id', '=', 'grupos.id_nivel_escolar')
                ->where('grupos.id_ciclo_escolar',$id_session_ciclo)
                ->get();

        return view("alumnos.create",compact('grupos'));
        //return "Hola";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAlumnos $request)
    {
        $count_alumno = DB::table('alumnos')
            ->select('alumnos.curp')            
            ->where('alumnos.curp',$request->curp)
            ->count();
        if($count_alumno>0){
            return "LA CURP YA ESTA EXISTE...";
        }else{
            $id_session_ciclo = session('session_cart');
            $alumno = new Alumno;
            $alumno->apaterno           = $request->apaterno;
            $alumno->amaterno           = $request->amaterno;
            $alumno->nombres            = $request->nombres;
            $alumno->genero             = $request->genero;
            $alumno->fecha_nac          = $request->fecha_nac;
            $alumno->lugar_nac          = '';
            $alumno->edo_civil          = '';
            $alumno->curp               = $request->curp;
            $alumno->domicilio          = $request->domicilio;
            $alumno->ciudad             = $request->ciudad;
            $alumno->estado             = $request->estado;
            $alumno->cp                 = $request->cp;
            $alumno->telefono           = $request->telefono;
            $alumno->telefono2          = $request->telefono2;
            $alumno->foto               = 'alumno.jpg';
            $alumno->email              = $request->email;
            $alumno->status             = $request->status;
            $alumno->nombre_tutor       = $request->nombre_tutor;
            $alumno->parentesco_tutor   = $request->parentesco_tutor;
            $alumno->telefono_tutor     = $request->telefono_tutor;
            $alumno->razon_social       = $request->razon_social;
            $alumno->rfc                = $request->rfc;
            $alumno->uso_cfdi           = $request->uso_cfdi;
            $alumno->save();


            if($archivo=$request->file('foto'))
            {
                $nombreimg      = $archivo->getClientOriginalName();
                $extension      = $archivo->getClientOriginalExtension();
                $archivo->move('images', $alumno->id.'.'.$extension);
                $alumno->foto   =  $alumno->id.'.'.$extension;
            }
            $alumno->save();

            $grupos = DB::table('grupos')
                    ->select('grupos.id','id_ciclo_escolar','turno','id_nivel_escolar','grado_semestre','diferenciador_grupo','grupos.status','denominacion_grado')                
                    ->join('nivelescolars', 'nivelescolars.id', '=', 'grupos.id_nivel_escolar')
                    ->where('grupos.id_ciclo_escolar',$id_session_ciclo)
                    ->get();

            $alumno = Alumno::findOrFail($alumno->id);
            

            $grupoinscrito = DB::table('grupoalumnos')
                    ->select('grupoalumnos.id','id_alumno','id_grupo','grupoalumnos.status','grupoalumnos.id_grupo', 'grupos.id_ciclo_escolar', 'grupos.id_nivel_escolar', 'grupos.grado_semestre', 'grupos.diferenciador_grupo','nivelescolars.id as id_nivel','grupos.id as id_grupo')
                    ->leftJoin('grupos', 'grupoalumnos.id_grupo', '=', 'grupos.id')
                    ->leftJoin('nivelescolars', 'grupos.id_nivel_escolar', '=', 'nivelescolars.id')
                    ->leftJoin('cicloescolars', 'grupos.id_ciclo_escolar', '=', 'cicloescolars.id')
                    ->where('grupos.id_ciclo_escolar',$id_session_ciclo)
                    ->where('grupoalumnos.id_alumno',$alumno->id)
                    ->first();

            //return view("alumnos.edit", compact('alumno','grupos','grupoinscrito'));
            return redirect("/alumnos/".$alumno->id."/edit");
        }
        

    }
    public function consultacurp(Request $request, $id, $curp){
        $count_alumno = DB::table('alumnos')
            ->select('alumnos.curp')            
            ->where('alumnos.curp',$curp)
            ->count();
        return response()->json(['data' => $count_alumno]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id_session_ciclo   = session('session_cart');      
        $count_alumno = DB::table('alumnos')
            ->select('alumnos.id','alumnos.apaterno','alumnos.amaterno','alumnos.nombres','alumnos.curp','alumnos.email','alumnos.telefono','alumnos.foto','alumnos.fecha_nac','alumnos.lugar_nac','edo_civil','domicilio','ciudad','estado','cp','grupoalumnos.id_grupo','grupoalumnos.status', 'grupos.id_ciclo_escolar', 'grupos.id_nivel_escolar', 'grupos.grado_semestre', 'grupos.diferenciador_grupo' )
            ->leftJoin('grupoalumnos', 'alumnos.id', '=', 'grupoalumnos.id_alumno')
            ->leftJoin('grupos', 'grupoalumnos.id_grupo', '=', 'grupos.id')
            ->leftJoin('nivelescolars', 'grupos.id_nivel_escolar', '=', 'nivelescolars.id')
            ->leftJoin('cicloescolars', 'grupos.id_ciclo_escolar', '=', 'cicloescolars.id')
            ->where('alumnos.id',$id)
            ->where('grupos.id_ciclo_escolar',$id_session_ciclo)
            ->count();

        if($count_alumno>=1){
            $alumno = DB::table('alumnos')
            ->select('alumnos.id','alumnos.apaterno','alumnos.amaterno','alumnos.nombres','alumnos.curp','alumnos.email','alumnos.telefono','alumnos.foto','alumnos.fecha_nac','alumnos.lugar_nac','edo_civil','domicilio','ciudad','estado','cp','grupoalumnos.id_grupo','grupoalumnos.status', 'grupos.id_ciclo_escolar', 'grupos.id_nivel_escolar', 'grupos.grado_semestre', 'grupos.diferenciador_grupo','nivelescolars.id as id_nivel','grupos.id as id_grupo')
            ->leftJoin('grupoalumnos', 'alumnos.id', '=', 'grupoalumnos.id_alumno')
            ->leftJoin('grupos', 'grupoalumnos.id_grupo', '=', 'grupos.id')
            ->leftJoin('nivelescolars', 'grupos.id_nivel_escolar', '=', 'nivelescolars.id')
            ->leftJoin('cicloescolars', 'grupos.id_ciclo_escolar', '=', 'cicloescolars.id')
            ->where('alumnos.id',$id)
            ->where('grupos.id_ciclo_escolar',$id_session_ciclo)
            ->first();

            $planespago    = DB::table('cuentaasignadas')
                ->select('id_plan_pago','descripcion')
                ->distinct()
                ->join('planpagos', 'cuentaasignadas.id_plan_pago', '=', 'planpagos.id')
                ->where('cuentaasignadas.id_alumno',$id)
                ->where('cuentaasignadas.id_ciclo_escolar',$id_session_ciclo)
                ->get();

            $cuentaasignadas    = DB::table('cuentaasignadas')
                ->select('cuentaasignadas.id','cuentaasignadas.id_alumno','cuentaasignadas.id_plan_pago','cuentaasignadas.id_plan_concepto_cobro','planpagos.descripcion','planpagoconceptos.id_concepto_cobro','conceptocobros.descripcion as desc_concepto', 'planpagoconceptos.cantidad','planpagoconceptos.periodo_inicio','planpagoconceptos.periodo_vencimiento','planpagos.id as id_planpago','becaalumnos.id_beca as id_beca','becas.codigo','becas.porc_o_cant','becas.cantidad as descuento_beca','cuentaasignadas.status as status_cta','conceptocobros.id as id_conceptocobro')
                ->join('planpagos', 'cuentaasignadas.id_plan_pago', '=', 'planpagos.id')
                ->join('planpagoconceptos', 'cuentaasignadas.id_plan_concepto_cobro', '=', 'planpagoconceptos.id')
                ->join('conceptocobros', 'planpagoconceptos.id_concepto_cobro', '=', 'conceptocobros.id')
                //->leftJoin('becaalumnos','cuentaasignadas.id','=','becaalumnos.id_cuentaasignada')
                ->leftJoin('becaalumnos', function ($join) {
                    $join->on('cuentaasignadas.id', '=', 'becaalumnos.id_cuentaasignada')
                    ->join('becas', 'becaalumnos.id_beca', '=', 'becas.id');
                })
                ->where('cuentaasignadas.id_alumno',$id)
                ->where('cuentaasignadas.id_ciclo_escolar',$id_session_ciclo)
                ->distinct('cuentaasignadas.id')
                ->get();
            $cobros = DB::table('cobros')
              ->select('cobros.id as id_cobro','cobros.id_alumno','id_user','cobros.id_ciclo_escolar','id_cuenta_asignada','id_planpagoconcepto','cantidad_inicial','descuento_pp','descuento_adicional','recargo','fecha_pago','cobros.status','planpagoconceptos.periodo_vencimiento','planpagoconceptos.cantidad','planpagoconceptos.id_concepto_cobro','apaterno','amaterno','nombres','conceptocobros.descripcion','becaalumnos.id_beca','becas.codigo','becas.porc_o_cant','becas.cantidad as cant_beca','cobros.cantidad as cantidad_pagada','cobros.forma_pago','cobros.updated_at')
              ->join('cuentaasignadas', 'cobros.id_cuenta_asignada', '=', 'cuentaasignadas.id')
              ->join('planpagoconceptos', 'cuentaasignadas.id_plan_concepto_cobro', '=', 'planpagoconceptos.id')
              ->join('conceptocobros', 'planpagoconceptos.id_concepto_cobro', '=', 'conceptocobros.id')
              ->join('alumnos', 'cobros.id_alumno', '=', 'alumnos.id')
              ->leftjoin('becaalumnos', 'cobros.id_cuenta_asignada', '=', 'becaalumnos.id_cuentaasignada')
              ->leftjoin('becas', 'becaalumnos.id_beca', '=', 'becas.id')
              ->where('cobros.id_alumno',$id)
              ->where('cobros.status','cancelado')
              ->where('cobros.id_ciclo_escolar',$id_session_ciclo)
              ->get();

                //return response()->json(['cobros'=>$cobros]);
            //return $cuentaasignadas;
            //Se utiliza el resulta de la variable alumno->id_nivel para consultar solo las becas que estan destinadas para la seccion donde el alumno este inscrito.
            $opcbecas =  DB::table('becas')
                ->select('becas.id','becas.codigo','becas.descripcion','becas.porc_o_cant','becas.cantidad','becas.id_nivel','becas.id_ciclo_escolar')
                ->get();

            $becasasiganadas =  DB::table('becaalumnos')
                ->select('becaalumnos.id','becaalumnos.id_beca','becaalumnos.id_alumno','becaalumnos.id_ciclo_escolar','becaalumnos.id_cuentaasignada','becas.descripcion','conceptocobros.descripcion as desc_conceptos','becas.cantidad as cant_beca','cuentaasignadas.id as id_ctaasignada', 'conceptocobros.id as id_conceptocobro')
                ->join('becas','becaalumnos.id_beca','=','becas.id')
                ->join('cuentaasignadas','becaalumnos.id_cuentaasignada','=','cuentaasignadas.id')
                ->join('planpagoconceptos','cuentaasignadas.id_plan_concepto_cobro','=','planpagoconceptos.id')
                ->join('conceptocobros','planpagoconceptos.id_concepto_cobro','=','conceptocobros.id')
                ->where('becaalumnos.id_ciclo_escolar',$id_session_ciclo)
                ->where('becaalumnos.id_alumno',$alumno->id)
                ->get();
            
            return view("alumnos.show", compact('alumno','cuentaasignadas','planespago','count_alumno','opcbecas','becasasiganadas','cobros'));
        }else{
            $alumno = 0;
            $cuentaasignadas = 0;
            $planespago = 0;
            $opcbecas = 0;
             return view("alumnos.show", compact('alumno','cuentaasignadas','planespago','count_alumno','opcbecas'));
        }

        
    }
    public function becas(Request $request, $id){
        //return $id;
        $id_session_ciclo = session('session_cart');
        $count_alumno = DB::table('alumnos')
            ->select('alumnos.id','alumnos.apaterno','alumnos.amaterno','alumnos.nombres','alumnos.curp','alumnos.email','alumnos.telefono','alumnos.foto','alumnos.fecha_nac','alumnos.lugar_nac','edo_civil','domicilio','ciudad','estado','cp','grupoalumnos.id_grupo','grupoalumnos.status', 'grupos.id_ciclo_escolar', 'grupos.id_nivel_escolar', 'grupos.grado_semestre', 'grupos.diferenciador_grupo' )
            ->leftJoin('grupoalumnos', 'alumnos.id', '=', 'grupoalumnos.id_alumno')
            ->leftJoin('grupos', 'grupoalumnos.id_grupo', '=', 'grupos.id')
            ->leftJoin('nivelescolars', 'grupos.id_nivel_escolar', '=', 'nivelescolars.id')
            ->leftJoin('cicloescolars', 'grupos.id_ciclo_escolar', '=', 'cicloescolars.id')
            ->where('alumnos.id',$id)
            ->where('grupos.id_ciclo_escolar',$id_session_ciclo)
            ->count();
        $alumno = DB::table('alumnos')
            ->select('alumnos.id','alumnos.apaterno','alumnos.amaterno','alumnos.nombres','alumnos.curp','alumnos.email','alumnos.telefono','alumnos.foto','alumnos.fecha_nac','alumnos.lugar_nac','edo_civil','domicilio','ciudad','estado','cp','grupoalumnos.id_grupo','grupoalumnos.status', 'grupos.id_ciclo_escolar', 'grupos.id_nivel_escolar', 'grupos.grado_semestre', 'grupos.diferenciador_grupo','nivelescolars.id as id_nivel','grupos.id as id_grupo')
            ->leftJoin('grupoalumnos', 'alumnos.id', '=', 'grupoalumnos.id_alumno')
            ->leftJoin('grupos', 'grupoalumnos.id_grupo', '=', 'grupos.id')
            ->leftJoin('nivelescolars', 'grupos.id_nivel_escolar', '=', 'nivelescolars.id')
            ->leftJoin('cicloescolars', 'grupos.id_ciclo_escolar', '=', 'cicloescolars.id')
            ->where('alumnos.id',$id)
            ->where('grupos.id_ciclo_escolar',$id_session_ciclo)
            ->first();
        $cuentaasignadas    = DB::table('cuentaasignadas')
                ->select('cuentaasignadas.id','cuentaasignadas.id_alumno','cuentaasignadas.id_plan_pago','cuentaasignadas.id_plan_concepto_cobro','planpagos.descripcion','planpagoconceptos.id_concepto_cobro','conceptocobros.descripcion as desc_concepto', 'planpagoconceptos.cantidad','planpagoconceptos.periodo_inicio','planpagoconceptos.periodo_vencimiento','planpagos.id as id_planpago','becaalumnos.id_beca as id_beca','becas.codigo','becas.porc_o_cant','becas.cantidad as descuento_beca','cuentaasignadas.status as status_cta','conceptocobros.id as id_conceptocobro')
                ->join('planpagos', 'cuentaasignadas.id_plan_pago', '=', 'planpagos.id')
                ->join('planpagoconceptos', 'cuentaasignadas.id_plan_concepto_cobro', '=', 'planpagoconceptos.id')
                ->join('conceptocobros', 'planpagoconceptos.id_concepto_cobro', '=', 'conceptocobros.id')
                //->leftJoin('becaalumnos','cuentaasignadas.id','=','becaalumnos.id_cuentaasignada')
                ->leftJoin('becaalumnos', function ($join) {
                    $join->on('cuentaasignadas.id', '=', 'becaalumnos.id_cuentaasignada')
                    ->join('becas', 'becaalumnos.id_beca', '=', 'becas.id');
                })
                ->where('cuentaasignadas.id_alumno',$id)
                ->where('cuentaasignadas.id_ciclo_escolar',$id_session_ciclo)
                ->distinct('cuentaasignadas.id')
                ->get();
        $opcbecas =  DB::table('becas')
                ->select('becas.id','becas.codigo','becas.descripcion','becas.porc_o_cant','becas.cantidad','becas.id_nivel','becas.id_ciclo_escolar')
                ->get();
        $becasasiganadas =  DB::table('becaalumnos')
            ->select('becaalumnos.id','becaalumnos.id_beca','becaalumnos.id_alumno','becaalumnos.id_ciclo_escolar','becaalumnos.id_cuentaasignada','becas.descripcion','conceptocobros.descripcion as desc_conceptos','becas.cantidad as cant_beca','cuentaasignadas.id as id_ctaasignada', 'conceptocobros.id as id_conceptocobro')
            ->join('becas','becaalumnos.id_beca','=','becas.id')
            ->join('cuentaasignadas','becaalumnos.id_cuentaasignada','=','cuentaasignadas.id')
            ->join('planpagoconceptos','cuentaasignadas.id_plan_concepto_cobro','=','planpagoconceptos.id')
            ->join('conceptocobros','planpagoconceptos.id_concepto_cobro','=','conceptocobros.id')
            ->where('becaalumnos.id_ciclo_escolar',$id_session_ciclo)
            ->where('becaalumnos.id_alumno',$id)
            ->get();
            
            return view("alumnos.beca", compact('alumno','becasasiganadas','count_alumno','opcbecas','cuentaasignadas'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $id_session_ciclo = session('session_cart');
        $grupos = DB::table('grupos')
                ->select('grupos.id','id_ciclo_escolar','turno','id_nivel_escolar','grado_semestre','diferenciador_grupo','grupos.status','denominacion_grado')                
                ->join('nivelescolars', 'nivelescolars.id', '=', 'grupos.id_nivel_escolar')
                ->where('grupos.id_ciclo_escolar',$id_session_ciclo)
                ->get();

        $alumno = Alumno::findOrFail($id);

        $grupoinscrito = DB::table('grupoalumnos')
                ->select('grupoalumnos.id','id_alumno','id_grupo','grupoalumnos.status','grupoalumnos.id_grupo', 'grupos.id_ciclo_escolar', 'grupos.id_nivel_escolar', 'grupos.grado_semestre', 'grupos.diferenciador_grupo','nivelescolars.id as id_nivel','grupos.id as id_grupo')
                ->leftJoin('grupos', 'grupoalumnos.id_grupo', '=', 'grupos.id')
                ->leftJoin('nivelescolars', 'grupos.id_nivel_escolar', '=', 'nivelescolars.id')
                ->leftJoin('cicloescolars', 'grupos.id_ciclo_escolar', '=', 'cicloescolars.id')
                ->where('grupos.id_ciclo_escolar',$id_session_ciclo)
                ->where('grupoalumnos.id_alumno',$id)
                ->first();
        $planpagos =  Planpago::where('id_ciclo_escolar',$id_session_ciclo)
                    ->get();

        //cuentas asignadas
        $planespago    = DB::table('cuentaasignadas')
                ->select('id_plan_pago','descripcion')
                ->distinct()
                ->join('planpagos', 'cuentaasignadas.id_plan_pago', '=', 'planpagos.id')
                ->where('cuentaasignadas.id_alumno',$id)
                ->where('cuentaasignadas.id_ciclo_escolar',$id_session_ciclo)
                ->get();

            $cuentaasignadas    = DB::table('cuentaasignadas')
                ->select('cuentaasignadas.id','cuentaasignadas.id_alumno','cuentaasignadas.id_plan_pago','cuentaasignadas.id_plan_concepto_cobro','planpagos.descripcion','planpagoconceptos.id_concepto_cobro','conceptocobros.descripcion as desc_concepto', 'planpagoconceptos.cantidad','planpagoconceptos.periodo_inicio','planpagoconceptos.periodo_vencimiento','planpagos.id as id_planpago','becaalumnos.id_beca as id_beca','becas.codigo','becas.porc_o_cant','becas.cantidad as descuento_beca','cuentaasignadas.status as status_cta','conceptocobros.id as id_conceptocobro')
                ->join('planpagos', 'cuentaasignadas.id_plan_pago', '=', 'planpagos.id')
                ->join('planpagoconceptos', 'cuentaasignadas.id_plan_concepto_cobro', '=', 'planpagoconceptos.id')
                ->join('conceptocobros', 'planpagoconceptos.id_concepto_cobro', '=', 'conceptocobros.id')
                //->leftJoin('becaalumnos','cuentaasignadas.id','=','becaalumnos.id_cuentaasignada')
                ->leftJoin('becaalumnos', function ($join) {
                    $join->on('cuentaasignadas.id', '=', 'becaalumnos.id_cuentaasignada')
                    ->join('becas', 'becaalumnos.id_beca', '=', 'becas.id');
                })
                ->where('cuentaasignadas.id_alumno',$id)
                ->where('cuentaasignadas.id_ciclo_escolar',$id_session_ciclo)
                ->distinct('cuentaasignadas.id')
                ->get();

            //Se utiliza el resulta de la variable alumno->id_nivel para consultar solo las becas que estan destinadas para la seccion donde el alumno este inscrito.
            $opcbecas =  DB::table('becas')
                ->select('becas.id','becas.codigo','becas.descripcion','becas.porc_o_cant','becas.cantidad','becas.id_nivel','becas.id_ciclo_escolar','nivelescolars.denominacion_grado','cicloescolars.descripcion as desc_ciclo')
                ->join('nivelescolars','becas.id_nivel','=','nivelescolars.id')
                ->join('cicloescolars','becas.id_ciclo_escolar','=','cicloescolars.id')
                ->where('id_ciclo_escolar',$id_session_ciclo)
                ->where('nivelescolars.id',$alumno->id_nivel)
                ->get();

            $becasasiganadas =  DB::table('becaalumnos')
                ->select('becaalumnos.id','becaalumnos.id_beca','becaalumnos.id_alumno','becaalumnos.id_ciclo_escolar','becaalumnos.id_cuentaasignada','becas.descripcion','conceptocobros.descripcion as desc_conceptos','becas.cantidad as cant_beca','cuentaasignadas.id as id_ctaasignada', 'conceptocobros.id as id_conceptocobro')
                ->join('becas','becaalumnos.id_beca','=','becas.id')
                ->join('cuentaasignadas','becaalumnos.id_cuentaasignada','=','cuentaasignadas.id')
                ->join('planpagoconceptos','cuentaasignadas.id_plan_concepto_cobro','=','planpagoconceptos.id')
                ->join('conceptocobros','planpagoconceptos.id_concepto_cobro','=','conceptocobros.id')
                ->where('becaalumnos.id_ciclo_escolar',$id_session_ciclo)
                ->where('becaalumnos.id_alumno',$alumno->id)
                ->get();
        //fin cuentas asignadas
        return view("alumnos.edit", compact('alumno','grupos','grupoinscrito','planpagos','planespago','cuentaasignadas','opcbecas','becasasiganadas'));
    }

    public function grupo($id){
        //
        //return "ok";
        $id_session_ciclo = session('session_cart');
        $grupos = DB::table('grupos')
                ->select('grupos.id','id_ciclo_escolar','turno','id_nivel_escolar','grado_semestre','diferenciador_grupo','grupos.status','denominacion_grado')                
                ->join('nivelescolars', 'nivelescolars.id', '=', 'grupos.id_nivel_escolar')
                ->where('grupos.id_ciclo_escolar',$id_session_ciclo)
                ->get();

        $alumno = Alumno::findOrFail($id);

        $grupoinscrito = DB::table('grupoalumnos')
                ->select('grupoalumnos.id','id_alumno','id_grupo','grupoalumnos.status','grupoalumnos.id_grupo', 'grupos.id_ciclo_escolar', 'grupos.id_nivel_escolar', 'grupos.grado_semestre', 'grupos.diferenciador_grupo','nivelescolars.id as id_nivel','grupos.id as id_grupo')
                ->leftJoin('grupos', 'grupoalumnos.id_grupo', '=', 'grupos.id')
                ->leftJoin('nivelescolars', 'grupos.id_nivel_escolar', '=', 'nivelescolars.id')
                ->leftJoin('cicloescolars', 'grupos.id_ciclo_escolar', '=', 'cicloescolars.id')
                ->where('grupos.id_ciclo_escolar',$id_session_ciclo)
                ->where('grupoalumnos.id_alumno',$id)
                ->first();
        $planpagos =  Planpago::where('id_ciclo_escolar',$id_session_ciclo)
                    ->get();

        //cuentas asignadas
        $planespago    = DB::table('cuentaasignadas')
                ->select('id_plan_pago','descripcion')
                ->distinct()
                ->join('planpagos', 'cuentaasignadas.id_plan_pago', '=', 'planpagos.id')
                ->where('cuentaasignadas.id_alumno',$id)
                ->where('cuentaasignadas.id_ciclo_escolar',$id_session_ciclo)
                ->get();

            $cuentaasignadas    = DB::table('cuentaasignadas')
                ->select('cuentaasignadas.id','cuentaasignadas.id_alumno','cuentaasignadas.id_plan_pago','cuentaasignadas.id_plan_concepto_cobro','planpagos.descripcion','planpagoconceptos.id_concepto_cobro','conceptocobros.descripcion as desc_concepto', 'planpagoconceptos.cantidad','planpagoconceptos.periodo_inicio','planpagoconceptos.periodo_vencimiento','planpagos.id as id_planpago','becaalumnos.id_beca as id_beca','becas.codigo','becas.porc_o_cant','becas.cantidad as descuento_beca','cuentaasignadas.status as status_cta','conceptocobros.id as id_conceptocobro')
                ->join('planpagos', 'cuentaasignadas.id_plan_pago', '=', 'planpagos.id')
                ->join('planpagoconceptos', 'cuentaasignadas.id_plan_concepto_cobro', '=', 'planpagoconceptos.id')
                ->join('conceptocobros', 'planpagoconceptos.id_concepto_cobro', '=', 'conceptocobros.id')
                //->leftJoin('becaalumnos','cuentaasignadas.id','=','becaalumnos.id_cuentaasignada')
                ->leftJoin('becaalumnos', function ($join) {
                    $join->on('cuentaasignadas.id', '=', 'becaalumnos.id_cuentaasignada')
                    ->join('becas', 'becaalumnos.id_beca', '=', 'becas.id');
                })
                ->where('cuentaasignadas.id_alumno',$id)
                ->where('cuentaasignadas.id_ciclo_escolar',$id_session_ciclo)
                ->distinct('cuentaasignadas.id')
                ->get();

            //Se utiliza el resulta de la variable alumno->id_nivel para consultar solo las becas que estan destinadas para la seccion donde el alumno este inscrito.
            $opcbecas =  DB::table('becas')
                ->select('becas.id','becas.codigo','becas.descripcion','becas.porc_o_cant','becas.cantidad','becas.id_nivel','becas.id_ciclo_escolar','nivelescolars.denominacion_grado','cicloescolars.descripcion as desc_ciclo')
                ->join('nivelescolars','becas.id_nivel','=','nivelescolars.id')
                ->join('cicloescolars','becas.id_ciclo_escolar','=','cicloescolars.id')
                ->where('id_ciclo_escolar',$id_session_ciclo)
                ->where('nivelescolars.id',$alumno->id_nivel)
                ->get();

            $becasasiganadas =  DB::table('becaalumnos')
                ->select('becaalumnos.id','becaalumnos.id_beca','becaalumnos.id_alumno','becaalumnos.id_ciclo_escolar','becaalumnos.id_cuentaasignada','becas.descripcion','conceptocobros.descripcion as desc_conceptos','becas.cantidad as cant_beca','cuentaasignadas.id as id_ctaasignada', 'conceptocobros.id as id_conceptocobro')
                ->join('becas','becaalumnos.id_beca','=','becas.id')
                ->join('cuentaasignadas','becaalumnos.id_cuentaasignada','=','cuentaasignadas.id')
                ->join('planpagoconceptos','cuentaasignadas.id_plan_concepto_cobro','=','planpagoconceptos.id')
                ->join('conceptocobros','planpagoconceptos.id_concepto_cobro','=','conceptocobros.id')
                ->where('becaalumnos.id_ciclo_escolar',$id_session_ciclo)
                ->where('becaalumnos.id_alumno',$alumno->id)
                ->get();
        //fin cuentas asignadas
               // return "fi";
        return view("alumnos.grupo", compact('alumno','grupos','grupoinscrito','planpagos','planespago','cuentaasignadas','opcbecas','becasasiganadas'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id_session_ciclo = session('session_cart');
        $alumno = Alumno::find($id);
        $alumno->apaterno   = $request->apaterno;
        $alumno->amaterno   = $request->amaterno;
        $alumno->nombres    = $request->nombres;
        $alumno->genero     = $request->genero;
        $alumno->fecha_nac  = $request->fecha_nac;
        $alumno->lugar_nac  = '';
        $alumno->edo_civil  = '';
        $alumno->curp       = $request->curp;
        $alumno->domicilio  = $request->domicilio;
        $alumno->ciudad     = $request->ciudad;
        $alumno->estado     = $request->estado;
        $alumno->cp         = $request->cp;
        $alumno->telefono   = $request->telefono;
        $alumno->telefono2  = $request->telefono2;
        //$alumno->foto       = $request->apaterno;
        $alumno->email      = $request->email;
        $alumno->status     = $request->status;
        $alumno->nombre_tutor       = $request->nombre_tutor;
        $alumno->parentesco_tutor   = $request->parentesco_tutor;
        $alumno->telefono_tutor     = $request->telefono_tutor;
        $alumno->razon_social       = $request->razon_social;
        $alumno->rfc                = $request->rfc;
        $alumno->uso_cfdi           = $request->uso_cfdi;

        if($archivo=$request->file('foto'))
        {
            $nombreimg      = $archivo->getClientOriginalName();
            $extension      = $archivo->getClientOriginalExtension();
            $archivo->move('images', $alumno->id.'.'.$extension);
            $alumno->foto   =  $alumno->id.'.'.$extension;
        }

        $alumno->save();
        //$alumno = Alumno::findOrFail($id);
        $grupos = DB::table('grupos')
                ->select('grupos.id','id_ciclo_escolar','turno','id_nivel_escolar','grado_semestre','diferenciador_grupo','grupos.status','denominacion_grado')                
                ->join('nivelescolars', 'nivelescolars.id', '=', 'grupos.id_nivel_escolar')
                ->where('grupos.id_ciclo_escolar',$id_session_ciclo)
                ->get();
        $planpagos =  Planpago::where('id_ciclo_escolar',$id_session_ciclo)
                    ->get();

        //cuentas asignadas
        $planespago    = DB::table('cuentaasignadas')
                ->select('id_plan_pago','descripcion')
                ->distinct()
                ->join('planpagos', 'cuentaasignadas.id_plan_pago', '=', 'planpagos.id')
                ->where('cuentaasignadas.id_alumno',$id)
                ->where('cuentaasignadas.id_ciclo_escolar',$id_session_ciclo)
                ->get();
        $cuentaasignadas    = DB::table('cuentaasignadas')
                ->select('cuentaasignadas.id','cuentaasignadas.id_alumno','cuentaasignadas.id_plan_pago','cuentaasignadas.id_plan_concepto_cobro','planpagos.descripcion','planpagoconceptos.id_concepto_cobro','conceptocobros.descripcion as desc_concepto', 'planpagoconceptos.cantidad','planpagoconceptos.periodo_inicio','planpagoconceptos.periodo_vencimiento','planpagos.id as id_planpago','becaalumnos.id_beca as id_beca','becas.codigo','becas.porc_o_cant','becas.cantidad as descuento_beca','cuentaasignadas.status as status_cta','conceptocobros.id as id_conceptocobro')
                ->join('planpagos', 'cuentaasignadas.id_plan_pago', '=', 'planpagos.id')
                ->join('planpagoconceptos', 'cuentaasignadas.id_plan_concepto_cobro', '=', 'planpagoconceptos.id')
                ->join('conceptocobros', 'planpagoconceptos.id_concepto_cobro', '=', 'conceptocobros.id')
                //->leftJoin('becaalumnos','cuentaasignadas.id','=','becaalumnos.id_cuentaasignada')
                ->leftJoin('becaalumnos', function ($join) {
                    $join->on('cuentaasignadas.id', '=', 'becaalumnos.id_cuentaasignada')
                    ->join('becas', 'becaalumnos.id_beca', '=', 'becas.id');
                })
                ->where('cuentaasignadas.id_alumno',$id)
                ->where('cuentaasignadas.id_ciclo_escolar',$id_session_ciclo)
                ->distinct('cuentaasignadas.id')
                ->get();

            //Se utiliza el resulta de la variable alumno->id_nivel para consultar solo las becas que estan destinadas para la seccion donde el alumno este inscrito.
            $opcbecas =  DB::table('becas')
                ->select('becas.id','becas.codigo','becas.descripcion','becas.porc_o_cant','becas.cantidad','becas.id_nivel','becas.id_ciclo_escolar','nivelescolars.denominacion_grado','cicloescolars.descripcion as desc_ciclo')
                ->join('nivelescolars','becas.id_nivel','=','nivelescolars.id')
                ->join('cicloescolars','becas.id_ciclo_escolar','=','cicloescolars.id')
                ->where('id_ciclo_escolar',$id_session_ciclo)
                ->where('nivelescolars.id',$alumno->id_nivel)
                ->get();

            $becasasiganadas =  DB::table('becaalumnos')
                ->select('becaalumnos.id','becaalumnos.id_beca','becaalumnos.id_alumno','becaalumnos.id_ciclo_escolar','becaalumnos.id_cuentaasignada','becas.descripcion','conceptocobros.descripcion as desc_conceptos','becas.cantidad as cant_beca','cuentaasignadas.id as id_ctaasignada', 'conceptocobros.id as id_conceptocobro')
                ->join('becas','becaalumnos.id_beca','=','becas.id')
                ->join('cuentaasignadas','becaalumnos.id_cuentaasignada','=','cuentaasignadas.id')
                ->join('planpagoconceptos','cuentaasignadas.id_plan_concepto_cobro','=','planpagoconceptos.id')
                ->join('conceptocobros','planpagoconceptos.id_concepto_cobro','=','conceptocobros.id')
                ->where('becaalumnos.id_ciclo_escolar',$id_session_ciclo)
                ->where('becaalumnos.id_alumno',$alumno->id)
                ->get();
        //fin cuentas asignadas
        $grupoinscrito = DB::table('grupoalumnos')
                ->select('grupoalumnos.id','id_alumno','id_grupo','grupoalumnos.status','grupoalumnos.id_grupo', 'grupos.id_ciclo_escolar', 'grupos.id_nivel_escolar', 'grupos.grado_semestre', 'grupos.diferenciador_grupo','nivelescolars.id as id_nivel','grupos.id as id_grupo')
                ->leftJoin('grupos', 'grupoalumnos.id_grupo', '=', 'grupos.id')
                ->leftJoin('nivelescolars', 'grupos.id_nivel_escolar', '=', 'nivelescolars.id')
                ->leftJoin('cicloescolars', 'grupos.id_ciclo_escolar', '=', 'cicloescolars.id')
                ->where('grupos.id_ciclo_escolar',$id_session_ciclo)
                ->where('grupoalumnos.id_alumno',$id)
                ->first();
        return view("alumnos.grupo", compact('alumno','grupos','grupoinscrito','planpagos','planespago','cuentaasignadas','opcbecas','becasasiganadas'));
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //busca primero si tiene alguna cuenta cobrada en la bd... antes de eliminarlos
        //return "ok";
        $count_alumno = DB::table('cobros')
            ->select('cobros.id','cobros.id_alumno')
            ->where('cobros.id_alumno',$id)
            ->count();
        //busca primero si tiene alguna cuenta cobrada en la bd... antes de eliminarlos            
        if($count_alumno>=1){
            $mensaje = 'No se pudo eliminar, el alumno tiene cuentas cobradas...';
        }else{
            $alumno = Alumno::findOrFail($id);
            $alumno->delete();
            $mensaje = 'Eliminado correctamente';
        }    
        return Response()->json(['mensaje'=>$mensaje]);
    }
    public function consultaeliminar(Request $request, $id){
        $count_alumno = DB::table('cuentaasignadas')
            ->select('cuentaasignadas.id','cuentaasignadas.id_alumno')
            ->where('cuentaasignadas.id_alumno',$id)
            ->count();
        $count_alumno2 = DB::table('cobros')
            ->select('cobros.id','cobros.id_alumno')
            ->where('cobros.id_alumno',$id)
            ->count();
        //return 'cuentas: '.$count_alumno;
        //return 'cobros: '.$count_alumno2;
        return response()->json(['cuentas' => $count_alumno, 'cobros' => $count_alumno2]);
    }
    public function alumnosdetalle(Request $request)
    {


        $alumnos = DB::table('alumnos')
            ->select('a.apaterno','a.amaterno','a.nombres','a.curp','a.email','a.telefono','a.foto','grupoalumnos.id_grupo','grupoalumnos.status', 'grupos.id_ciclo_escolar', 'grupos.id_nivel_escolar', 'grupos.grado_semestre', 'grupos.diferenciador_grupo' )
            ->join('grupoalumnos', 'alumnos.id', '=', 'grupoalumnos.id_alumno')
            ->join('grupos', 'grupoalumnos.id_grupo', '=', 'grupos.id')
            ->join('nivelescolars', 'grupos.id_nivel_escolar', '=', 'nivelescolars.id')
            ->join('cicloescolars ', 'grupos.id_ciclo_escolar', '=', 'cicloescolars.id')
            ->where('grupos.id_ciclo_escolar',$id_session_ciclo)
            ->get();
       

        return view("alumnos.index", compact("alumnos"));
    }
    public function alumnosCuentasAsiganadas(Request $request, $id)
    {
        return "alumnos cuentas...";
    }
    public function printPDF(Request $request, $id){
        // This  $data array will be passed to our PDF blade
        $id_session_ciclo = session('session_cart');

        $alumno = Alumno::findOrFail($id);

        $grupoinscrito = DB::table('grupoalumnos')
                ->select('grupoalumnos.id','id_alumno','id_grupo','grupoalumnos.status','grupoalumnos.id_grupo', 'grupos.id_ciclo_escolar', 'grupos.id_nivel_escolar', 'grupos.grado_semestre', 'grupos.diferenciador_grupo','nivelescolars.id as id_nivel','grupos.id as id_grupo','grupos.turno','nivelescolars.denominacion_grado')
                ->leftJoin('grupos', 'grupoalumnos.id_grupo', '=', 'grupos.id')
                ->leftJoin('nivelescolars', 'grupos.id_nivel_escolar', '=', 'nivelescolars.id')
                ->leftJoin('cicloescolars', 'grupos.id_ciclo_escolar', '=', 'cicloescolars.id')
                ->where('grupos.id_ciclo_escolar',$id_session_ciclo)
                ->where('grupoalumnos.id_alumno',$id)
                ->first();
       
        $data = [
          'title' => 'Reporte de alumnos',
          'heading' => 'Hello from 99Points.info',
          'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
          'alumno' => $alumno,
          'grupoinscrito' => $grupoinscrito,
            ];
        
        $pdf = PDF::loadView('alumnos.pdf_view', $data);  
        
        //$pdf = PDF::loadView('alumnos.pdf_view');  
        //return $pdf->download('inscripcion.pdf');
        return $pdf->stream('inscripcion.pdf');
            //return "ok".$id;
    }
    public function ConsultaCuentas(Request $request, $id){
        $id_session_ciclo = session('session_cart');
        $planespago    = DB::table('cuentaasignadas')
                ->select('id_plan_pago','descripcion')
                ->distinct()
                ->join('planpagos', 'cuentaasignadas.id_plan_pago', '=', 'planpagos.id')
                ->where('cuentaasignadas.id_alumno',$id)
                ->where('cuentaasignadas.id_ciclo_escolar',$id_session_ciclo)
                ->get();

        $cuentaasignadas    = DB::table('cuentaasignadas')
            ->select('cuentaasignadas.id','cuentaasignadas.id_alumno','cuentaasignadas.id_plan_pago','cuentaasignadas.id_plan_concepto_cobro','planpagos.descripcion','planpagoconceptos.id_concepto_cobro','conceptocobros.descripcion as desc_concepto', 'planpagoconceptos.cantidad','planpagoconceptos.periodo_inicio','planpagoconceptos.periodo_vencimiento','planpagos.id as id_planpago','becaalumnos.id_beca as id_beca','becas.codigo','becas.porc_o_cant','becas.cantidad as descuento_beca','cuentaasignadas.status as status_cta','conceptocobros.id as id_conceptocobro')
            ->join('planpagos', 'cuentaasignadas.id_plan_pago', '=', 'planpagos.id')
            ->join('planpagoconceptos', 'cuentaasignadas.id_plan_concepto_cobro', '=', 'planpagoconceptos.id')
            ->join('conceptocobros', 'planpagoconceptos.id_concepto_cobro', '=', 'conceptocobros.id')
            //->leftJoin('becaalumnos','cuentaasignadas.id','=','becaalumnos.id_cuentaasignada')
            ->leftJoin('becaalumnos', function ($join) {
                $join->on('cuentaasignadas.id', '=', 'becaalumnos.id_cuentaasignada')
                ->join('becas', 'becaalumnos.id_beca', '=', 'becas.id');
            })
            ->where('cuentaasignadas.id_alumno',$id)
            ->where('cuentaasignadas.id_ciclo_escolar',$id_session_ciclo)
            ->distinct('cuentaasignadas.id')
            ->get();

           // return response()->json(['data' => "Hola"]); 

            return response()->json(['planespago' => $planespago, 'cuentaasignadas' => $cuentaasignadas]);
    }
    
}
