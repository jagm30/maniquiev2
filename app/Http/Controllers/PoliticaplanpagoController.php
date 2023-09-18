<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Politicaplanpago;
use Illuminate\Http\Request;

use App\Cicloescolar;
use App\Nivelescolar;
use App\Planpago;

class PoliticaplanpagoController extends Controller
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

        $politicaplanpagos = DB::table('politicaplanpagos')
            ->select('politicaplanpagos.id','politicaplanpagos.id_ciclo_escolar','id_plan_pago','dias_limite_pronto_pago','cant_porc_descuento','valor_descuento','cant_porc_recargo','valor_recargo','cicloescolars.descripcion as descciclo','planpagos.descripcion as descplan')
            ->join('cicloescolars', 'politicaplanpagos.id_ciclo_escolar', '=', 'cicloescolars.id')
            ->join('planpagos', 'politicaplanpagos.id_plan_pago', '=', 'planpagos.id')
            ->where('politicaplanpagos.id_ciclo_escolar',$id_session_ciclo)
            ->get();

        //$politicaplanpagos = Politicaplanpago::all();
        return view('politicaplanpago.index',compact('politicaplanpagos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $id_session_ciclo   = session('session_cart');
        $cicloescolars      = Cicloescolar::all();
        $nivelescolars      = Nivelescolar::all();
        $planpagos          =  Planpago::where('id_ciclo_escolar',$id_session_ciclo)
                        ->get();
        return view('politicaplanpago.create',compact('cicloescolars','nivelescolars','planpagos'));
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
       // return "llegaste";
        $id_session_ciclo = session('session_cart');
        $politicaplanpago = new Politicaplanpago; 

        $politicaplanpago->id_ciclo_escolar         = $id_session_ciclo;
        $politicaplanpago->id_plan_pago             = $request->id_plan_pago;
        $politicaplanpago->dias_limite_pronto_pago  = $request->dias_limite_pronto_pago;
        $politicaplanpago->cant_porc_descuento      = $request->cant_porc_descuento;
        $politicaplanpago->valor_descuento          = $request->valor_descuento;
        $politicaplanpago->cant_porc_recargo        = $request->cant_porc_recargo;
        $politicaplanpago->valor_recargo            = $request->valor_recargo;
        $politicaplanpago->status                   = 'activo';
        $politicaplanpago->save();

        return redirect("/politicaplanpago");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Politicaplanpago  $politicaplanpago
     * @return \Illuminate\Http\Response
     */
    public function show(Politicaplanpago $politicaplanpago)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Politicaplanpago  $politicaplanpago
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id_session_ciclo = session('session_cart');

        $politicaplanpago = DB::table('politicaplanpagos')
            ->select('politicaplanpagos.id','politicaplanpagos.id_ciclo_escolar','id_plan_pago','dias_limite_pronto_pago','cant_porc_descuento','valor_descuento','cant_porc_recargo','valor_recargo','cicloescolars.descripcion as descciclo','planpagos.descripcion as descplan')
            ->join('cicloescolars', 'politicaplanpagos.id_ciclo_escolar', '=', 'cicloescolars.id')
            ->join('planpagos', 'politicaplanpagos.id_plan_pago', '=', 'planpagos.id')
            ->where('politicaplanpagos.id_ciclo_escolar',$id_session_ciclo)
            ->where('politicaplanpagos.id',$id)
            ->first();

        $planpagos  =  Planpago::where('id_ciclo_escolar',$id_session_ciclo)
                    ->get();

        //$politicaplanpagos = Politicaplanpago::all();
        return view('politicaplanpago.edit',compact('politicaplanpago','planpagos'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Politicaplanpago  $politicaplanpago
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        //
        $id_session_ciclo = session('session_cart');
        $politicaplanpago = Politicaplanpago::findOrFail($id); 

        $politicaplanpago->id_ciclo_escolar         = $id_session_ciclo;
        $politicaplanpago->id_plan_pago             = $request->id_plan_pago;
        $politicaplanpago->dias_limite_pronto_pago  = $request->dias_limite_pronto_pago;
        $politicaplanpago->cant_porc_descuento      = $request->cant_porc_descuento;
        $politicaplanpago->valor_descuento          = $request->valor_descuento;
        $politicaplanpago->cant_porc_recargo        = $request->cant_porc_recargo;
        $politicaplanpago->valor_recargo            = $request->valor_recargo;
        $politicaplanpago->status                   = 'activo';       
        $politicaplanpago->save();

        return redirect("/politicaplanpago");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Politicaplanpago  $politicaplanpago
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $politicaplanpago = Politicaplanpago::findOrFail($id);
        $politicaplanpago->delete();
        return redirect("/politicaplanpago");
    }
}
