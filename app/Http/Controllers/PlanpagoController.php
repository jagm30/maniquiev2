<?php

namespace App\Http\Controllers;

use App\Planpago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Planpagoconcepto;

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
    public function show( $id)
    {
        //
        return "hey".$id;
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
}
