<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Grupoalumno;
use App\Alumno;
use App\Grupo;
use Validator;
use App\Cicloescolar;
use App\Nivelescolar;
use PDF;
use App\Exports\GrupoalumnosExport;
use App\Exports\GrupoalumnosExportView;
use Maatwebsite\Excel\Facades\Excel;
class GrupoalumnoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function export(Request $request, $id){
        //$id = 1;
        $id_session_ciclo = session('session_cart');
        $grupoalumnos = DB::table('grupoalumnos')
                    ->select('grupoalumnos.id AS id','grupoalumnos.status','id_alumno','id_grupo','alumnos.id','alumnos.apaterno','alumnos.amaterno','alumnos.nombres','alumnos.genero','alumnos.fecha_nac','alumnos.lugar_nac','alumnos.edo_civil','alumnos.curp','alumnos.domicilio','alumnos.ciudad','alumnos.estado','alumnos.email','alumnos.telefono','alumnos.cp','alumnos.telefono2','alumnos.foto','alumnos.status','alumnos.nombre_tutor','alumnos.parentesco_tutor','alumnos.telefono_tutor','alumnos.razon_social','alumnos.rfc','alumnos.uso_cfdi','grupos.grado_semestre','grupos.diferenciador_grupo'
                        ,DB::raw("CONCAT(alumnos.apaterno,' ',alumnos.amaterno,' ',alumnos.nombres) as full_name"),DB::raw("CONCAT(alumnos.curp,' ',alumnos.genero) as otro"))
                    ->join('alumnos', 'grupoalumnos.id_alumno', '=', 'alumnos.id')
                    ->join('grupos', 'grupoalumnos.id_grupo', '=', 'grupos.id')
                    ->where('grupoalumnos.id_grupo',$id)
                    ->get();
        return Excel::download(new GrupoalumnosExportView($grupoalumnos),'grupo.xlsx');
        //return Excel::download(new GruposExport, 'grupos.xlsx');
    }
    public function index()
    {
        //return view('grupoalumnos.index');
        if(request()->ajax()){
            return datatables()->of(DB::table('grupos')
                    ->select('grupos.id AS id','descripcion','cupo_maximo','turno','clave_identificador','grado_semestre','diferenciador_grupo' )
                    ->join('nivelescolars', 'grupos.id_nivel_escolar', '=', 'nivelescolars.id')
                    ->join('cicloescolars', 'grupos.id_ciclo_escolar', '=', 'cicloescolars.id')
                    ->get())
            	->addColumn('action', function($data){
                        $button = '<a href="/grupoalumnos/'.$data->id.'"><button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm">Ver grupo</button></a>';
                        $button .= '&nbsp;&nbsp;';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);

        }
        return view('grupoalumnos.index');
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
        $id_session_ciclo = session('session_cart');

        $existealumnogrupo = DB::table('grupoalumnos')
            ->select('grupoalumnos.id AS id','grupoalumnos.status','id_alumno','id_grupo','grupos.grado_semestre','grupos.diferenciador_grupo')
            ->join('grupos', 'grupoalumnos.id_grupo', '=', 'grupos.id')
            ->where('grupoalumnos.id_alumno',$request->id_alumno)
            ->where('grupoalumnos.id_ciclo_escolar',$id_session_ciclo)
            ->count();
        if ($existealumnogrupo>=1) {
            //actualizar grupo
            //fin actualizar grupo             

            $grupoalumnoinscrito = DB::table('grupoalumnos')
                ->select('grupoalumnos.id AS id','grupoalumnos.status','id_alumno','id_grupo','grupos.grado_semestre','grupos.diferenciador_grupo')
                ->join('grupos', 'grupoalumnos.id_grupo', '=', 'grupos.id')
                ->where('grupoalumnos.id_alumno',$request->id_alumno)
                ->where('grupoalumnos.id_ciclo_escolar',$id_session_ciclo)
                ->first();

            $grupoalumno = Grupoalumno::find($grupoalumnoinscrito->id);
            $grupoalumno->id_grupo         = $request->id_grupo;   
            $grupoalumno->save();

            $grupoalumnoinscrito_act = DB::table('grupoalumnos')
                ->select('grupoalumnos.id AS id','grupoalumnos.status','id_alumno','id_grupo','grupos.grado_semestre','grupos.diferenciador_grupo')
                ->join('grupos', 'grupoalumnos.id_grupo', '=', 'grupos.id')
                ->where('grupoalumnos.id',$grupoalumnoinscrito->id)
                ->first();

            return response()->json(['success' => 'success', 'grupo' => $grupoalumnoinscrito_act, 'status' => "Actualizado correctamente"]);
        }else{                        
            $rules = array(
                'id_alumno'    =>  'required',
                'id_grupo'     =>  'required',
                'status'       =>  'required'
            );
            $error = Validator::make($request->all(), $rules);
            if($error->fails())
            {
                return response()->json(['errors' => $error->errors()->all()]);
            }
            //$image = $request->file('image');
            // $new_name = rand() . '.' . $image->getClientOriginalExtension();
            // $image->move(public_path('images'), $new_name);
            /*$form_data = array(
                'id_alumno'        =>  $request->id_alumno,
                'id_grupo'         =>  $request->id_grupo,
                'status'           =>  $request->status
            );*/
            $grupoalumno = new Grupoalumno;
            $grupoalumno->id_alumno     = $request->id_alumno;
            $grupoalumno->id_grupo      = $request->id_grupo;
            $grupoalumno->status        = $request->status;  
            $grupoalumno->id_ciclo_escolar = $id_session_ciclo;
            $grupoalumno->save();

            $grupoalumnoinscrito = DB::table('grupoalumnos')
                        ->select('grupoalumnos.id AS id','grupoalumnos.status','id_alumno','id_grupo','grupos.grado_semestre','grupos.diferenciador_grupo')
                        ->join('grupos', 'grupoalumnos.id_grupo', '=', 'grupos.id')
                        ->where('grupoalumnos.id',$grupoalumno->id)
                        ->first();

            return response()->json(['success' => 'success', 'grupo' => $grupoalumnoinscrito, 'status' => "Inscrito correctamente"]);
        # code...
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id_session_ciclo = session('session_cart');
       /* $alumnosall = Grupoalumno::pluck('id_alumno')->where('id_ciclo_escolar',$id_session_ciclo)->all();//busco los alumnos que ya estan inscritos en un grupo, para solo mostrar los que no pertenecen a algun grupo
        $alumnos    = Alumno::whereNotIn('alumnos.id', $alumnosall)->select('alumnos.id','alumnos.apaterno','alumnos.amaterno','alumnos.nombres','alumnos.genero')
            ->get(); //se realiza la comparacion de alumno en grupos y sin grupos-.
*/
        $alumnos      =  DB::table('grupoalumnos')
                ->select('alumnos.id','alumnos.apaterno','alumnos.amaterno','alumnos.nombres','alumnos.genero')
                ->rightJoin('alumnos', 'grupoalumnos.id_alumno', '=', 'alumnos.id')
                ->whereNotIn('grupoalumnos.id_ciclo_escolar', [$id_session_ciclo])
                ->orWhere('grupoalumnos.id_alumno')
                ->distinct('alumnos.id')
                ->orderBy('alumnos.apaterno')
                ->get();

        $nomgrupo      =  DB::table('grupos')
                    ->select('grupos.id as id_grupo','grupos.grado_semestre','grupos.diferenciador_grupo','turno','denominacion_grado')    
                    ->leftjoin('nivelescolars','grupos.id_nivel_escolar','=','nivelescolars.id')                
                    ->where('grupos.id',$id)
                    ->where('grupos.id_ciclo_escolar',$id_session_ciclo)
                    ->first();
        $grupos = DB::table('grupos')
            ->select('grupos.id AS id_grupo','cupo_maximo','turno','grado_semestre','diferenciador_grupo')
            ->where('grupos.id_ciclo_escolar',$id_session_ciclo)
            ->get();

        if (isset($nomgrupo)) {
            if(request()->ajax()){
                return  datatables()->of(DB::table('grupoalumnos')
                    ->select('grupoalumnos.id AS id','alumnos.status','id_alumno','id_grupo','alumnos.genero','alumnos.foto','grupos.grado_semestre','grupos.diferenciador_grupo'
                        ,DB::raw("CONCAT(alumnos.apaterno,' ',alumnos.amaterno,' ',alumnos.nombres) as full_name"),DB::raw("CONCAT(alumnos.curp,' ',alumnos.genero) as otro"))
                    ->join('alumnos', 'grupoalumnos.id_alumno', '=', 'alumnos.id')
                    ->join('grupos', 'grupoalumnos.id_grupo', '=', 'grupos.id')
                    ->where('grupoalumnos.id_grupo',$id)
                    ->get())
                     ->addColumn('action', function($data){
                        $button = '<button type="button" name="edit" id="'.$data->id.'" class="edit btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-default">Cambiar status</button>';
                        $button .= '&nbsp;&nbsp;';
                        $button .= '<button type="button" name="delete" id="'.$data->id.'" class="delete btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmModal">Eliminar</button>';
                        return $button;
                    })
                    ->rawColumns(['action'])
                    ->make(true);

            }
            return view('grupoalumnos.show',compact('id','alumnos','nomgrupo','grupos'));
        } else {
            return redirect("/grupos");
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        //
        if(request()->ajax())
        {
            $data =  DB::table('grupoalumnos')
                    ->select('grupoalumnos.id','grupoalumnos.id_grupo','grupoalumnos.id_alumno','alumnos.apaterno','alumnos.amaterno','alumnos.nombres','alumnos.foto','alumnos.status')
                    ->join('alumnos', 'grupoalumnos.id_alumno', '=', 'alumnos.id')
                    ->where('grupoalumnos.id',$id)->first();



            //$data = Grupoalumno::findOrFail($id);
            return response()->json(['data' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $rules = array(
            'status'    =>  'required',
            'id_grupo'  =>  'required'
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return response()->json(['errors' => $error->errors()->all()]);
        }
        
        $form_data = array(
            'status'       =>   $request->status,
            'id_grupo'     =>   $request->grupo_inscrito          
        );
        Grupoalumno::whereId($request->hidden_id)->update($form_data);

        $alumno         = Alumno::find($request->id_tb_alumno);
        $alumno->status = $request->status;
        $alumno->save();

        return response()->json(['success' => 'Datos actualizados...']);
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
        $data = Grupoalumno::findOrFail($id);
        $data->delete();
    }

    public function consultaExiste(Request $request, $id){
        $id_session_ciclo = session('session_cart');
        $existealumnogrupo = DB::table('grupoalumnos')
            ->select('grupoalumnos.id AS id','grupoalumnos.status','id_alumno','id_grupo','grupos.grado_semestre','grupos.diferenciador_grupo')
            ->join('grupos', 'grupoalumnos.id_grupo', '=', 'grupos.id')
            ->where('grupoalumnos.id_alumno',$id)
            ->where('grupoalumnos.id_ciclo_escolar',$id_session_ciclo)
            ->count();
        return response()->json(['data' => $existealumnogrupo]);
    }

    public function printPDF(Request $request, $id){
        // This  $data array will be passed to our PDF blade
        $id_session_ciclo = session('session_cart');
        $nomgrupo      =  DB::table('grupos')
                    ->select('grupos.id as id_grupo','grupos.grado_semestre','grupos.diferenciador_grupo','turno','nivelescolars.denominacion_grado')                    
                    ->join('nivelescolars', 'grupos.id_nivel_escolar', '=', 'nivelescolars.id')
                    ->where('grupos.id',$id)
                    ->where('grupos.id_ciclo_escolar',$id_session_ciclo)
                    ->first();

        $alumnos = DB::table('grupoalumnos')
                    ->select('grupoalumnos.id AS id','grupoalumnos.status','id_alumno','id_grupo','alumnos.genero','alumnos.foto','grupos.grado_semestre','grupos.diferenciador_grupo'
                        ,DB::raw("CONCAT(alumnos.apaterno,' ',alumnos.amaterno,' ',alumnos.nombres) as full_name"),DB::raw("CONCAT(alumnos.curp,' ',alumnos.genero) as otro"))
                    ->join('alumnos', 'grupoalumnos.id_alumno', '=', 'alumnos.id')
                    ->join('grupos', 'grupoalumnos.id_grupo', '=', 'grupos.id')
                    ->where('grupoalumnos.id_grupo',$id)
                    ->orderBy('alumnos.apaterno', 'asc')
                    ->get();
       
       $data = [
          'title' => $nomgrupo->diferenciador_grupo,
          'heading' => 'Hello from 99Points.info',
          'content' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.',
          'alumno' => $alumnos,
          'nomgrupo' => $nomgrupo,   
            ];
        
        $pdf = PDF::loadView('grupoalumnos.pdf_view', $data);  
        return $pdf->stream('lista_grupal.pdf');
            return "ok".$id;
    }
      
}
