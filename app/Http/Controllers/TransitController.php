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
        // dd($modo);
        
        if ($modo == "lleva"){
            $coordenadas = $response["coordenadas"];
            $almacen = $response["almacen"];
            $descargar = $response["descargar"];
            $cargar = $response["cargar"];
            return view('camionero', ['coordenadas' => $coordenadas, 'almacen' => $almacen,'descargar' => $descargar, 'cargar'=> $cargar]);
        }else if($modo == "reparte"){
            $puntos = $response["puntos"];
            return view('reparte', ['puntos' => $puntos]);
        }else if( $modo == 'trae'){
            $destino = $response["destino"];
            return view('trae', ['destino' => $destino]);
        }
    }

    public function rastreo(Request $request){
        $codigoPaquete = $request->input('codigoPaquete');
        session(['codigoPaquete' => $codigoPaquete]);
        return redirect()->route("rastreoView");
    }
}
