<?php

namespace App\Http\Controllers;

use App\Models\Paquete;
use App\Models\Trae;
use App\Models\Vehiculo;
use App\Models\Lote;
use App\Models\Orden;
use App\Models\PaqueteLote;
use App\Models\DestinoLote;
use App\Models\AlmacenCliente;
use App\Models\AlmacenPropio;
use App\Models\Lleva;
use App\Models\PaqueteAlmacen;
use App\Models\Reparte;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Http\Resources\PaqueteResource;
use App\Http\Controllers\Controller;

class PaqueteController extends Controller
{

    private $apiKey = "9jLvsXLdz76cSLHe37HXXEJM4rw6SZ0hwSz3nZkSPV4";

    /*************************************************************************************************************************************/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Paquete::all();
    }

    /*************************************************************************************************************************************/

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
        ]);

        // Valido que el almacen exista
        if (AlmacenCliente::find($idAlmacen) === null) {
            return response()->json([
                "message" => "El almacen no existe"
            ], 404);
        }

        // Obtengo las coordenadas de la direccion del paquete
        $direccion = $validated["direccion"];
        // return $direccion;
        $coordenadasPaquete = Http::acceptJson()->withOptions(['verify' => false])->get("https://geocode.search.hereapi.com/v1/geocode?q=$direccion&apiKey=$this->apiKey")["items"][0]["position"];

        // Genero una array con los ID de los almacenes propios
        $arrayAlmacenes = AlmacenPropio::all()->pluck("ID");
        // Genero una array con las coordenadas de los almacenes propios
        $almacenesPropios = AlmacenPropio::all();
        $coordenadasAlmacenes = $almacenesPropios->map(function ($almacenPropio) {
            return [
                'lng' => $almacenPropio->almacen->longitud,
                'lat' => $almacenPropio->almacen->latitud,
            ];
        });

        // Calculo la distancia entre la direccion del paquete y cada almacen propio
        Http::post(url, ["direccion" => "Artigas", "mail"=> "asdfa@gmail.com"])
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

        // Selecciono la ID del almacen más cercano a la direccion del paquete
        $idPickUp = $arrayAlmacenes[array_search(min($distancias), $distancias)];
        $paquete = Paquete::create([
            "direccion" => $direccion,
            "mail" => $validated["mail"],
            "ID_almacen" => $idAlmacen,
            "ID_pickup" => $idPickUp,
        ]);
        return response()->json([
            "message" => "Paquete creado",
            "ID" => $paquete->ID,
        ], 201);
    }
    /*************************************************************************************************************************************/
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
    /*************************************************************************************************************************************/

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

        $trae = Trae::find($id);
        if ($trae !== null) {
            return response()->json([
                "message" => "Paquete ya está cargado"
            ], 400);
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

    /*************************************************************************************************************************************/

    public function descargaPaquete($id, $almacen)
    {
        try {
            if (!is_numeric($id)) {
                return response()->json([
                    "message" => "ID debe ser numérico"
                ], 400);
            }

            if (Paquete::find($id) === null) {
                return response()->json([
                    "message" => "Paquete no encontrado"
                ], 404);
            }

            if (Trae::find($id) === null) {
                return response()->json([
                    "message" => "Paquete no cargado"
                ], 400);
            }

            if (Trae::where("ID_paquete", $id)->whereNull("fecha_descarga")->first() === null) {
                return response()->json([
                    "message" => "Paquete ya descargado"
                ], 400);
            }

            if (AlmacenPropio::find($almacen) === null) {
                return response()->json([
                    "message" => "Almacen no encontrado"
                ], 404);
            }

            if (Reparte::find($id) !== null) {
                $this->reparteRebotado($id, $almacen);
            }


            DB::select("CALL descargar_trae($id, $almacen, @error)");
            $error = DB::select("SELECT @error as error")[0]->error;
            if ($error !== 0) {
                return response()->json([
                    "message" => "Error al descargar paquete"
                ], 400);
            }

            $paquete = Paquete::find($id);
            $lote = $this->getOrCreateLote($almacen, $paquete->ID_pickup);
            $this->asignarPaqueteToLote($id, $lote->ID);

            return response()->json([
                "message" => "Paquete descargado y lote asignado",
                "ID_lote" => $lote->ID,
                "paquete" => $paquete,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Error inesperado"
            ], 500);
        }
    }

    // Método para obtener o crear un lote
    private function getOrCreateLote($almacen, $paquetePickup)
    {
        // tomo todas las troncales que contengan el almacen de origen y de destino del paquete
        $troncales = Orden::whereIn("ID_almacen", [$almacen, $paquetePickup])->pluck("ID_troncal");
        $troncales = array_values(array_unique(array_diff_assoc($troncales->toArray(), array_unique($troncales->toArray()))));

        // busco si hay algun lote en la tabla destino_lote que tenga el mismo almacen destino que el paquete y la misma troncal
        $destinoLote = DestinoLote::where("ID_almacen", $paquetePickup)->where("ID_troncal", $troncales)->first();
        $destinoLote = DB::select("SELECT lotes.ID_lote from ")

        // Si encuentra un lote con el mismo almacen destino que el paquete y la misma troncal, lo agarro
        if ($destinoLote !== null && $destinoLote->lote->tipo == 0) {
            $lote = $destinoLote->lote;

        // Si no hay ningun lote con el mismo almacen destino que el paquete o el lote es de tipo 1 (no se reparte) creo un nuevo lote
        } else {
            DB::select("CALL lote_0($almacen, $paquetePickup, $troncales[0], @id_lote, @error)");
            $error = DB::select("SELECT @error as error")[0]->error;
            if ($error !== 0) {
                return response()->json([
                    "message" => "Error al crear lote"
                ], 400);
            }
            // Agarro el lote completo
            $lote = Lote::find(DB::select("SELECT @id_lote as id_lote")[0]->id_lote);
        }

        return $lote;
    }

    private function reparteRebotado($idPaquete, $idAlmacen)
    {
        //Se descarga el paquetes de reparte y se asigna a paquetes_almacenes
        DB::select("CALL descargar_reparte($idPaquete, $idAlmacen, @error)");
        $error = DB::select("SELECT @error as error")[0]->error;
        if ($error !== 0) {
            return response()->json([
                "message" => "Error al descargar paquete"
            ], 400);
        }

        //Se toma un lote de tipo 1(no se reparte) en el almacen donde se descargaron los paquetes y si no existe se crea
        $lote = Lote::where("ID_almacen", $idAlmacen)->where("tipo", 1)->first()->ID;
        if ($lote == null) {
            DB::select("CALL lote_1($idAlmacen, @id_lote, @error)");
            $error = DB::select("SELECT @error as error")[0]->error;
            if ($error !== 0) {
                return response()->json([
                    "message" => "Error al crear lote"
                ], 400);
            }
        }
        //Se asigna el paquete al lote
        $this->asignarPaqueteToLote($idPaquete, $lote->ID);
        return response()->json([
            "message" => "Paquete descargado y lote asignado",
            "ID_lote" => $lote->ID,
            "paquete" => Paquete::find($idPaquete),
        ], 200);
    }

    /*************************************************************************************************************************************/
    
    public function cargaReparte()
    {
        $validated = request()->validate([
            "ID_paquete" => "required|numeric|exists:paquetes,ID",
            "matricula" => "required|string|size:7|exists:vehiculos,ID",
        ]);

        $paquete = PaqueteAlmacen::find($validated["ID_paquete"]);
        if ($paquete === null) {
            return response()->json([
                "message" => "Paquete no encontrado"
            ], 404);
        }

        if (Reparte::find($validated["ID_paquete"]) !== null) {
            return response()->json([
                "message" => "Paquete ya cargado"
            ], 400);
        }

        Reparte::create([
            "ID_paquete" => $validated["ID_paquete"],
            "matricula" => $validated["matricula"],
        ]);

        return response()->json([
            "message" => "Paquete cargado correctamente ",
        ], 200);
    }


    /*************************************************************************************************************************************/

    public function agregarPaqueteToLote()
    {
        $validated = request()->validate([
            "ID_paquete" => "required|numeric|exists:paquetes,ID",
            "ID_lote" => "required|numeric|exists:lotes,ID",
        ]);

        $paquetesEnLotes = PaqueteLote::where("ID_paquete", $validated["ID_paquete"])->whereNull("hasta")->get();
        if ($paquetesEnLotes !== null) {
            return response()->json([
                "message" => "Paquete ya en un lote"
            ], 400);
        }

        $this->asignarPaqueteToLote($validated["ID_paquete"], $validated["ID_lote"]);

        return response()->json([
            "message" => "Paquete agregado a lote"
        ], 200);
    }

    /*************************************************************************************************************************************/
}
