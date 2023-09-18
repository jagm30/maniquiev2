<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Planpagoconcepto;
use App\Conceptocobro;
use Illuminate\Http\Request;

class ConceptocobroController extends Controller
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
        $conceptocobros     = Conceptocobro::all();
        return view('conceptocobro.index',compact('conceptocobros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('conceptocobro.create');
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
        $conceptocobro = new Conceptocobro; 

        $conceptocobro->codigo      	= $request->codigo;
        $conceptocobro->descripcion    	= $request->descripcion;
        $conceptocobro->precio_regular  = $request->precio_regular;
        $conceptocobro->impuesto        = $request->impuesto;
        $conceptocobro->unidad_medida   = '-';
        $conceptocobro->status          = 'activo';

        $conceptocobro->save();

        return redirect("/conceptocobro");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Conceptocobro  $conceptocobro
     * @return \Illuminate\Http\Response
     */
    public function show(Conceptocobro $conceptocobro)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Conceptocobro  $conceptocobro
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $conceptocobro = Conceptocobro::findOrFail($id);
        return view("conceptocobro.edit", compact("conceptocobro"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Conceptocobro  $conceptocobro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $conceptocobro = Conceptocobro::findOrFail($id);
        $conceptocobro->update($request->all());
        return redirect("/conceptocobro");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Conceptocobro  $conceptocobro
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $count_plan = DB::table('planpagoconceptos')
            ->select('id','id_concepto_cobro')            
            ->where('planpagoconceptos.id_concepto_cobro',$id)
            ->count();
        if($count_plan>0){
            return "Este concepto esta en un plan de pagos, no se puede eliminar...";
        }else{
            $conceptocobro = Conceptocobro::findOrFail($id);
            $conceptocobro->delete();
            return redirect("/conceptocobro");
        }
    }
}
