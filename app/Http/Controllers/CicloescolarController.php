<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Cicloescolar;
use App\Grupo;

class CicloescolarController extends Controller
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
        //$request->user()->authorizeRoles(['admin','user']); 
        $cicloescolars = Cicloescolar::all();

        return view("cicloescolar.index",compact('cicloescolars'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("cicloescolar.create");
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
        $cicloescolar = new Cicloescolar;
        $cicloescolar->anio_inicio  = 0;
        $cicloescolar->anio_fin     = 0;
        $cicloescolar->periodo      = 0;
        $cicloescolar->descripcion  = $request->descripcion;
        $cicloescolar->denominacion = $request->denominacion;
        $cicloescolar->fecha_inicio = $request->fecha_inicio;
        $cicloescolar->fecha_fin    = $request->fecha_fin;
        $cicloescolar->status       = 'activo';

        $cicloescolar->save();

        return redirect("/cicloescolar");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $cicloescolar = Cicloescolar::findOrFail($id);
        return view("cicloescolar.edit", compact("cicloescolar"));
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
        //
        $cicloescolar = Cicloescolar::findOrFail($id);
        $cicloescolar->update($request->all());
        return redirect("/cicloescolar");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $count_grupos = DB::table('grupos')
            ->select('id','id_ciclo_escolar')            
            ->where('grupos.id_ciclo_escolar',$id)
            ->count();
        if($count_grupos>0){
            return "Existen grupos en el ciclo, no se puede eliminar...";
        }else{
            $cicloescolar = Cicloescolar::findOrFail($id);
            $cicloescolar->delete();
            return redirect("/cicloescolar");
        }
    }
    public function cicloReciente(Request $request){
        $cicloescolar = Cicloescolar::orderby('id', 'desc')->first();
        //$cicloescolar = var_dump($cicloescolars->last())
        session()->put('session_cart', $cicloescolar->id); 
        return response()->json(['data' => $cicloescolar]);
    }
}
