<?php

namespace App\Http\Controllers;

use App\Planpago;
use App\Planpagoconcepto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PlanpagoController extends Controller
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
        $id_session_ciclo = session('session_cart');
        $planpagos =  Planpago::where('id_ciclo_escolar',$id_session_ciclo)
                    ->get();
        return view('planpago.index',compact('planpagos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('planpago.create');
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
        $id_session_ciclo = session('session_cart');
        $planapago = new Planpago; 

        $planapago->codigo          = $request->codigo;
        $planapago->descripcion     = $request->descripcion;
        $planapago->periocidad      = $request->periocidad;
        $planapago->status          = 'activo';
        $planapago->id_ciclo_escolar= $id_session_ciclo;
        $planapago->save();

        return redirect("/planpago");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Planpago  $planpago
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //
        $planpago = Planpago::findOrFail($id);
        $conceptos = DB::table('planpagoconceptos')
                    ->select('planpagoconceptos.id','id_concepto_cobro','id_plan_pago','anio_corresponde','mes_pagar','no_parcialidad','periodo_inicio','periodo_vencimiento','cantidad', 'conceptocobros.descripcion',DB::raw("CONCAT('$ ',planpagoconceptos.cantidad) as precio"))
                    ->join('conceptocobros', 'planpagoconceptos.id_concepto_cobro', '=', 'conceptocobros.id')
                    ->join('planpagos', 'planpagoconceptos.id_plan_pago', '=', 'planpagos.id')
                    ->where('id_plan_pago',$id)
                    ->get();
        //return $conceptos;
        //return response()->json(['data' => $alumnos,'descuento'=>$descuento, 'politica'=>$politica, 'abonos'=>$abonos]);
        return response()->json(['data' => $planpago,'conceptos'=>$conceptos]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Planpago  $planpago
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $planpago = Planpago::findOrFail($id);
        return view('planpago.edit',compact('planpago'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Planpago  $planpago
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $planpago = Planpago::findOrFail($id);
        $planpago->update($request->all());
        return redirect("/planpago");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Planpago  $planpago
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $count_planpagoconcepto = DB::table('planpagoconceptos')
            ->select('id')            
            ->where('id_plan_pago',$id)
            ->count();
        if($count_planpagoconcepto>0){
            return "Existen conceptos de pago en el plan!!";
        }else{
            $planpago = Planpago::findOrFail($id);
            $planpago->delete();
            return redirect("/planpago");
        }  
    }

    public function listarplanxciclo(Request $request, $id_ciclo){
        if(request()->ajax()){
            return datatables()->of(DB::table('planpagos')
                ->select('id','codigo','descripcion','periocidad')
                ->where('id_ciclo_escolar',$id_ciclo)
                ->get())
            ->addColumn('action', function($data){
                    $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-default">Copiar conceptos</button>';
                    $button .= '&nbsp;&nbsp;';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);

        }
    }
// funcion para clonar el plan de pagos con sus conceptoos
    public function clonarplan(Request $request, $id_plan, $codigo, $desc, $per){
        //$planpago = Planpago::findOrFail($id);
        $id_session_ciclo = session('session_cart');

        //insertamos el nuevo plan de pagos
        $planapago = new Planpago; 
        $planapago->codigo          = $codigo;
        $planapago->descripcion     = $desc;
        $planapago->periocidad      = $per;
        $planapago->status          = 'activo';
        $planapago->id_ciclo_escolar= session('session_cart');
        $planapago->save();

        //recorremos los conceptos del plan de pagos que se clonara
        $conceptos = DB::table('planpagoconceptos')
                    ->select('id_plan_pago','id_concepto_cobro','anio_corresponde','mes_pagar','no_parcialidad','periodo_inicio','periodo_vencimiento','cantidad')
                    ->where('id_plan_pago',$id_plan)
                    ->get();

        $fecha_actual       = Carbon::now()->format('Y-m-d');
        foreach ($conceptos as $concepto) {
            // incremento de fechas, se suma un año
            $date = Carbon::parse($concepto->periodo_inicio);
            $periodo_inicio = $date->addYear()->format('Y-m-d');

            $date = Carbon::parse($concepto->periodo_vencimiento);
            $periodo_vencimiento = $date->addYear()->format('Y-m-d');

            $anio_corresponde = $concepto->anio_corresponde+1;
            // fin incremento de fechas, se suma un año
            //Registro del concepto de plan de pagos
            $planapagoconcepto = new Planpagoconcepto; 
            $planapagoconcepto->id_plan_pago            =   $planapago->id;
            $planapagoconcepto->id_concepto_cobro       =   $concepto->id_concepto_cobro;
            $planapagoconcepto->anio_corresponde        =   $anio_corresponde;
            $planapagoconcepto->mes_pagar               =   $concepto->mes_pagar;
            $planapagoconcepto->no_parcialidad          =   $concepto->no_parcialidad;
            $planapagoconcepto->periodo_inicio          =   $periodo_inicio;
            $planapagoconcepto->periodo_vencimiento     =   $periodo_vencimiento;
            $planapagoconcepto->cantidad                =   $concepto->cantidad;
            $planapagoconcepto->status                  =   'clon';
            $planapagoconcepto->id_ciclo_escolar        =   session('session_cart');
            $planapagoconcepto->save();
            //Fin de Registro del concepto de plan de pagos
        }        
        
        return response()->json(['conceptos'=>$conceptos]);

    }
}