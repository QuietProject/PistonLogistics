<?php

namespace App\Http\Controllers;

use App\Models\Paquete;
use App\Models\Trae;
use App\Models\Vehiculo;
use App\Models\Lote;
use App\Models\Orden;
use App\Models\PaqueteLote;
use App\Models\DestinoLote;
use Illuminate\Http\Request;
use App\Http\Resources\PaqueteResource;
use App\Models\AlmacenCliente;
use App\Models\AlmacenPropio;
use App\Models\Lleva;
use Illuminate\Support\Facades\Http;

class PaqueteController extends Controller
{

    private $apiKey = "9jLvsXLdz76cSLHe37HXXEJM4rw6SZ0hwSz3nZkSPV4";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Paquete::all();
    }

    public function paquetesLote($id)
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $idAlmacen)
    {
        // Valido los datos del paquete
        $validated = request()->validate([
            "direccion" => "required|string",
            "mail" => "required|email",
            "cedula" => "required|numeric|digits:8",
        ]);

        // Valido que el almacen exista
        if (AlmacenCliente::find($idAlmacen) === null) {
            return response()->json([
                "message" => "El almacen no existe"
            ], 404);
        }

        // Obtengo las coordenadas la de direccion del paquete
        $direccion = $validated["direccion"];
        $coordenadasPaquete = Http::acceptJson()->withOptions(['verify' => false])->get("https://geocode.search.hereapi.com/v1/geocode?q=$direccion&apiKey=$this->apiKey")["items"][0]["position"];

        // genero una array con las coordenadas de todos los almacenes propios y sus respectivas ID, y otro igual sin las ID
        // $arrayAlmacenes = [];
        $coordenadasAlmacenes = [];
        $arrayAlmacenes = AlmacenPropio::all()->pluck("ID");
        // return $arrayAlmacenes;
        foreach (AlmacenPropio::all() as $almacen) {
            // Creo la copia de $almacenData sin la ID
            $coordenadasAlmacenes[] = $almacen->almacen()->select("longitud as lng", "latitud as lat")->first();
        }
        // return $coordenadasAlmacenes;

        // Calculo la distancia entre la direccion del paquete y cada almacen propio
        $distancias = Http::acceptJson()->withOptions(['verify' => false])->post("https://matrix.router.hereapi.com/v8/matrix?async=false&apiKey=$this->apiKey", [
            "origins" => [
                [
                    "lat" => $coordenadasPaquete["lat"],
                    "lng" => $coordenadasPaquete["lng"]
                ]
            ],
            "destinations" => $coordenadasAlmacenes,
            "regionDefinition" => [
                "type" => "world"
            ],
            "matrixAttributes" => [
                "distances"
            ],
            ])->json()["matrix"]["distances"];

        // return $distancias;
        $idPickUp = $arrayAlmacenes[array_search(min($distancias), $distancias)];
        // return $idPickUp;
        $paquete = Paquete::create([
            "direccion" => $validated["direccion"],
            "mail" => $validated["mail"],
            "cedula" => $validated["cedula"],
            "ID_almacen" => $idAlmacen,
            "ID_pickup" => $idPickUp,
        ]);
        return new PaqueteResource($paquete);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Paquete  $paquete
     * @return \Illuminate\Http\Response
     */
    public function show(Paquete $paquete)
    {
        return new PaqueteResource($paquete);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Paquete  $paquete
     * @return \Illuminate\Http\Response
     */
    public function edit(Paquete $paquete)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Paquete  $paquete
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paquete $paquete)
    {
        //
    }

    public function cargaCliente($id, $matricula)
    {
        if (!is_numeric($id)) {
            return response()->json([
                "message" => "ID debe ser numérico"
            ], 400);
        }

        $paquete = Paquete::find($id);
        if ($paquete === null) {
            return response()->json([
                "message" => "Paquete no encontrado"
            ], 404);
        }

        // Find a vehiculo by its matricula (license plate)
        $vehiculo = Vehiculo::where('matricula', $matricula)->first();

        if ($vehiculo === null) {
            return response()->json([
                "message" => "Vehiculo no encontrado"
            ], 404);
        }

        Trae::create([
            "ID_paquete" => $id,
            "matricula" => $matricula,
        ]);

        return response()->json([
            "message" => "Paquete cargado"
        ], 200);
    }



    public function descarga($id)
    {

        $paquete = Paquete::find($id);
        if ($paquete === null) {
            return response()->json([
                "message" => "Paquete no encontrado"
            ], 404);
        }


        Trae::where(["ID_paquete" => $id])->update([
            "fecha_descarga" => now(),
        ]);

        $almacen = explode(".", session()->get("user"))[0];
        $paquete = Paquete::find($id);
        // busco si hay algun lote en la tabla destino_lote que tenga el mismo almacen destino que el paquete
        $destinoLote = DestinoLote::where("ID_almacen", $paquete->ID_pickup)->first();
        // Busco una troncal que tenga el mismo almacen que el paquete y agarro su ID
        $troncal = Orden::where("ID_almacen", $almacen)->first()->troncal->ID;
        // Si no hay ningun lote con el mismo almacen destino que el paquete o el lote es de tipo 1 (no se reparte) creo un nuevo lote
        if ($destinoLote === null || $destinoLote->lote->tipo == 1) {

            $lote = Lote::create([
                "ID_troncal" => $troncal,
                "ID_almacen" => $almacen,
                "tipo" => 0,
            ]);
        } else {
            // Si hay un lote con el mismo almacen destino que el paquete, lo agarro
            $lote = $destinoLote->lote;
        }

        PaqueteLote::create([
            "ID_paquete" => $id,
            "ID_lote" => $lote->ID,
            "fecha" => now(),
        ]);


        return response()->json([
            "message" => "Paquete descargado y lote asignado"
        ], 200);
    }

    public function cargaAlmacen($id, $matricula)
    {
        if (!is_numeric($id)) {
            return response()->json([
                "message" => "ID debe ser numérico"
            ], 400);
        }

        $lote = Lote::find($id);
        if ($lote === null) {
            return response()->json([
                "message" => "Lote no encontrado"
            ], 404);
        }

        // Find a vehiculo by its matricula (license plate)
        $vehiculo = Vehiculo::where('matricula', $matricula)->first();

        if ($vehiculo === null) {
            return response()->json([
                "message" => "Vehiculo no encontrado"
            ], 404);
        }

        Lleva::create([
            "ID_lote" => $id,
            "matricula" => $matricula,
        ]);

        return response()->json([
            "message" => "Lote cargado"
        ], 200);
    }
}
