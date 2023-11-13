<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
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
        $idAlmacen = explode('.', session('nombre'))[1];

        $paquetes = Http::withHeaders(["Authorization" => "Bearer " . session('token')])->acceptJson()->get(env("API_URL") . "paquetes?idAlmacen=$idAlmacen")->json()['data'];

        // $lotes = Http::withHeaders(["Authorization" => "Bearer " . session('token')])->acceptJson()->get(env("API_URL") . "lotes?idAlmacen=$idAlmacen")->json();



        for ($i = 0; $i < count($paquetes); $i++) {
            $fechaRegistrado = Carbon::parse($paquetes[$i]['fecha_registrado']);
            $paquetes[$i]['fecha_registrado'] = $fechaRegistrado->format('d/m/y H:i');
        }

        // for ($i = 0; $i < count($lotes); $i++) {
        //     if ($lotes[$i]['fecha_pronto']) {

        //         $fechaPronto = Carbon::parse($lotes[$i]['fecha_pronto']);
        //         $lotes[$i]['fecha_pronto'] = $fechaPronto->format('d/m/y H:i');
        //     }
        //     if ($lotes[$i]['fecha_cerrado']) {
        //         $fechaCerrado = Carbon::parse($lotes[$i]['fecha_cerrado']);
        //         $lotes[$i]['fecha_cerrado'] = $fechaCerrado->format('d/m/y H:i');
        //     }

        //     $fechaCreacion = Carbon::parse($lotes[$i]['fecha_creacion']);
        //     $lotes[$i]['fecha_creacion'] = $fechaCreacion->format('d/m/y H:i');
        // }
        return view('verPaquetes', ['paquetes' => $paquetes]);
        // return view('verPaquetes', ['paquetes' => $paquetes], ['lotes' => $lotes]);
    }

    public function showLotes()
    {
        $idAlmacen = explode('.', session('nombre'))[1];

        $lotes = Http::withHeaders(["Authorization" => "Bearer " . session('token')])->acceptJson()->get(env("API_URL") . "lotes?idAlmacen=$idAlmacen")->json();
        for ($i = 0; $i < count($lotes); $i++) {
            if ($lotes[$i]['fecha_pronto']) {

                $fechaPronto = Carbon::parse($lotes[$i]['fecha_pronto']);
                $lotes[$i]['fecha_pronto'] = $fechaPronto->format('d/m/y H:i');
            }
            if ($lotes[$i]['fecha_cerrado']) {
                $fechaCerrado = Carbon::parse($lotes[$i]['fecha_cerrado']);
                $lotes[$i]['fecha_cerrado'] = $fechaCerrado->format('d/m/y H:i');
            }

            $fechaCreacion = Carbon::parse($lotes[$i]['fecha_creacion']);
            $lotes[$i]['fecha_creacion'] = $fechaCreacion->format('d/m/y H:i');
        }

        // Devuelve la vista "verPaquetes" y pasa los datos de los paquetes a la vista
        return view('verLotes', ['lotes' => $lotes]);
    }

    public function lotePronto($idLote)
    {
        $url = env("API_URL") . "lotes/pronto?idLote=$idLote";
        $response = Http::withHeaders(["Authorization" => "Bearer " . session('token')])->acceptJson()->get($url);

        session()->flash('message', $response['message']);
        return redirect()->back();
    }


    public function asignar($idPaquete, $idLote)
    {
        $url = env("API_URL") . "lotes/agregar/paquete?idPaquete=$idPaquete&idLote=$idLote";

        $a = Http::withHeaders(["Authorization" => "Bearer " . session('token')])->acceptJson()->get($url);

        session()->flash('message', $a["message"]);

        return redirect()->back();
    }
    public function quitarPaqueteDeLote($idLote, $idPaquete)
    {
        $url = env("API_URL") . "lotes/eliminar/paquete";

        $response = Http::withHeaders(["Authorization" => "Bearer " . session('token')])->acceptJson()->post($url, [
            'ID_lote' => $idLote,
            'ID_paquete' => $idPaquete,
        ]);

        return redirect()->back()->with('message', $response["message"]);
    }

    public function getPaquetesEntregar(){
        $idAlmacen = explode('.', session('nombre'))[1];

        $paquetes = Http::withHeaders(["Authorization" => "Bearer " . session('token')])->acceptJson()->get(env("API_URL") . "paquetes?idAlmacen=$idAlmacen")->json()['data'];

        for ($i = 0; $i < count($paquetes); $i++) {
            $fechaRegistrado = Carbon::parse($paquetes[$i]['fecha_registrado']);
            $paquetes[$i]['fecha_registrado'] = $fechaRegistrado->format('d/m/y H:i');
        }

        return view('entregarPaquete', ['paquetes' => $paquetes]);
    }

    public function entregarPaquete($id){

        $response = Http::withHeaders(["Authorization" => "Bearer " . session('token')])->acceptJson()->get(env("API_URL"). "paquetes/entregar/$id");
        return redirect()->back()->with('message', $response["message"]);
    }

    public function getLotesAsignar(Request $request)
    {
        $this->validate($request, [
            'idAlmacen' => ['required', 'numeric'],
        ]);

        $idAlmacen = $request->idAlmacen;

        $lotes = Http::withHeaders(["Authorization" => "Bearer " . session('token')])->acceptJson()->get(env("API_URL") . "lotes?idAlmacen=$idAlmacen")->json();

        for ($i = 0; $i < count($lotes); $i++) {
            if (isset($lotes[$i]['fecha_pronto'])) {
                array_splice($lotes, $i, 1);
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

        $response = Http::withHeaders(["Authorization" => "Bearer " . session('token')])->acceptJson()->get(env("API_URL") . "lotes/contenido/$idsLote");

        if ($response->successful()) {
            return $response->json(); // Devuelve la respuesta JSON de la API
        } else {
            $responseData = $response->json();
            if (isset($responseData['message']) && $responseData['message'] == "No se encontraron paquetes en los lotes especificados") {
                return response()->json([
                    'message' => 'No se encontraron paquetes en los lotes especificados',
                ]);
            }
            return response()->json([
                'message' => 'Error al obtener los paquetes en el lote',
            ], 400);
        }
    }

    public function getOrdenes()
    {
        $id = explode('.', session('nombre'))[1];

        $ordenes = Http::withHeaders(["Authorization" => "Bearer " . session('token')])->acceptJson()->get(env("API_URL") . "ordenes/almacen/$id")->json();

        return view('crearLote', ['ordenes' => $ordenes]);
    }

    public function crearLote(Request $request)
    {
        $datos = $request->validate([
            'tipo' => ['required', Rule::in(['0', '1'])],
            'orden' => Rule::requiredIf(function () use ($request) {
                return $request->input('tipo') == '0';
            }),
        ]);

        $idAlmacenDestino = '1';
        $idTroncal = '1';

        if (array_key_exists('orden', $datos) && !is_null($datos['orden'])) {
            list($idAlmacenDestino, $idTroncal) = explode(',', $datos['orden']);
        }

        $idAlmacenOrigen = explode('.', session('nombre'))[1];

        $dataToSend = [
            'almacenOrigen' => $idAlmacenOrigen,
            'ID_troncal' => $idTroncal,
            'ID_almacen_destino' => $idAlmacenDestino,
            'tipo' => $datos['tipo']
        ];


        try {
            $response = Http::withHeaders(["Authorization" => "Bearer " . session('token')])->acceptJson()->post(env('API_URL') . "lotes/create", $dataToSend);
            $responseData = $response->json();

            if (isset($responseData['message']) && $responseData['message'] === 'Lote creado exitosamente') {
                $request->session()->flash('message', 'Lote creado exitosamente');
            }
            return to_route('createLote.show');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al realizar la solicitud'], 500);
        }


    }

    public function crearPaquete(Request $request)
    {

        $datos = $request->validate([
            "cedula" => "required|int|digits:8",
            "ciudad" => "required|string",
            "direccion" => "required|string",
            "mail" => "required|email",
            "tipo" => "required|boolean",
        ]);
        $dir = $datos["direccion"] . ", " . $datos["ciudad"] . ", Uruguay";
        $idAlmacen = explode('.', session('nombre'))[0];

        $dataToSend = [
            "direccion" => $dir,
            "mail" => $datos["mail"],
            "seReparte" => $datos["tipo"],
            "idAlmacen" => $idAlmacen,
            "cedula" => $datos["cedula"],
        ];


        $response = Http::withHeaders(["Authorization" => "Bearer " . session('token')])->acceptJson()->post(env('API_URL') . "paquetes/create", $dataToSend);

        session()->flash('message', $response["message"]);
        return view('crearPaquete');
    }

    public function getPaqueteOrLoteCodigo(Request $request)
    {
        $codigo = $request->input('codigo');

        $tipoCodigo = '';

        if (substr($codigo, 0, 1) === 'L') {
            $tipoCodigo = 'L';
        } elseif (substr($codigo, 0, 1) === 'P') {
            $tipoCodigo = 'P';
        }

        if ($tipoCodigo === 'L') {
            $response = Http::withHeaders(["Authorization" => "Bearer " . session('token')])->acceptJson()->get(env('API_URL') . "lotes/$codigo");
        } elseif ($tipoCodigo === 'P') {
            $response = Http::withHeaders(["Authorization" => "Bearer " . session('token')])->acceptJson()->get(env('API_URL') . "paquetes/$codigo");
        } else {
            $response = ['error' => 'El formato del código no es válido'];
        }

        return $response;
    }


    public function asignarPeso(Request $request)
    {
        $paquete = $request->input('paquete');
        $peso = $request->input('peso');

        $response = Http::withHeaders(["Authorization" => "Bearer " . session('token')])->acceptJson()->get(env('API_URL') . "paquetes/peso/$paquete/$peso");
        session()->flash('message', $response['message']);
        return redirect()->back();
    }







    public function carga($paquetes)
    {
        $response = Http::withHeaders(["Authorization" => "Bearer " . session('token')])->acceptJson()->get(env('API_URL') . "cliente/carga/$paquetes");

        return redirect()->back()->with("message", $response['message']);
    }

    public function cargaAlmacen($paquetes, $lotes)
    {
        if ($paquetes != 'null' && $lotes == 'null') {
            $response1 = Http::withHeaders(["Authorization" => "Bearer " . session('token')])->acceptJson()->get(env('API_URL') . "almacen/carga?idPaquete=$paquetes");

            if ($response1->status() == 200) {
                return redirect()->back()->with("message", $response1['message']);
            } else {
                return redirect()->back()->with("message", $response1['message']['idPaquete'][0]);
            }

        } else if ($paquetes == 'null' && $lotes != 'null') {
            $response2 = Http::withHeaders(["Authorization" => "Bearer " . session('token')])->acceptJson()->get(env('API_URL') . "lotes/cargar?idLote=$lotes");

            if ($response2->status() == 200) {
                return redirect()->back()->with("message", $response2['message']);
            } else {
                return redirect()->back()->with("message", $response2['message']['idLote'][0]);
            }

        } else if ($paquetes != 'null' && $lotes != 'null') {
            $response1 = Http::withHeaders(["Authorization" => "Bearer " . session('token')])->acceptJson()->get(env('API_URL') . "almacen/carga?idPaquete=$paquetes");

            $response2 = Http::withHeaders(["Authorization" => "Bearer " . session('token')])->acceptJson()->get(env('API_URL') . "lotes/cargar?idLote=$lotes");

            if ($response2->status() == 200) {
                return redirect()->back()->with(
                    "message",
                    $response1['message'] .' - '. $response2["message"]
                );
            } else {
                return redirect()->back()->with(
                    "message",
                    $response1['message']['idPaquete'][0] .' - '. $response2["message"]['idLote'][0]
                );
            }
        }


    }

    public function descargaAlmacen($paquetes, $lotes)
    {
        $idAlmacenOrigen = explode('.', session('nombre'))[1];
        if ($paquetes != 'null' && $lotes == 'null') {

            $response1 = Http::withHeaders(["Authorization" => "Bearer " . session('token')])->acceptJson()->get(env('API_URL') . "almacen/descarga/$paquetes/$idAlmacenOrigen");

            return redirect()->back()->with("message", $response1['message']);


        } else if ($paquetes == 'null' && $lotes != 'null') {

            $response2 = Http::withHeaders(["Authorization" => "Bearer " . session('token')])->acceptJson()->get(env('API_URL') . "lotes/descargar?idLote=$lotes");

            if ($response2->status() == 200) {
                return redirect()->back()->with("message", $response2['message']);
            } else {
                return redirect()->back()->with("message", $response2['message']['idLote'][0]);
            }


        } else if ($paquetes != 'null' && $lotes != 'null') {
            $response1 = Http::withHeaders(["Authorization" => "Bearer " . session('token')])->acceptJson()->get(env('API_URL') . "almacen/descarga/$paquetes/$idAlmacenOrigen");

            $response2 = Http::withHeaders(["Authorization" => "Bearer " . session('token')])->acceptJson()->get(env('API_URL') . "lotes/descargar?idLote=$lotes");

            if ($response2->status() == 200) {
                return redirect()->back()->with(
                    "message",
                    $response1['message'] .' - '. $response2["message"]
                );
            } else {
                return redirect()->back()->with(
                    "message",
                    $response1['message'] .' - '. $response2["message"]['idLote'][0]
                );
            }

        }
    }
}

