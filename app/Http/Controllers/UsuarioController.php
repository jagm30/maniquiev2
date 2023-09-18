<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UsuarioController extends Controller
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
    public function index(Request $request)
    {        
        $request->user()->authorizeRoles(['admin']); 
        $usuarios = User::all();
        return view("usuarios.index",compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $request->user()->authorizeRoles(['admin']); 
        return view("usuarios.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->user()->authorizeRoles(['admin']); 
        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'foto'      => '1.jpg',
        ]);
        //en estas lineas de codigo se inserta el tipo de usuario creado
       $user->roles()->attach(Role::where('name', $request->tipo_usuario)->first());
       //return $user;
        return redirect('usuarios/');
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
    public function edit(Request $request,$id)
    {
        $request->user()->authorizeRoles(['admin']); 
        $usuario = User::find($id);
        return view("usuarios.edit",compact('usuario'));
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
        //$usuario        = User::findOrFail($id);
        $request->user()->authorizeRoles(['admin']); 
        $nusuario   = User::find($id);
        if($nusuario->password == $request->password){
            $usuario    = User::where('id',$id)->update([
                'name'  =>$request->name,
                'email' =>$request->email,                
                'updated_at'=>$request->updated_at,
            ]);
        }else{
            $usuario    = User::where('id',$id)->update([
                'name'  =>$request->name,
                'email' =>$request->email,
                'password'=>bcrypt($request->password),
                'updated_at'=>$request->updated_at,
            ]);
        }        
        User::find($id)->roles()->sync([$request->tipo_usuario]);
        //$usuarios = User::all();
        return redirect('usuarios/');
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
    public function consultaEmail(Request $request, $email)
    {
        
        $count_usuarios = DB::table('users')
            ->select('email')            
            ->where('users.email',$email)
            ->count();
        if($count_usuarios>0){
            $contador = 1;
        }else{
            $contador = 0;
        }

        return response()->json(['data' => $contador]);
    }
}
