<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransitController extends Controller
{
    public function index(){

    }

    public function rastreo(Request $request){
        $codigoPaquete = $request->input('codigoPaquete');
        session(['codigoPaquete' => $codigoPaquete]);
        return redirect()->route("rastreoView");
    }
}
