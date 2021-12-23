<?php

namespace App\Http\Controllers\Cajero;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mesa as ModelsMesa;

class CajeroController extends Controller
{
    // Primera página de cajero
    public function index(){
        return view('cajero.index');
    }

    public function getMesas(){
        $mesas = ModelsMesa::all();
        $html = '';
        foreach($mesas as $mesa){
            $html .= '<div class="col-md-2">';
            $html .= 
            '<button class="btn btn-primary">
            <img class="img-fluid" src="'.url('/images/mesa.png').'"/>
            <br>
            <span class="badge badge-success">'.$mesa->nombre.'</span>
            </button>';
            $html .= '</div>';
        }
        return $html;
    }

}
