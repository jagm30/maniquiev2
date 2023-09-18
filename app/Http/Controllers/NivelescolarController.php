<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Nivelescolar;
use App\Grupo;

class NivelescolarController extends Controller
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
        $nivelescolars = Nivelescolar::all();
        return view("nivelescolar.index",compact('nivelescolars'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view("nivelescolar.create");
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
        //
        $nivelescolar = new Nivelescolar;
        $nivelescolar->clave_identificador      = $request->clave_identificador;
        $nivelescolar->acuerdo_incorporacion    = $request->acuerdo_incorporacion;
        $nivelescolar->fecha_incorporacion      = $request->fecha_incorporacion;
        $nivelescolar->zona_escolar             = $request->zona_escolar;
        $nivelescolar->denominacion_grado       = $request->denominacion_grado;
        $nivelescolar->status                   = 'activo';

        $nivelescolar->save();

        return redirect("/nivelescolar");
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
        $nivelescolar = Nivelescolar::findOrFail($id);
        return view("nivelescolar.edit", compact("nivelescolar"));
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
        $nivelescolar = Nivelescolar::findOrFail($id);
        $nivelescolar->update($request->all());
        return redirect("/nivelescolar");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $count_grupos = DB::table('grupos')
            ->select('id','id_nivel_escolar')            
            ->where('grupos.id_nivel_escolar',$id)
            ->count();
        if($count_grupos>0){
            return "Existen grupos en el nivel escolar, no se puede eliminar...";
        }else{
            $nivelescolar = Nivelescolar::findOrFail($id);
            $nivelescolar->delete();
            return redirect("/nivelescolar");
        }
    }
}
