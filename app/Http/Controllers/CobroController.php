<?php

namespace App\Http\Controllers;

use App\Cobro;
use App\helpers\convertidor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Carbon\Carbon;
use App\Cuentaasignada;
use App\Cicloescolar;
use App\Planpago;
use App\Nivelescolar;
use App\Grupo;
use App\Alumno;
use App\Grupoalumno;
use App\Planpagoconcepto;
use App\Conceptocobro;
use App\Http\Requests\StoreAlumnos;
use App\Beca;
use App\Descuento;
use PDF;
use App\Exports\DeudoresExport;
use App\Exports\CobrosExportView;
use Maatwebsite\Excel\Facades\Excel;
use App\Cobroparcial;
use App\Cobrocancelado;
//use Carbon\Carbon;

class CobroController extends Controller
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
    public function exportExcel(Request $cobro, $fecha1, $fecha2){

      $id_session_ciclo   = session('session_cart');     

      $cobros = DB::table('cobros')
        ->select('cobros.id as id_cobro','cobros.id_alumno','id_user','cobros.id_ciclo_escolar','id_cuenta_asignada','id_planpagoconcepto','cantidad_inicial','descuento_pp','descuento_adicional','recargo','fecha_pago','cobros.status','planpagoconceptos.mes_pagar','planpagoconceptos.cantidad','planpagoconceptos.id_concepto_cobro','apaterno','amaterno','nombres','conceptocobros.descripcion','becaalumnos.id_beca','becas.codigo','becas.porc_o_cant','becas.cantidad as cant_beca','cobros.cantidad as cantidad_pagada','tipo_pago','cobros.forma_pago')
          ->join('cuentaasignadas', 'cobros.id_cuenta_asignada', '=', 'cuentaasignadas.id')
          ->join('planpagoconceptos', 'cuentaasignadas.id_plan_concepto_cobro', '=', 'planpagoconceptos.id')
          ->join('conceptocobros', 'planpagoconceptos.id_concepto_cobro', '=', 'conceptocobros.id')
        ->join('alumnos', 'cobros.id_alumno', '=', 'alumnos.id')
        ->leftjoin('becaalumnos', 'cobros.id_cuenta_asignada', '=', 'becaalumnos.id_cuentaasignada')
        ->leftjoin('becas', 'becaalumnos.id_beca', '=', 'becas.id')
        ->whereDate('cobros.fecha_pago','>=',$fecha1)
        ->whereDate('cobros.fecha_pago','<=',$fecha2)
       // ->where('cobros.id_ciclo_escolar',$id_session_ciclo)
        ->get();
      return Excel::download(new CobrosExportView($cobros),'cobros.xlsx');
    }
    public function exceldeudores(Request $cobro, $fecha1=null, $fecha2=null){

      $id_session_ciclo   = session('session_cart');
      $fecha_actual       = Carbon::now()->format('Y-m-d');
      $deudores           = DB::table('cuentaasignadas')
        ->select('cuentaasignadas.id', 'cuentaasignadas.id_alumno', 'cuentaasignadas.status','periodo_inicio','periodo_vencimiento','mes_pagar', 'planpagoconceptos.cantidad','alumnos.apaterno','alumnos.amaterno','alumnos.nombres','conceptocobros.descripcion','becas.descripcion as desc_beca','porc_o_cant','becas.cantidad as cant_beca', DB::raw("TIMESTAMPDIFF(MONTH, periodo_inicio, now()) as dif_fecha"),'valor_recargo')
            ->join('planpagoconceptos', 'cuentaasignadas.id_plan_concepto_cobro', '=', 'planpagoconceptos.id')
            ->join('conceptocobros','planpagoconceptos.id_concepto_cobro','=','conceptocobros.id')
            ->join('alumnos','cuentaasignadas.id_alumno','=','alumnos.id')
            ->leftjoin('grupoalumnos','alumnos.id','=','grupoalumnos.id_alumno')
            ->leftjoin('grupos','grupoalumnos.id_grupo','=','grupos.id')
            ->leftjoin('becaalumnos','cuentaasignadas.id','=','becaalumnos.id_cuentaasignada')
            ->leftjoin('becas','becaalumnos.id_beca','=','becas.id')
            ->leftJoin('politicaplanpagos','planpagoconceptos.id_plan_pago','=','politicaplanpagos.id_plan_pago')
            ->where('periodo_vencimiento','<',$fecha_actual)
            ->where('cuentaasignadas.status','!=','pagado')
            ->where('cuentaasignadas.id_ciclo_escolar','=',$id_session_ciclo)
            ->distinct('cuentaasignadas.id')
            ->get();
      //return "excel";
      return Excel::download(new DeudoresExport($deudores, $fecha_actual),'deudores.xlsx');
    }
    public function index()
    {
        //
        $fecha_actual = Carbon::now()->format('Y-m-d');
        $id_session_ciclo   = session('session_cart');
        $planpagos          =  Planpago::where('id_ciclo_escolar',$id_session_ciclo)
                    ->get();
        $alumnos = DB::table('alumnos')
                    ->select('alumnos.id','alumnos.apaterno','alumnos.amaterno','alumnos.nombres','alumnos.curp','alumnos.email','alumnos.telefono','alumnos.foto','grupoalumnos.id_grupo','grupoalumnos.status', 'grupos.id_ciclo_escolar', 'grupos.id_nivel_escolar', 'grupos.grado_semestre', 'grupos.diferenciador_grupo' )
                    ->leftJoin('grupoalumnos', 'alumnos.id', '=', 'grupoalumnos.id_alumno')
                    ->leftJoin('grupos', 'grupoalumnos.id_grupo', '=', 'grupos.id')
                    ->leftJoin('nivelescolars', 'grupos.id_nivel_escolar', '=', 'nivelescolars.id')
                    ->leftJoin('cicloescolars', 'grupos.id_ciclo_escolar', '=', 'cicloescolars.id')
                    ->where('grupoalumnos.id_ciclo_escolar',$id_session_ciclo)// se agrego para filtrar y no mostrara los nombres duplicados 15-04-2021
                    ->get();
        return view('cobros.index',compact('planpagos','alumnos','id_session_ciclo','fecha_actual'));
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
     * @param  \App\Cobro  $cobro
     * @return \Illuminate\Http\Response
     */
    public function show(Request $cobro, $id)
    {
        //
        $id_session_ciclo   = session('session_cart');     

       /* $alumnos = DB::table('cuentaasignadas')
            ->select('cuentaasignadas.id','cuentaasignadas.id_alumno','cuentaasignadas.id_plan_pago','cuentaasignadas.id_plan_concepto_cobro','planpagos.descripcion','planpagoconceptos.id as id_planpagoconceptos','planpagoconceptos.id_concepto_cobro','conceptocobros.descripcion as desc_concepto', 'planpagoconceptos.cantidad','planpagoconceptos.periodo_inicio','planpagoconceptos.periodo_vencimiento','planpagos.id as id_planpago','becaalumnos.id_beca as id_beca','becas.codigo','becas.porc_o_cant','becas.cantidad as descuento_beca','cuentaasignadas.status as status_cta','conceptocobros.id as id_conceptocobro','becas.cantidad as cant_desc_beca','grupos.turno','denominacion_grado')
                ->join('planpagos', 'cuentaasignadas.id_plan_pago', '=', 'planpagos.id')
                ->join('grupoalumnos', 'cuentaasignadas.id_alumno', '=', 'grupoalumnos.id_alumno')
                ->join('grupos', 'grupoalumnos.id_grupo', '=', 'grupos.id')
                ->join('nivelescolars', 'grupos.id_nivel_escolar', '=', 'nivelescolars.id')
                ->join('planpagoconceptos', 'cuentaasignadas.id_plan_concepto_cobro', '=', 'planpagoconceptos.id')
                ->join('conceptocobros', 'planpagoconceptos.id_concepto_cobro', '=', 'conceptocobros.id')               
                ->leftJoin('becaalumnos', function ($join) {
                    $join->on('cuentaasignadas.id', '=', 'becaalumnos.id_cuentaasignada')
                    ->join('becas', 'becaalumnos.id_beca', '=', 'becas.id');
                })
                ->where('cuentaasignadas.id_alumno',$id)
                ->where('cuentaasignadas.id_ciclo_escolar',$id_session_ciclo)
                ->distinct('cuentaasignadas.id')
                ->get();*/
        $alumnos    = DB::table('cuentaasignadas')
                ->select('cuentaasignadas.id','cuentaasignadas.id_alumno','cuentaasignadas.id_plan_pago','cuentaasignadas.id_plan_concepto_cobro','planpagos.descripcion','planpagoconceptos.id as id_planpagoconceptos','planpagoconceptos.id_concepto_cobro','conceptocobros.descripcion as desc_concepto', 'planpagoconceptos.cantidad','planpagoconceptos.periodo_inicio','planpagoconceptos.periodo_vencimiento','planpagos.id as id_planpago','becaalumnos.id_beca as id_beca','becas.codigo','becas.porc_o_cant','becas.cantidad as descuento_beca','cuentaasignadas.status as status_cta','conceptocobros.id as id_conceptocobro','becas.cantidad as cant_desc_beca')
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
                ->orderBy('conceptocobros.id', 'ASC')
                ->get();
                $descuento = DB::table('descuentos')
                ->select('id','id_cuentaasignada','id_alumno','id_ciclo_escolar','cantidad as cant_desc','observaciones','status','id_usuario')
                ->where('descuentos.id_alumno',$id)
                ->where('descuentos.id_ciclo_escolar',$id_session_ciclo)
                ->get();
        $politica = DB::table('cuentaasignadas')
            ->select('cuentaasignadas.id_alumno','politicaplanpagos.id','politicaplanpagos.id_ciclo_escolar','politicaplanpagos.id_plan_pago','dias_limite_pronto_pago','cant_porc_descuento','valor_descuento','valor_recargo','politicaplanpagos.status','cuentaasignadas.id_alumno','cuentaasignadas.id_plan_pago as id_plan_pagcta')
                ->join('politicaplanpagos', 'cuentaasignadas.id_plan_pago', '=', 'politicaplanpagos.id_plan_pago')
                ->where('cuentaasignadas.id_alumno',$id)
                ->where('politicaplanpagos.id_ciclo_escolar',$id_session_ciclo)
               // ->limit(1)
                ->distinct('id_plan_pago')
                ->get();
          $abonos  = DB::table('cobroparcials')
                ->select('cobroparcials.id_alumno','id_cuenta_asignada','cantidad_inicial','descuento_pp','descuento_adicional','recargo','fecha_pago')
                ->where('cobroparcials.id_alumno',$id)
                ->where('cobroparcials.status','!=','cancelado')
                ->where('cobroparcials.id_ciclo_escolar',$id_session_ciclo)
                ->get();
       // return $politica;     
       //return $abonos;     
        return response()->json(['data' => $alumnos,'descuento'=>$descuento, 'politica'=>$politica, 'abonos'=>$abonos]);

    }
    public function reporteCobros(Request $cobro,$fecha1,$fecha2)
    {      
        //
        $id_session_ciclo   = session('session_cart');     

        $cobros = DB::table('cobros')
          ->select('cobros.id as id_cobro','cobros.id_alumno','id_user','cobros.id_ciclo_escolar','id_cuenta_asignada','id_planpagoconcepto','cantidad_inicial','descuento_pp','descuento_adicional','recargo','fecha_pago','cobros.status','cobros.tipo_pago','planpagoconceptos.mes_pagar','planpagoconceptos.cantidad','planpagoconceptos.id_concepto_cobro','apaterno','amaterno','nombres','conceptocobros.descripcion','becaalumnos.id_beca','becas.codigo','becas.porc_o_cant','becas.cantidad as cant_beca','cobros.cantidad as cantidad_pagada','cobros.forma_pago')
          ->join('cuentaasignadas', 'cobros.id_cuenta_asignada', '=', 'cuentaasignadas.id')
          ->join('planpagoconceptos', 'cuentaasignadas.id_plan_concepto_cobro', '=', 'planpagoconceptos.id')
          ->join('conceptocobros', 'planpagoconceptos.id_concepto_cobro', '=', 'conceptocobros.id')
          ->join('alumnos', 'cobros.id_alumno', '=', 'alumnos.id')
          ->leftjoin('becaalumnos', 'cobros.id_cuenta_asignada', '=', 'becaalumnos.id_cuentaasignada')
          ->leftjoin('becas', 'becaalumnos.id_beca', '=', 'becas.id')
          ->whereDate('cobros.fecha_pago','>=',$fecha1)
          ->whereDate('cobros.fecha_pago','<=',$fecha2)
          ->where('cobros.id_ciclo_escolar',$id_session_ciclo)
          ->get();

        $cobrosparciales = DB::table('cobroparcials')->select('cobroparcials.id','cobroparcials.id_alumno','cobroparcials.id_ciclo_escolar','cobroparcials.id_cuenta_asignada','cobroparcials.id_planpagoconcepto','cobroparcials.cantidad_inicial','cobroparcials.descuento_pp','cobroparcials.descuento_adicional','cobroparcials.recargo','cobroparcials.fecha_pago','cobroparcials.cantidad_abonada','cobroparcials.forma_pago','cobroparcials.status')
          ->join('cuentaasignadas', 'cobroparcials.id_cuenta_asignada', '=', 'cuentaasignadas.id')
          ->join('planpagoconceptos', 'cuentaasignadas.id_plan_concepto_cobro', '=', 'planpagoconceptos.id')
          ->join('conceptocobros', 'planpagoconceptos.id_concepto_cobro', '=', 'conceptocobros.id')
          ->join('alumnos', 'cobroparcials.id_alumno', '=', 'alumnos.id')
          ->leftjoin('becaalumnos', 'cobroparcials.id_cuenta_asignada', '=', 'becaalumnos.id_cuentaasignada')
          ->leftjoin('becas', 'becaalumnos.id_beca', '=', 'becas.id')
          ->whereDate('cobroparcials.fecha_pago','>=',$fecha1)
          ->whereDate('cobroparcials.fecha_pago','<=',$fecha2)
          ->where('cobroparcials.id_ciclo_escolar',$id_session_ciclo)
          ->get();
        return response()->json(['cobros'=>$cobros ,'cobrosparciales'=>$cobrosparciales]);
    }
    public function reporteCobrosPDF(Request $cobro,$fecha1,$fecha2)
    {
        //
        $id_session_ciclo   = session('session_cart');     

        $cobros = DB::table('cobros')
          ->select('cobros.id as id_cobro','cobros.id_alumno','id_user','cobros.id_ciclo_escolar','id_cuenta_asignada','id_planpagoconcepto','cantidad_inicial','descuento_pp','descuento_adicional','recargo','fecha_pago','cobros.status','planpagoconceptos.mes_pagar','planpagoconceptos.cantidad','planpagoconceptos.id_concepto_cobro','apaterno','amaterno','nombres','conceptocobros.descripcion','becaalumnos.id_beca','becas.codigo','becas.porc_o_cant','becas.cantidad as cant_beca','cobros.cantidad as cantidad_pagada','cobros.tipo_pago','cobros.forma_pago')
          ->join('cuentaasignadas', 'cobros.id_cuenta_asignada', '=', 'cuentaasignadas.id')
          ->join('planpagoconceptos', 'cuentaasignadas.id_plan_concepto_cobro', '=', 'planpagoconceptos.id')
          ->join('conceptocobros', 'planpagoconceptos.id_concepto_cobro', '=', 'conceptocobros.id')
          ->join('alumnos', 'cobros.id_alumno', '=', 'alumnos.id')
          ->leftjoin('becaalumnos', 'cobros.id_cuenta_asignada', '=', 'becaalumnos.id_cuentaasignada')
          ->leftjoin('becas', 'becaalumnos.id_beca', '=', 'becas.id')
          ->whereDate('cobros.fecha_pago','>=',$fecha1)
          ->whereDate('cobros.fecha_pago','<=',$fecha2)
         // ->where('cobros.id_ciclo_escolar',$id_session_ciclo)
          ->get();

          $data = [
          'title' => 'First PDF for Medium',
          'heading' => 'Hello from 99Points.info',
          'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
          'cobros'  => $cobros,
          'fecha1'  => $fecha1,
          'fecha2'  => $fecha2,          
            ];
        //se asigna valor en punto de hoja tamaño carta, orientacion horizontal.
        //$pdf = PDF::loadView('cobros.reportepdf', $data)->setPaper(array(0,0,612.0,792.0,0), 'landscape');
        $pdf = PDF::loadView('cobros.reportepdf', $data);
        return $pdf->stream();('reportecobros.pdf');
    }
    public function reportedeudoresPDF(Request $request,$fecha1 = null,$fecha2=null)
    {
        //
      $id_session_ciclo   = session('session_cart');
      $fecha_actual       = Carbon::now()->format('Y-m-d');
      $deudores           = DB::table('cuentaasignadas')
        ->select('cuentaasignadas.id', 'cuentaasignadas.id_alumno', 'cuentaasignadas.status','periodo_inicio','periodo_vencimiento','mes_pagar', 'planpagoconceptos.cantidad','alumnos.apaterno','alumnos.amaterno','alumnos.nombres','conceptocobros.descripcion','becas.descripcion as desc_beca','porc_o_cant','becas.cantidad as cant_beca', DB::raw("TIMESTAMPDIFF(MONTH, periodo_inicio, now()) as dif_fecha"),'valor_recargo')
            ->join('planpagoconceptos', 'cuentaasignadas.id_plan_concepto_cobro', '=', 'planpagoconceptos.id')
            ->join('conceptocobros','planpagoconceptos.id_concepto_cobro','=','conceptocobros.id')
            ->join('alumnos','cuentaasignadas.id_alumno','=','alumnos.id')
            ->leftjoin('grupoalumnos','alumnos.id','=','grupoalumnos.id_alumno')
            ->leftjoin('grupos','grupoalumnos.id_grupo','=','grupos.id')
            ->leftjoin('becaalumnos','cuentaasignadas.id','=','becaalumnos.id_cuentaasignada')
            ->leftjoin('becas','becaalumnos.id_beca','=','becas.id')
            ->leftJoin('politicaplanpagos','planpagoconceptos.id_plan_pago','=','politicaplanpagos.id_plan_pago')
            ->where('periodo_vencimiento','<',$fecha_actual)
            ->where('cuentaasignadas.status','!=','pagado')
            ->where('cuentaasignadas.id_ciclo_escolar','=',$id_session_ciclo)
            ->distinct('cuentaasignadas.id')
            ->get();

          $data = [
          'title' => 'Deudores PDF',
          'heading' => 'Resultados',
          'content' => 'ok',
          'deudores'          => $deudores,
          'id_session_ciclo'  => $id_session_ciclo,
          'fecha_actual'      => $fecha_actual,
            ];
        //se asigna valor en punto de hoja tamaño carta, orientacion horizontal.        
        $pdf = PDF::loadView('cobros.reportedeudores', $data);
        return $pdf->stream();('reportedeudores.pdf');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cobro  $cobro
     * @return \Illuminate\Http\Response
     */
    public function edit(Cobro $cobro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cobro  $cobro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cobro $cobro)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cobro  $cobro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cobro $cobro)
    {
        //
    }  
    public function reporte(Cobro $cobro)
    {
      $id_session_ciclo   = session('session_cart');
      $fecha_actual       = Carbon::now()->format('Y-m-d');
      return view('cobros.reporte',compact('id_session_ciclo','fecha_actual'));
    }
    public function deudores(Cobro $cobro)
    {
      $id_session_ciclo   = session('session_cart');
      $fecha_actual       = Carbon::now()->format('Y-m-d');
      $deudores           = DB::table('cuentaasignadas')
        ->select('cuentaasignadas.id', 'cuentaasignadas.id_alumno', 'cuentaasignadas.status','periodo_inicio','periodo_vencimiento','mes_pagar', 'planpagoconceptos.cantidad','alumnos.apaterno','alumnos.amaterno','alumnos.nombres','conceptocobros.descripcion','becas.descripcion as desc_beca','porc_o_cant','becas.cantidad as cant_beca', DB::raw("TIMESTAMPDIFF(MONTH, periodo_inicio, now()) as dif_fecha"),'valor_recargo')
            ->join('planpagoconceptos', 'cuentaasignadas.id_plan_concepto_cobro', '=', 'planpagoconceptos.id')
            ->join('conceptocobros','planpagoconceptos.id_concepto_cobro','=','conceptocobros.id')
            ->join('alumnos','cuentaasignadas.id_alumno','=','alumnos.id')
            ->leftjoin('grupoalumnos','alumnos.id','=','grupoalumnos.id_alumno')
            ->leftjoin('grupos','grupoalumnos.id_grupo','=','grupos.id')
            ->leftjoin('becaalumnos','cuentaasignadas.id','=','becaalumnos.id_cuentaasignada')
            ->leftjoin('becas','becaalumnos.id_beca','=','becas.id')
            ->leftJoin('politicaplanpagos','planpagoconceptos.id_plan_pago','=','politicaplanpagos.id_plan_pago')
            ->where('periodo_vencimiento','<',$fecha_actual)
            ->where('cuentaasignadas.status','!=','pagado')
            ->where('cuentaasignadas.id_ciclo_escolar','=',$id_session_ciclo)
            ->distinct('cuentaasignadas.id')
            ->get();
        //return $deudores;
         // return Carbon::now()->diffForHumans(); 
      return view('cobros.deudores',compact('id_session_ciclo','deudores','fecha_actual'));
          //  return $deudores;
    }   
    public function guardarCobro(Request $request, $datos)
    {
        $id_session_ciclo   = session('session_cart');
        $contador = 0;
        //$array = response()->json($datos);
        $array = json_decode($datos);

        foreach ($array->datos as $row) {
            
            $cobro = new Cobro; 
            $cobro->id_alumno               = $row->id_alumno;
            $cobro->id_user                 = $row->id_usuario;
            $cobro->id_ciclo_escolar        = $id_session_ciclo;
            $cobro->id_cuenta_asignada      = $row->id_cuenta_asignada;
            $cobro->id_planpagoconcepto     = $row->id_planpagoconceptos;
            $cobro->cantidad_inicial        = $row->cantidad_inicial;
            $cobro->descuento_pp            = $row->descuento_pp;
            $cobro->descuento_adicional     = $row->descuento_adicional;
            $cobro->recargo                 = $row->recargo;
            $cobro->fecha_pago              = $row->fecha_pago;
            $cobro->tipo_pago               = 'completo';
            $cobro->cantidad                = $row->cantidad;
            $cobro->forma_pago              = $row->forma_pago;
            $cobro->status                  = 'pagado';
            $cobro->save();
            $contador++;

            $cuentaasignada = Cuentaasignada::find($row->id_cuenta_asignada);
            $cuentaasignada->status   = 'pagado';            
            $cuentaasignada->save();
        }
        return response()->json(['data' => "Pagado correctamente:".$contador]); 
    }
    public function printPDF(Request $Cobro, $id, $bandera){
        // This  $data array will be passed to our PDF blade

        $id_session_ciclo   = session('session_cart');    

        $cobro      = DB::table('cobros')
            ->select('id','id_alumno','id_user','id_ciclo_escolar','id_cuenta_asignada','id_planpagoconcepto','cantidad_inicial','descuento_pp','descuento_adicional','recargo','fecha_pago','status','cantidad','tipo_pago')
                ->where('id_cuenta_asignada',$id)
                ->where('id_ciclo_escolar',$id_session_ciclo)
                ->where('status','pagado')
                ->orderBy('id', 'desc')
                ->get();
    /*SELECT SUM(cantidad) as total_pagado FROM `cobros` WHERE id_cuenta_asignada=183*/
        //return $cobro;
        $total_pagado  = DB::table('cobros')
            ->select( DB::raw('SUM(cantidad) as total_pagado'))
                ->where('id_cuenta_asignada',$id)
                ->where('id_ciclo_escolar',$id_session_ciclo)
                ->where('status','pagado')
                ->first();

        $alumnos = DB::table('cuentaasignadas')
            ->select('cuentaasignadas.id as id_cta_asiganada','cuentaasignadas.id_alumno','cuentaasignadas.id_plan_pago','cuentaasignadas.id_plan_concepto_cobro','planpagos.descripcion','planpagoconceptos.id as id_planpagoconceptos','planpagoconceptos.id_concepto_cobro','conceptocobros.descripcion as desc_concepto', 'planpagoconceptos.cantidad','planpagoconceptos.periodo_inicio','planpagoconceptos.periodo_vencimiento','planpagos.id as id_planpago','becaalumnos.id_beca as id_beca','becas.codigo','becas.porc_o_cant','becas.cantidad as descuento_beca','cuentaasignadas.status as status_cta','conceptocobros.id as id_conceptocobro','grupos.turno','grupos.grado_semestre','grupos.diferenciador_grupo','denominacion_grado')
                ->join('planpagos', 'cuentaasignadas.id_plan_pago', '=', 'planpagos.id')
                ->join('grupoalumnos', 'cuentaasignadas.id_alumno', '=', 'grupoalumnos.id_alumno')
                ->join('grupos', 'grupoalumnos.id_grupo', '=', 'grupos.id')
                ->join('nivelescolars', 'grupos.id_nivel_escolar', '=', 'nivelescolars.id')
                ->join('planpagoconceptos', 'cuentaasignadas.id_plan_concepto_cobro', '=', 'planpagoconceptos.id')
                ->join('conceptocobros', 'planpagoconceptos.id_concepto_cobro', '=', 'conceptocobros.id')
                /*->leftjoin('becaalumnos', 'becaalumnos.id_cuentaasignada', '=', 'cuentaasignadas.id')
                ->leftjoin('becas', 'becaalumnos.id_beca', '=', 'becas.id') */              
                ->leftJoin('becaalumnos', function ($join) {
                    $join->on('cuentaasignadas.id', '=', 'becaalumnos.id_cuentaasignada')
                    ->join('becas', 'becaalumnos.id_beca', '=', 'becas.id');
                })
                ->where('cuentaasignadas.id',$id)
                ->where('grupoalumnos.id_ciclo_escolar',$id_session_ciclo)
                ->where('cuentaasignadas.id_ciclo_escolar',$id_session_ciclo)
                ->distinct('cuentaasignadas.id')
                ->first();
        $datoalumno  = DB::table('alumnos')
            ->select('apaterno','amaterno','nombres')
                ->join('cuentaasignadas', 'alumnos.id', '=', 'cuentaasignadas.id_alumno')                
                ->where('cuentaasignadas.id',$id)
                ->where('cuentaasignadas.id_ciclo_escolar',$id_session_ciclo)
                ->first();
        //$numero=999.00;
       // $valor = Convertidor::numtoletras($numero);

        $data = [
          'title' => 'First PDF for Medium',
          'heading' => 'Hello from 99Points.info',
          'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
          'alumno' => $alumnos,
          'cobro'  => $cobro,          
          'datoalumno' => $datoalumno,
          'bandera' => $bandera,
          'total_pagado' => $total_pagado,  
            ];
        
        $pdf = PDF::loadView('cobros.pdf_view', $data);  
        return $pdf->stream();('cuenta_pagada.pdf');

    }
    public function printPDFcancelado(Request $Cobro, $id, $idcta){
        // This  $data array will be passed to our PDF blade

        $id_session_ciclo   = session('session_cart');    

        $cobro      = DB::table('cobros')
            ->select('id','id_alumno','id_user','id_ciclo_escolar','id_cuenta_asignada','id_planpagoconcepto','cantidad_inicial','descuento_pp','descuento_adicional','recargo','fecha_pago','status','cantidad','tipo_pago','updated_at')
                ->where('id',$id)
                ->orderBy('id', 'desc')
                ->get();
        $cobro_cancelado = DB::table('cobrocancelados')
            ->select('id','id_cuenta_asignacion','motivo','id_cobro')
                ->where('id_cuenta_asignacion',$idcta)
                ->first();
    /*SELECT SUM(cantidad) as total_pagado FROM `cobros` WHERE id_cuenta_asignada=183*/
        //return $cobro;
        $total_pagado  = DB::table('cobros')
            ->select( DB::raw('SUM(cantidad) as total_pagado'))
                ->where('id',$id)
                ->first();

        $alumnos = DB::table('cuentaasignadas')
            ->select('cuentaasignadas.id as id_cta_asiganada','cuentaasignadas.id_alumno','cuentaasignadas.id_plan_pago','cuentaasignadas.id_plan_concepto_cobro','planpagos.descripcion','planpagoconceptos.id as id_planpagoconceptos','planpagoconceptos.id_concepto_cobro','conceptocobros.descripcion as desc_concepto', 'planpagoconceptos.cantidad','planpagoconceptos.periodo_inicio','planpagoconceptos.periodo_vencimiento','planpagos.id as id_planpago','becaalumnos.id_beca as id_beca','becas.codigo','becas.porc_o_cant','becas.cantidad as descuento_beca','cuentaasignadas.status as status_cta','conceptocobros.id as id_conceptocobro','grupos.turno','grupos.grado_semestre','grupos.diferenciador_grupo','denominacion_grado')
                ->join('planpagos', 'cuentaasignadas.id_plan_pago', '=', 'planpagos.id')
                ->join('grupoalumnos', 'cuentaasignadas.id_alumno', '=', 'grupoalumnos.id_alumno')
                ->join('grupos', 'grupoalumnos.id_grupo', '=', 'grupos.id')
                ->join('nivelescolars', 'grupos.id_nivel_escolar', '=', 'nivelescolars.id')
                ->join('planpagoconceptos', 'cuentaasignadas.id_plan_concepto_cobro', '=', 'planpagoconceptos.id')
                ->join('conceptocobros', 'planpagoconceptos.id_concepto_cobro', '=', 'conceptocobros.id')
                /*->leftjoin('becaalumnos', 'becaalumnos.id_cuentaasignada', '=', 'cuentaasignadas.id')
                ->leftjoin('becas', 'becaalumnos.id_beca', '=', 'becas.id') */              
                ->leftJoin('becaalumnos', function ($join) {
                    $join->on('cuentaasignadas.id', '=', 'becaalumnos.id_cuentaasignada')
                    ->join('becas', 'becaalumnos.id_beca', '=', 'becas.id');
                })
                ->where('cuentaasignadas.id',$idcta)
                ->where('grupoalumnos.id_ciclo_escolar',$id_session_ciclo)
                ->where('cuentaasignadas.id_ciclo_escolar',$id_session_ciclo)
                ->distinct('cuentaasignadas.id')
                ->first();
        $datoalumno  = DB::table('alumnos')
            ->select('apaterno','amaterno','nombres')
                ->join('cuentaasignadas', 'alumnos.id', '=', 'cuentaasignadas.id_alumno')                
                ->where('cuentaasignadas.id',$idcta)
                ->where('cuentaasignadas.id_ciclo_escolar',$id_session_ciclo)
                ->first();
        //$numero=999.00;
       // $valor = Convertidor::numtoletras($numero);

        $data = [
          'title' => 'First PDF for Medium',
          'heading' => 'Hello from 99Points.info',
          'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
          'alumno' => $alumnos,
          'cobro'  => $cobro,          
          'datoalumno' => $datoalumno,
          'total_pagado' => $total_pagado,
          'cobro_cancelado' => $cobro_cancelado,
            ];
        
        $pdf = PDF::loadView('cobros.pdfcancelado', $data);  
        return $pdf->stream();('cuenta_pagada.pdf');

    }
    public function cuentasPDF(Request $Cobro, $id)
    {
        $id_session_ciclo   = session('session_cart');    
        $cobro      = DB::table('cobros')
            ->select('id','id_alumno','id_user','id_ciclo_escolar','id_cuenta_asignada','id_planpagoconcepto','cantidad_inicial','descuento_pp','descuento_adicional','recargo','fecha_pago','status')
                ->where('id_cuenta_asignada',$id)
                ->where('id_ciclo_escolar',$id_session_ciclo)
                ->first();

        $alumnos = DB::table('cuentaasignadas')
            ->select('cuentaasignadas.id as id_cta_asiganada','cuentaasignadas.id_alumno','cuentaasignadas.id_plan_pago','cuentaasignadas.id_plan_concepto_cobro','planpagos.descripcion','planpagoconceptos.id as id_planpagoconceptos','planpagoconceptos.id_concepto_cobro','conceptocobros.descripcion as desc_concepto', 'planpagoconceptos.cantidad','planpagoconceptos.periodo_inicio','planpagoconceptos.periodo_vencimiento','planpagos.id as id_planpago','becaalumnos.id_beca as id_beca','becas.codigo','becas.porc_o_cant','becas.cantidad as descuento_beca','cuentaasignadas.status as status_cta','conceptocobros.id as id_conceptocobro','becas.cantidad as cant_desc_beca','grupos.turno','denominacion_grado')
                ->join('planpagos', 'cuentaasignadas.id_plan_pago', '=', 'planpagos.id')
                ->join('grupoalumnos', 'cuentaasignadas.id_alumno', '=', 'grupoalumnos.id_alumno')
                ->join('grupos', 'grupoalumnos.id_grupo', '=', 'grupos.id')
                ->join('nivelescolars', 'grupos.id_nivel_escolar', '=', 'nivelescolars.id')
                ->join('planpagoconceptos', 'cuentaasignadas.id_plan_concepto_cobro', '=', 'planpagoconceptos.id')
                ->join('conceptocobros', 'planpagoconceptos.id_concepto_cobro', '=', 'conceptocobros.id')               
                ->leftJoin('becaalumnos', function ($join) {
                    $join->on('cuentaasignadas.id', '=', 'becaalumnos.id_cuentaasignada')
                    ->join('becas', 'becaalumnos.id_beca', '=', 'becas.id');
                })
                ->where('cuentaasignadas.id',$id)
                ->where('cuentaasignadas.id_ciclo_escolar',$id_session_ciclo)
                ->distinct('cuentaasignadas.id')
                ->first();
        $datoalumno  = DB::table('alumnos')
            ->select('apaterno','amaterno','nombres')
                ->join('cuentaasignadas', 'alumnos.id', '=', 'cuentaasignadas.id_alumno')                
                ->where('cuentaasignadas.id',$id)
                ->where('cuentaasignadas.id_ciclo_escolar',$id_session_ciclo)
                ->first();
        //$numero=999.00;
       // $valor = Convertidor::numtoletras($numero);

        $data = [
          'title' => 'First PDF for Medium',
          'heading' => 'Hello from 99Points.info',
          'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
          'alumno' => $alumnos,
          'cobro'  => $cobro,          
          'datoalumno' => $datoalumno,  
            ];
        
        $pdf = PDF::loadView('cobros.cuentaspdf_view', $data);  
        return $pdf->download('cuentaasignadas.pdf');
    }  
    public function cuentaPagada(Request $cobro, $id)
    {
        $id_session_ciclo   = session('session_cart');    

        $cobro      = DB::table('cobros')
            ->select('id','id_alumno','id_user','id_ciclo_escolar','id_cuenta_asignada','id_planpagoconcepto','cantidad_inicial','descuento_pp','descuento_adicional','recargo','fecha_pago','status','cantidad')
                ->where('id_cuenta_asignada',$id)
                ->where('id_ciclo_escolar',$id_session_ciclo)
                ->first();
        //return $cobro;
      /*  $cobroparcial = DB::table('cobros')
            ->select('id','id_alumno','id_user','id_ciclo_escolar','id_cuenta_asignada','id_planpagoconcepto','cantidad_inicial','descuento_pp','descuento_adicional','recargo','fecha_pago','status')
                ->where('id_cuenta_asignada',$id)
                ->where('id_ciclo_escolar',$id_session_ciclo)
                ->first();*/
        $alumnos      = DB::table('cuentaasignadas')
            ->select('cuentaasignadas.id as id_cta_asiganada','cuentaasignadas.id_alumno','cuentaasignadas.id_plan_pago','cuentaasignadas.id_plan_concepto_cobro','planpagos.descripcion','planpagoconceptos.id as id_planpagoconceptos','planpagoconceptos.id_concepto_cobro','conceptocobros.descripcion as desc_concepto', 'planpagoconceptos.cantidad','planpagoconceptos.periodo_inicio','planpagoconceptos.periodo_vencimiento','planpagos.id as id_planpago','becaalumnos.id_beca as id_beca','becas.codigo','becas.porc_o_cant','becas.cantidad as descuento_beca','cuentaasignadas.status as status_cta','conceptocobros.id as id_conceptocobro','becas.cantidad as cant_desc_beca','grupos.turno','denominacion_grado')
                ->join('planpagos', 'cuentaasignadas.id_plan_pago', '=', 'planpagos.id')
                ->join('grupoalumnos', 'cuentaasignadas.id_alumno', '=', 'grupoalumnos.id_alumno')
                ->join('grupos', 'grupoalumnos.id_grupo', '=', 'grupos.id')
                ->join('nivelescolars', 'grupos.id_nivel_escolar', '=', 'nivelescolars.id')
                ->join('planpagoconceptos', 'cuentaasignadas.id_plan_concepto_cobro', '=', 'planpagoconceptos.id')
                ->join('conceptocobros', 'planpagoconceptos.id_concepto_cobro', '=', 'conceptocobros.id')               
                ->leftJoin('becaalumnos', function ($join) {
                    $join->on('cuentaasignadas.id', '=', 'becaalumnos.id_cuentaasignada')
                    ->join('becas', 'becaalumnos.id_beca', '=', 'becas.id');
                })
                ->where('cuentaasignadas.id',$id)
                ->where('cuentaasignadas.id_ciclo_escolar',$id_session_ciclo)
                ->distinct('cuentaasignadas.id')
                ->first();

        return response()->json(['dato' => $cobro, 'dato2' => $alumnos]);
        
    }
    public function carnetpagoPDF(Request $Cobro, $id){
        // This  $data array will be passed to our PDF blade

        $id_session_ciclo   = session('session_cart');     
        $datoalumno = DB::table('alumnos')->where('id',$id)->first();
        $alumnos    = DB::table('cuentaasignadas')
                ->select('cuentaasignadas.id','cuentaasignadas.id_alumno','cuentaasignadas.id_plan_pago','cuentaasignadas.id_plan_concepto_cobro','planpagos.descripcion','planpagoconceptos.id as id_planpagoconceptos','planpagoconceptos.id_concepto_cobro','conceptocobros.descripcion as desc_concepto', 'planpagoconceptos.cantidad','planpagoconceptos.periodo_inicio','planpagoconceptos.periodo_vencimiento','planpagos.id as id_planpago','becaalumnos.id_beca as id_beca','becas.codigo','becas.porc_o_cant','becas.cantidad as descuento_beca','cuentaasignadas.status as status_cta','conceptocobros.id as id_conceptocobro','becas.cantidad as cant_desc_beca')
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
                ->orderBy('conceptocobros.id', 'ASC')
                ->get();
                $descuento = DB::table('descuentos')
                ->select('id','id_cuentaasignada','id_alumno','id_ciclo_escolar','cantidad as cant_desc','observaciones','status','id_usuario')
                ->where('descuentos.id_alumno',$id)
                ->where('descuentos.id_ciclo_escolar',$id_session_ciclo)
                ->get();

                $descuento = DB::table('descuentos')
                ->select('id','id_cuentaasignada','id_alumno','id_ciclo_escolar','cantidad as cant_desc','observaciones','status','id_usuario')
                ->where('descuentos.id_alumno',$id)
                ->where('descuentos.id_ciclo_escolar',$id_session_ciclo)
                ->get();
        $politica = DB::table('cuentaasignadas')
            ->select('cuentaasignadas.id_alumno','politicaplanpagos.id','politicaplanpagos.id_ciclo_escolar','politicaplanpagos.id_plan_pago','dias_limite_pronto_pago','cant_porc_descuento','valor_descuento','valor_recargo','politicaplanpagos.status','cuentaasignadas.id_alumno','cuentaasignadas.id_plan_pago as id_plan_pagcta')
                ->join('politicaplanpagos', 'cuentaasignadas.id_plan_pago', '=', 'politicaplanpagos.id_plan_pago')
                ->where('cuentaasignadas.id_alumno',$id)
                ->where('politicaplanpagos.id_ciclo_escolar',$id_session_ciclo)
               // ->limit(1)
                ->distinct('id_plan_pago')
                ->get();
       // return $politica;        
      //  return response()->json(['data' => $alumnos,'descuento'=>$descuento, 'politica'=>$politica]);

        $data = [
          'title' => 'Carnet de pagos',
          'heading' => 'ok',
          'content' => 'Carnet de pagos del alumno.',
          'alumno' => $alumnos,      
          'politica' => $politica,
          'datoalumno' => $datoalumno,  
            ];
        
        $pdf = PDF::loadView('cobros.carnetpagoPDF', $data);  
        return $pdf->stream();('carnetpagoPDF.pdf');
    }
    public function parcialidad(Request $request, $id){
      $cobro_consulta = DB::table('cobros')
            ->select('id','id_cuenta_asignada')
                ->where('id_cuenta_asignada',$id)
                ->where('status','pagado')
                ->first();
      //$id = $cobro_consulta->id_cuenta_asignada;
      $id_session_ciclo   = session('session_cart');  
      $cobro    = DB::table('cuentaasignadas')
                ->select('cuentaasignadas.id','cuentaasignadas.id_alumno','cuentaasignadas.id_plan_pago','cuentaasignadas.id_plan_concepto_cobro','planpagoconceptos.cantidad')
                ->join('planpagoconceptos', 'cuentaasignadas.id_plan_concepto_cobro', '=', 'planpagoconceptos.id')
                ->where('cuentaasignadas.id',$id)
                ->where('cuentaasignadas.id_ciclo_escolar',$id_session_ciclo)
                ->first();
      $abonos   = DB::table('cobroparcials')
                ->select('cobroparcials.id_alumno', DB::raw('SUM(cantidad_abonada) as total_abonado'),DB::raw('count(cantidad_abonada) as total_abonos'))
                ->where('cobroparcials.id_cuenta_asignada',$id)
                ->where('cobroparcials.id_ciclo_escolar',$id_session_ciclo)
                ->where('cobroparcials.status','!=','cancelado')
                ->groupBy('id_alumno')
                ->get();
      $contabono   = DB::table('cobroparcials')
                ->select('cobroparcials.id_alumno')
                ->where('cobroparcials.id_cuenta_asignada',$id)
                ->where('cobroparcials.id_ciclo_escolar',$id_session_ciclo)
                ->groupBy('id_alumno')
                ->count();
      return response()->json(['dato' => $cobro, 'abono' => $abonos,'contabono'=>$contabono, 'cobro_consulta'=> $cobro_consulta]);
    }
    public function cancelar(Request $reques, $id, $motivo){
      $cobro_consulta = DB::table('cobros')
            ->select('id','id_cuenta_asignada','tipo_pago','fecha_pago','cantidad')
                ->where('id',$id)
                ->first();
      //return response()->json(['data' => $cobro_consulta->tipo_pago]);
      if($cobro_consulta->tipo_pago == 'completo'){
          $id_cobro     = $cobro_consulta->id;
          $id_cta_asignada = $cobro_consulta->id_cuenta_asignada;
          $cobrocancelado = new Cobrocancelado; 
          $cobrocancelado->id_cuenta_asignacion   = $id_cta_asignada;
          $cobrocancelado->motivo                 = $motivo;
          $cobrocancelado->id_cobro               = $id_cobro;
          $cobrocancelado->save();

          $cuentaasignada = Cuentaasignada::find($id_cta_asignada);
          $cuentaasignada->status   = 'activo';
          $cuentaasignada->save();

          $cobros = Cobro::where('id',$id_cobro )
                  ->update(['status' => 'cancelado']);
          
          return redirect('/cobros/reporte/');  
      }else{
          $id_cobro       = $cobro_consulta->id;
          $id_cta_asignada= $cobro_consulta->id_cuenta_asignada;
          $fecha_pago     = $cobro_consulta->fecha_pago;
          $cantidad       = $cobro_consulta->cantidad;
          $cobrocancelado = new Cobrocancelado; 
          $cobrocancelado->id_cuenta_asignacion   = $id_cta_asignada;
          $cobrocancelado->motivo                 = $motivo;
          $cobrocancelado->id_cobro               = $id_cobro;
          $cobrocancelado->save();

          $cobros = Cobro::where('id',$id_cobro )
                  ->update(['status' => 'cancelado']);

          $cobrosparciales = Cobroparcial::where(['id_cuenta_asignada'=> $id_cta_asignada, 'fecha_pago'=>$fecha_pago, 'cantidad_abonada'=>$cantidad])
                  ->update(['status' => 'cancelado']);
          $countcobrosparciales = Cobroparcial::where(['id_cuenta_asignada'=> $id_cta_asignada,'status'=>'abonado'])->get();
          $contador = $countcobrosparciales->count();

          if($contador==0){
            $cuentaasignada = Cuentaasignada::find($id_cta_asignada);
            $cuentaasignada->status   = 'abonado';
            $cuentaasignada->save();
          }
          return redirect('/cobros/reporte/');
      }
      
    }
}
