<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InicioController extends Controller
{
    //
    function index(Request $request)
    {
    	print_r($request->input('user'))
    }
}
