<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;



class PackageController extends Controller
{
    public function store(Request $request){

        return request();
        
    }

    public function carga(Request $request){    

        return to_route("cliente")->with("status", "Paquete cargado correctamente");
        
    }
}
