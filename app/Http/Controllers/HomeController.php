<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        //$request->user()->authorizeRoles(['user', 'admin']);
        return view('/principal');
    }
    public function sessionciclo(Request $request, $id)
    {
     //    Session::put( 'session_cart', 'sesion iniciada' );
        session()->put('session_cart', $id);        
    }
}
