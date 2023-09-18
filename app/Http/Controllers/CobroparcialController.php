<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Cobroparcial;
use App\Cobro;
use App\Cuentaasignada;

class CobroparcialController extends Controller
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
        $cobrosparciales = Cobroparcial::all();
        return $cobrosparciales;
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
    public function registroabono(Request $request, $data){
        $id_session_ciclo   = session('session_cart');  
        $array              = json_decode($data);
        $cobroparcial       = new Cobroparcial;   

        $cobroparcial->id_alumno               = $array->id_alumno;
        $cobroparcial->id_user                 = $array->id_usuario;
        $cobroparcial->id_ciclo_escolar        = $id_session_ciclo;
        $cobroparcial->id_cuenta_asignada      = $array->id_cuentaasignada;
        $cobroparcial->id_planpagoconcepto     = 1;
        $cobroparcial->cantidad_inicial        = $array->cantidad_ini_fpago;
        $cobroparcial->descuento_pp            = $array->desc_pp_fpago;
        $cobroparcial->descuento_adicional     = $array->desc_con_fpago;
        $cobroparcial->recargo                 = $array->recargo_fpago;
        $cobroparcial->fecha_pago              = $array->fecha_abono;
        $cobroparcial->cantidad_abonada        = $array->cantidad_abono;
        $cobroparcial->forma_pago              = $array->forma_pago;
        $cobroparcial->status                  = $array->status_abono;
        $cobroparcial->save();

        $cobro = new Cobro; 
            $cobro->id_alumno               = $array->id_alumno;
            $cobro->id_user                 = $array->id_usuario;
            $cobro->id_ciclo_escolar        = $id_session_ciclo;
            $cobro->id_cuenta_asignada      = $array->id_cuentaasignada;
            $cobro->id_planpagoconcepto     = 1;
            $cobro->cantidad_inicial        = $array->cantidad_ini_fpago;
            $cobro->descuento_pp            = $array->desc_pp_fpago;
            $cobro->descuento_adicional     = $array->desc_con_fpago;
            $cobro->recargo                 = $array->recargo_fpago;
            $cobro->fecha_pago              = $array->fecha_abono;
            $cobro->cantidad                = $array->cantidad_abono;
            $cobro->forma_pago              = $array->forma_pago;
            $cobro->tipo_pago               = 'parcial';
            $cobro->status                  = 'pagado';
            $cobro->save();
          //  $contador++;

          

        //residuo
        //status_abono
        //cuentas asignadas
        $cuentaasignada = Cuentaasignada::find($array->id_cuentaasignada);
        $cuentaasignada->status   = $array->status_abono;            
        $cuentaasignada->save();
        //


        return response()->json(['dato' => "Registrado..."]);
    }
}
