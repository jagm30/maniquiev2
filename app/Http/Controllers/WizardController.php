<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cobro;
use App\helpers\convertidor;
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
class WizardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   

        $grupos = DB::table('grupos')
            ->select('grupos.id AS id_grupo','descripcion','cupo_maximo','turno','clave_identificador','grado_semestre','diferenciador_grupo','denominacion_grado')
            ->leftjoin('grupoalumnos', 'grupos.id', '=', 'grupoalumnos.id_grupo')
            ->join('nivelescolars', 'grupos.id_nivel_escolar', '=', 'nivelescolars.id')
            ->join('cicloescolars', 'grupos.id_ciclo_escolar', '=', 'cicloescolars.id')
            ->where('grupos.id_ciclo_escolar',session('session_cart'))
            ->groupBy('grupos.id','descripcion','cupo_maximo','turno','clave_identificador','grado_semestre','diferenciador_grupo','denominacion_grado')
            ->orderBy('clave_identificador')
            ->get();
        $cicloescolars  = DB::table('cicloescolars')->where('id','!=',session('session_cart'))->get();

        $planpagos =  Planpago::where('id_ciclo_escolar',session('session_cart'))
                    ->get();
        return view('wizard.index', compact('cicloescolars', 'grupos','planpagos'));
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
    }
}
