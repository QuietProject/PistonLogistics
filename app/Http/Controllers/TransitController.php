<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TransitController extends Controller
{
    public function index(){

    }

    public function mapa(){
        $cedula = session('nombre');
        $response = Http::withHeaders(["Authorization" => "Bearer " . session('token')])->acceptJson()->get(env("TRANSIT_API_URL") . "camion/mapa?cedula=$cedula")->json();

        $modo = $response["modo"];
        $coordenadas = $response["coordenadas"];
        $almacen = $response["almacen"];
        $descargar = $response["descargar"];
        $cargar = $response["cargar"];

        if ($modo == "lleva"){
            return view('camionero', ['coordenadas' => $coordenadas, 'almacen' => $almacen,'descargar' => $descargar, 'cargar'=> $cargar]);
        }else if($modo == "reparte"){
            
        }
    }

    public function rastreo(Request $request){
        $codigoPaquete = $request->input('codigoPaquete');
        session(['codigoPaquete' => $codigoPaquete]);
        return redirect()->route("rastreoView");
    }
}
