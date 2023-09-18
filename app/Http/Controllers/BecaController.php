<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Beca;
use Illuminate\Http\Request;
use App\Nivelescolar;
use App\Cicloescolar;
use App\Becaalumno;

class BecaController extends Controller
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
        //$id_session_ciclo   = session('session_cart');
        //$becas              = Beca::where('id_ciclo_escolar',$id_session_ciclo)->get();

        $becas              = DB::table('becas')
            ->select('becas.id','becas.codigo','becas.descripcion','becas.porc_o_cant','becas.cantidad','becas.id_nivel','becas.id_ciclo_escolar')
            //->join('nivelescolars','becas.id_nivel','=','nivelescolars.id')
            //->join('cicloescolars','becas.id_ciclo_escolar','=','cicloescolars.id')
            //->where('id_ciclo_escolar',$id_session_ciclo)
            ->get();
        return view('becas.index',compact('becas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $nivelescolars = Nivelescolar::all();
        return view('becas.create',compact('nivelescolars'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id_session_ciclo       = session('session_cart');

        $beca   = new Beca;
        $beca->codigo           = $request->codigo;
        $beca->descripcion      = $request->descripcion;
        $beca->porc_o_cant      = $request->porc_o_cant;
        $beca->cantidad         = $request->cantidad;
        $beca->id_nivel         = 0;
        $beca->status           = 'activo';
        $beca->id_ciclo_escolar = 0;
        $beca->save();

        return redirect('/becas');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Beca  $beca
     * @return \Illuminate\Http\Response
     */
    public function show(Beca $beca)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Beca  $beca
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id_session_ciclo   = session('session_cart');
        //$becas              = Beca::where('id_ciclo_escolar',$id_session_ciclo)->get();
        $nivelescolars      = Nivelescolar::all();
        $becas              = DB::table('becas')
            ->select('becas.id','becas.codigo','becas.descripcion','becas.porc_o_cant','becas.cantidad','becas.id_nivel','becas.id_ciclo_escolar')
            
            //->join('cicloescolars','becas.id_ciclo_escolar','=','cicloescolars.id')
            //->where('id_ciclo_escolar',$id_session_ciclo)
            ->where('becas.id',$id)
            ->first();
        return view('becas.edit',compact('becas','nivelescolars'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Beca  $beca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $beca = Beca::find($id);
        $beca->codigo           = $request->codigo;
        $beca->descripcion      = $request->descripcion;
        $beca->porc_o_cant      = $request->porc_o_cant;
        $beca->cantidad         = $request->cantidad;
        $beca->id_nivel         = 0;
        $beca->status           = 'activo';
        $beca->save();

        return redirect('/becas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Beca  $beca
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
            $beca = Beca::findOrFail($id);
            $beca->delete();
            return redirect("/becas");
        }         
    }
}
