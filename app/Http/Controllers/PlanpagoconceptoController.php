<?php

namespace App\Http\Controllers;

use App\Planpagoconcepto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

use App\Planpago;
use App\Conceptocobro;

class PlanpagoconceptoController extends Controller
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
        $id_session_ciclo   = session('session_cart');
        $rules = array(
            'id_concepto_cobro'     =>  'required',
            'anio_corresponde'      =>  'required',
            'mes_pagar'             =>  'required',
            'no_parcialidad'        =>  'required',
            'periodo_inicio'        =>  'required',
            'periodo_vencimiento'   =>  'required',
            'cantidad'              =>  'required'
        );

       // $error = Validator::make($request->all(), $rules);

       // if($error->fails())
      //  {
       //     return response()->json(['errors' => $error->errors()->all()]);
       // }

        $form_data = array(
            'id_plan_pago'          =>  $request->id_plan_pago,
            'id_concepto_cobro'     =>  $request->id_concepto_cobro,
            'anio_corresponde'      =>  $request->anio_corresponde,
            'mes_pagar'             =>  $request->mes_pagar,
            'no_parcialidad'        =>  $request->no_parcialidad,
            'periodo_inicio'        =>  $request->periodo_inicio,
            'periodo_vencimiento'   =>  $request->periodo_vencimiento,
            'cantidad'              =>  $request->cantidad,
            'status'                =>  '-',
            'id_ciclo_escolar'      =>  $id_session_ciclo
        );

        Planpagoconcepto::create($form_data);
        return response()->json(['success' => 'Data Added successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Planpagoconcepto  $planpagoconcepto
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {        
        $id_session_ciclo   = session('session_cart');
        $count_planpago     = Planpago::where('id', $id)->where('id_ciclo_escolar',$id_session_ciclo)->count();
        $nom_plan_pago      = Planpago::where('id', $id)->first();

        if($count_planpago>0){
            $conceptos          =  Conceptocobro::all();
            if(request()->ajax()){
                return  datatables()->of(DB::table('planpagoconceptos')
                    ->select('planpagoconceptos.id','id_concepto_cobro','id_plan_pago','anio_corresponde','mes_pagar','no_parcialidad','periodo_inicio','periodo_vencimiento','cantidad', 'conceptocobros.descripcion',DB::raw("CONCAT('$ ',planpagoconceptos.cantidad) as precio"))
                    ->join('conceptocobros', 'planpagoconceptos.id_concepto_cobro', '=', 'conceptocobros.id')
                    ->join('planpagos', 'planpagoconceptos.id_plan_pago', '=', 'planpagos.id')
                    ->where('id_plan_pago',$id)
                    ->where('planpagoconceptos.id_ciclo_escolar',$id_session_ciclo)
                    ->get())
                     ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-default">Modificar</button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmModal">Eliminar</button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
                //return view('grupoalumnos.show',compact('id','alumnos','nomgrupo','grupos'));
            return view('planpagoconceptos.show',compact('id','conceptos','nom_plan_pago'));
        }else{
            return redirect("/planpago");
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Planpagoconcepto  $planpagoconcepto
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        //
        if(request()->ajax())
        {
            $data =  DB::table('planpagoconceptos')
                    ->select('planpagoconceptos.id','id_concepto_cobro','id_plan_pago','anio_corresponde','mes_pagar','no_parcialidad','periodo_inicio','periodo_vencimiento','cantidad', 'conceptocobros.descripcion')
                    ->join('conceptocobros', 'planpagoconceptos.id_concepto_cobro', '=', 'conceptocobros.id')
                    ->where('planpagoconceptos.id',$id)->first();
            //$data = Grupoalumno::findOrFail($id);
            return response()->json(['data' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Planpagoconcepto  $planpagoconcepto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = array(
            'id_concepto_cobro'     =>  'required',
            'anio_corresponde'      =>  'required',
            'mes_pagar'             =>  'required',
            'no_parcialidad'        =>  'required',
            'periodo_inicio'        =>  'required',
            'periodo_vencimiento'   =>  'required',
            'cantidad'              =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }

        $form_data = array(
            'id_plan_pago'          =>  $request->id_plan_pago,
            'id_concepto_cobro'     =>  $request->id_concepto_cobro,
            'anio_corresponde'      =>  $request->anio_corresponde,
            'mes_pagar'             =>  $request->mes_pagar,
            'no_parcialidad'        =>  $request->no_parcialidad,
            'periodo_inicio'        =>  $request->periodo_inicio,
            'periodo_vencimiento'   =>  $request->periodo_vencimiento,
            'cantidad'              =>  $request->cantidad,
            'status'                =>  '-'
        );

     //   return response()->json(['success' => 'Data Added successfully.']);
        //
        Planpagoconcepto::whereId($request->hidden_id)->update($form_data);

        return response()->json(['success' => 'Datos actualizados...']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Planpagoconcepto  $planpagoconcepto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $count_cuentas_asignadas = DB::table('cuentaasignadas')
            ->select('id')            
            ->where('id_plan_concepto_cobro',$id)
            ->count();
        if($count_cuentas_asignadas>0){
            return "No se puede eliminar, Concepto asignado a una o mas cuentas...";
        }else{
            $data = Planpagoconcepto::findOrFail($id);
            $data->delete();
        }        
    }
}
