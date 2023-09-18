<?php

namespace App\Http\Controllers;

use App\Descuento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
Use Carbon\Carbon;
use PDF;

class DescuentoController extends Controller
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
        $fecha_actual = Carbon::now()->format('Y-m-d');
        return $fecha_actual;
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
     * @param  \App\Descuento  $descuento
     * @return \Illuminate\Http\Response
     */
    public function show(Descuento $descuento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Descuento  $descuento
     * @return \Illuminate\Http\Response
     */
    public function edit(Descuento $descuento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Descuento  $descuento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Descuento $descuento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Descuento  $descuento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Descuento $descuento)
    {
        //
    }
    public function guardarDescuento(Request $request, $id_cuentaasignada, $id_alumno, $fecha_descuento, $cantidad, $observaciones, $id_usuario)
    {
        $id_session_ciclo   = session('session_cart');

        $descuento = new Descuento; 
        $descuento->id_cuentaasignada   = $id_cuentaasignada;
        $descuento->id_alumno           = $id_alumno;
        $descuento->fecha_descuento     = $fecha_descuento;
        $descuento->id_ciclo_escolar    = $id_session_ciclo;
        $descuento->cantidad            = $cantidad;
        $descuento->observaciones       = $observaciones;
        $descuento->status              = 'activo';
        $descuento->id_usuario          = $id_usuario;        
        
        $descuento->save();

        return response()->json(['data' => "Descuento agregado correctamente...".$id_session_ciclo]);
    }

}
