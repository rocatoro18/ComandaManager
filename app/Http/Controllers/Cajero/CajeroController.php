<?php

namespace App\Http\Controllers\Cajero;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CajeroController extends Controller
{   
    //test
    // Primera página de cajero
    public function index(){
        return view('cajero.index');
    }
}
