<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;
use App\Grupo;
use App\Cicloescolar;
use App\Nivelescolar;

use App\Exports\GruposExport;
use Maatwebsite\Excel\Facades\Excel;

class GrupoController extends Controller
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
    public function export(){
        $id_session_ciclo = session('session_cart');
        $grupos = DB::table('grupos')
            ->select('grupos.id AS id_grupo','descripcion','cupo_maximo','turno','clave_identificador','grado_semestre','diferenciador_grupo','denominacion_grado' )
            ->join('nivelescolars', 'grupos.id_nivel_escolar', '=', 'nivelescolars.id')
            ->join('cicloescolars', 'grupos.id_ciclo_escolar', '=', 'cicloescolars.id')
            ->where('grupos.id_ciclo_escolar',$id_session_ciclo)
            ->get();
        return Excel::download(new GruposExport($grupos),'grupo.xlsx');
        //return Excel::download(new GruposExport, 'grupos.xlsx');
    }
    public function index()
    {
        $id_session_ciclo = session('session_cart');
        // Alias de columnas de una table, inner join, nombres de columnas personalizadas
        $grupos = DB::table('grupos')
            ->select('grupos.id AS id_grupo','descripcion','cupo_maximo','turno','clave_identificador','grado_semestre','diferenciador_grupo','denominacion_grado',DB::raw('count(grupoalumnos.id_alumno) as total_alumnos'))
            ->leftjoin('grupoalumnos', 'grupos.id', '=', 'grupoalumnos.id_grupo')
            ->join('nivelescolars', 'grupos.id_nivel_escolar', '=', 'nivelescolars.id')
            ->join('cicloescolars', 'grupos.id_ciclo_escolar', '=', 'cicloescolars.id')
            ->where('grupos.id_ciclo_escolar',$id_session_ciclo)
            ->groupBy('grupos.id','descripcion','cupo_maximo','turno','clave_identificador','grado_semestre','diferenciador_grupo','denominacion_grado')
            ->get();
        return view('grupos.index',compact('grupos'));


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cicloescolars = Cicloescolar::all();
        $nivelescolars = Nivelescolar::all();
        return view('grupos.create',compact('cicloescolars', 'nivelescolars'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $grupo = new Grupo;
        $grupo->id_ciclo_escolar    = $request->id_ciclo_escolar;
        $grupo->cupo_maximo         = $request->cupo_maximo;
        $grupo->turno               = $request->turno;
        $grupo->id_nivel_escolar    = $request->id_nivel_escolar;
        $grupo->grado_semestre      = $request->grado_semestre;
        $grupo->diferenciador_grupo = $request->diferenciador_grupo;
        $grupo->status              = 'activo';
        $grupo->save();

        return redirect("/grupos");
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
        $grupo = Grupo::findOrFail($id);
        //return view("alumnos.show", compact("alumno"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // first me devuelve un solo registro, mientras que ->get me devuelve una coleccion de n valores segun la consulta SQL
        $id_session_ciclo = session('session_cart');
        $grupo = DB::table('grupos')
            ->select('grupos.id AS id_grupo','descripcion','cupo_maximo','turno','clave_identificador','grado_semestre','id_ciclo_escolar','id_nivel_escolar','diferenciador_grupo')
            ->join('nivelescolars', 'grupos.id_nivel_escolar', '=', 'nivelescolars.id')
            ->join('cicloescolars', 'grupos.id_ciclo_escolar', '=', 'cicloescolars.id')
            ->where('grupos.id_ciclo_escolar',$id_session_ciclo)
            ->where('grupos.id',$id)->first();

        $cicloescolares = Cicloescolar::all();
        $nivelescolares = Nivelescolar::all();

        if (isset($grupo)) {
            return view('grupos.edit',compact('grupo','cicloescolares', 'nivelescolares'));
        } else {
            return redirect("/grupos");
        }        
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
        $grupo = Grupo::findOrFail($id);
        $grupo->update($request->all());
        return redirect("/grupos");
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
        $count_alumnos = DB::table('grupoalumnos')
            ->select('id_alumno','id_grupo')            
            ->where('grupoalumnos.id_grupo',$id)
            ->count();
        if($count_alumnos>0){
            return "Existen alumnos en el grupo, no se puede eliminar...";
        }else{
            $grupo = Grupo::findOrFail($id);
            $grupo->delete();
            return redirect("/grupos");
        }
    }
    public function listarxciclo(Request $request, $id_ciclo_escolar){
        
        $grupos = DB::table('grupos')
            ->select('grupos.id AS id_grupo','descripcion','cupo_maximo','turno','clave_identificador','grado_semestre','diferenciador_grupo','denominacion_grado')
            ->leftjoin('grupoalumnos', 'grupos.id', '=', 'grupoalumnos.id_grupo')
            ->join('nivelescolars', 'grupos.id_nivel_escolar', '=', 'nivelescolars.id')
            ->join('cicloescolars', 'grupos.id_ciclo_escolar', '=', 'cicloescolars.id')
            ->where('grupos.id_ciclo_escolar',$id_ciclo_escolar)
            ->groupBy('grupos.id','descripcion','cupo_maximo','turno','clave_identificador','grado_semestre','diferenciador_grupo','denominacion_grado')
            ->orderBy('clave_identificador')
            ->get();

            return response()->json(['data' => $grupos]);
    }
    public function guardargrupo(Request $request, $datos){

        $contador = 0;
        //$array = response()->json($datos);
        $array = json_decode($datos);

        foreach ($array->datos as $row) {
            $contador ++;
            $grupoactual = Grupo::find($row->id_grupo);

            $grupo = new Grupo;            
            $grupo->id_ciclo_escolar    = session('session_cart');
            $grupo->cupo_maximo         = $grupoactual->cupo_maximo;
            $grupo->turno               = $grupoactual->turno;
            $grupo->id_nivel_escolar    = $grupoactual->id_nivel_escolar;
            $grupo->grado_semestre      = $grupoactual->grado_semestre;
            $grupo->diferenciador_grupo = $grupoactual->diferenciador_grupo;
            $grupo->status              = 'activo';
            $grupo->save();            
        }
        return response()->json(['data' => "Grupos agregados correctamente:".$contador]); 
    }
}
