<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;


class PackageController extends Controller
{

    public function store(Request $request)
    {

        return request();

    }

    public function showPaquetes()
    {
        $lotes = Http::get(env("API_URL") . 'lotes')->json();
        $paquetes = Http::get(env("API_URL") . 'paquetes')->json()['data'];


        for ($i = 0; $i < count($paquetes); $i++) {
            $fechaRegistrado = Carbon::parse($paquetes[$i]['fecha_registrado']);
            $paquetes[$i]['fecha_registrado'] = $fechaRegistrado->format('d/m/y H:i');
        }

        for ($i = 0; $i < count($lotes); $i++) {
            if($lotes[$i]['fecha_pronto']){
            
                $fechaPronto = Carbon::parse($lotes[$i]['fecha_pronto']);
                $lotes[$i]['fecha_pronto'] = $fechaPronto->format('d/m/y H:i');
            }
            if($lotes[$i]['fecha_cerrado']){
                $fechaCerrado = Carbon::parse($lotes[$i]['fecha_cerrado']);
                $lotes[$i]['fecha_cerrado'] = $fechaCerrado->format('d/m/y H:i');
            }

            $fechaCreacion = Carbon::parse($lotes[$i]['fecha_creacion']);
            $lotes[$i]['fecha_creacion'] = $fechaCreacion->format('d/m/y H:i');
        }

        // Devuelve la vista "verPaquetes" y pasa los datos de los paquetes a la vista
        return view('verPaquetes', ['paquetes' => $paquetes], ['lotes' => $lotes]);
    }

    public function showLotes()
    {
        $lotes = Http::get(env("API_URL") . 'lotes')->json();
        $paquetes = Http::get(env("API_URL") . 'paquetes')->json()['data'];


        for ($i = 0; $i < count($paquetes); $i++) {
            $fechaRegistrado = Carbon::parse($paquetes[$i]['fecha_registrado']);
            $paquetes[$i]['fecha_registrado'] = $fechaRegistrado->format('d/m/y H:i');
        }

        for ($i = 0; $i < count($lotes); $i++) {
            if($lotes[$i]['fecha_pronto']){
            
                $fechaPronto = Carbon::parse($lotes[$i]['fecha_pronto']);
                $lotes[$i]['fecha_pronto'] = $fechaPronto->format('d/m/y H:i');
            }
            if($lotes[$i]['fecha_cerrado']){
                $fechaCerrado = Carbon::parse($lotes[$i]['fecha_cerrado']);
                $lotes[$i]['fecha_cerrado'] = $fechaCerrado->format('d/m/y H:i');
            }

            $fechaCreacion = Carbon::parse($lotes[$i]['fecha_creacion']);
            $lotes[$i]['fecha_creacion'] = $fechaCreacion->format('d/m/y H:i');
        }

        // Devuelve la vista "verPaquetes" y pasa los datos de los paquetes a la vista
        return view('verLotes', ['paquetes' => $paquetes], ['lotes' => $lotes]);
    }

    public function asignar($idPaquete, $idLote)
    {
        $url = env("API_URL") . "lotes/agregar/paquete?idPaquete=$idPaquete&idLote=$idLote";

        $a = Http::get($url);
        return redirect()->back()->with('message', $a['message']);
    }

    


    public function getLotesAsignar(Request $request)
    {
        $lotes = Http::get(env("API_URL") . 'lotes')->json();

        for ($i = 0; $i < count($lotes); $i++) {
            if (isset($lotes[$i]['fecha_pronto'])) {
                array_splice($lotes,$i,1);
                $i--;
            } else {
                $lotes[$i]['prueba'] = 'si';
                $fechaCreacion = Carbon::parse($lotes[$i]['fecha_creacion']);
                $lotes[$i]['fecha_creacion'] = $fechaCreacion->format('d/m/y H:i');

                $fechaCerrado = Carbon::parse($lotes[$i]['fecha_cerrado']);
                $lotes[$i]['fecha_cerrado'] = $fechaCerrado->format('d/m/y H:i');
            }
        }
        return json_encode($lotes);
    }

    public function getPaquetesLote(Request $request)
{
    $this->validate($request, [
        'idsLote' => ['required', 'numeric'],
    ]);

    $idsLote = $request->idsLote;

    $response = Http::get(env("API_URL"). 'lotes/contenido', [
        'idsLote' => $idsLote,
    ]);

    if ($response->successful()) {
        return $response->json(); // Devuelve la respuesta JSON de la API
    } else {
        $responseData = $response->json();
        if (isset($responseData['message']) && $responseData['message'] == "No se encontraron paquetes en los lotes especificados") {
            return response()->json([
                'custom_message' => 'Mensaje personalizado para JavaScript',
            ]);
        }
        return response()->json([
            'message' => 'Error al obtener los paquetes en el lote',
        ], 400);
    }
}
    

    
    

    public function carga(Request $request)
    {

        return to_route("cliente")->with("status", "Paquete cargado correctamente");

    }

    public function cargaAlmacen(Request $request)
    {



        $a = Http::post("http://127.0.0.1:8080/api/lotes/create?almacenOrigen=1", ["idTroncal" => 3, "idAlmacenDestino" => 14, "tipo" => 0]);
        $lote = $a["data"]["ID"];

        Http::get("http://127.0.0.1:8080/api/lotes/pronto?idLote=$lote");

        $b = Http::get("http://127.0.0.1:8080/api/lotes/cargar?idLote=$lote&matricula=DEF5678");

        return $b;

        return to_route("almacenCarga")->with("status", "Paquete cargado correctamente");


    }

    public function descargaAlmacen(Request $request)
    {

        return to_route("almacenDescarga")->with("status", "Paquete cargado correctamente");

    }
}
