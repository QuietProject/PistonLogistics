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
use App\Http\Controllers\OrdenController;
use App\Models\Troncal;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Str;

use function PHPSTORM_META\type;

class PaqueteController extends Controller
{

    private $apiKey = "9jLvsXLdz76cSLHe37HXXEJM4rw6SZ0hwSz3nZkSPV4";

    /*************************************************************************************************************************************/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "idAlmacen" => "bail|numeric|exists:almacenes_propios,ID",
        ]);
        if ($this->validacion($validator)) {
            return $this->validacion($validator);
        }

        $idAlmacen = request()->idAlmacen;

        if ($idAlmacen == null) {
            return PaqueteResource::collection(Paquete::all());
        }

        $paquetesEnAlmacen = PaqueteAlmacen::where("PAQUETES_ALMACENES.ID_almacen", $idAlmacen)->whereNull("hasta")
        ->join("PAQUETES", "PAQUETES.ID", "PAQUETES_ALMACENES.ID_paquete")
        // ->select("PAQUETES.*")
        ->get();
        // return $paquetesEnAlmacen->to_array();
        // $lotesEnLleva = Lleva::all()->pluck("ID_lote");
        // $lotesEnAlmacen = Lote::where("ID_almacen", $idAlmacen)->whereNull("fecha_cerrado")->whereNotIn("ID", $lotesEnLleva)->pluck("ID");

        // $paquetesEnLoteEnAlmacen = PaqueteLote::whereIn("ID_lote", $lotesEnAlmacen)->get();

        // $paquetesEnAlmacen = $paquetesEnAlmacen->concat($paquetesEnLoteEnAlmacen)->sort();

        return PaqueteResource::collection($paquetesEnAlmacen);
    }

    /*************************************************************************************************************************************/

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Valido los datos del paquete
        $validated = request()->validate([
            "direccion" => "required|string",
            "mail" => "required|email",
            "seReparte" => "required|boolean",
            "idAlmacen" => "required|numeric|exists:almacenes_clientes,ID",
            "cedula" => "required|numeric|digits:8"
        ]);


        // Obtengo las coordenadas de la direccion del paquete
        $direccion = $validated["direccion"];
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

        // Si el paquete no se reparte se le borra la direccion
        if (!$validated["seReparte"]) {
            $direccion = null;
        }
        $paquete = Paquete::create([
            "direccion" => $direccion,
            "mail" => $validated["mail"],
            "ID_almacen" => $validated["idAlmacen"],
            "ID_pickup" => $idPickUp,
            "cedula" => $validated["cedula"],
        ]);
        return response()->json([
            "message" => "Paquete creado exitosamente",
            "ID" => $paquete->ID,
            "codigo" => $paquete->codigo,
        ], 201);
    }
    /*************************************************************************************************************************************/
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Paquete  $paquete
     * @return \Illuminate\Http\Response
     */
    public function show($codigo)
    {
        $paquete = Paquete::where("codigo", $codigo)->first();
        if ($paquete === null) {
            return response()->json([
                "message" => "Paquete no encontrado"
            ], 404);
        }
        return new PaqueteResource($paquete);
    }

    /*************************************************************************************************************************************/

    public function cargaCliente($idsPaquetes)
    {
        $idArray = explode(',', $idsPaquetes);

        foreach ($idArray as $singleId) {
            if (!is_numeric($singleId)) {
                return response()->json([
                    "message" => "ID debe ser numérico"
                ], 400);
            }

            $paquete = Paquete::find($singleId);
            if ($paquete === null) {
                return response()->json([
                    "message" => "Paquete con ID $singleId no encontrado"
                ], 404);
            }

            $trae = Trae::find($singleId);
            if ($trae === null) {
                return response()->json([
                    "message" => "Paquete con ID $singleId no asignado a ningun camion"
                ], 400);
            }

            $trae = Trae::where("ID_paquete", $singleId)->whereNotNull("fecha_carga")->get();
            if (count($trae) > 0) {
                return response()->json([
                    "message" => "Paquete con ID $singleId ya está cargado"
                ], 400);
            }

            $trae = Trae::find($singleId);
            $trae->fecha_carga = now();
            $trae->save();
        }

        return response()->json([
            "message" => "Paquete(s) cargado(s) exitosamente",
        ], 200);
    }


    /*************************************************************************************************************************************/

    public function descargaPaquete($idPaquete, $idAlmacen)
    {
        $idPaqueteArray = explode(',', $idPaquete);

        foreach ($idPaqueteArray as $singleIdPaquete) {
            if (!is_numeric($singleIdPaquete)) {
                return response()->json([
                    "message" => "ID del paquete debe ser numérico"
                ], 400);
            }

            if (Paquete::find($singleIdPaquete) === null) {
                return response()->json([
                    "message" => "Paquete con ID $singleIdPaquete no encontrado"
                ], 404);
            }

            if (Trae::find($singleIdPaquete) === null) {
                return response()->json([
                    "message" => "Paquete con ID $singleIdPaquete no cargado"
                ], 400);
            }

            if (Trae::where("ID_paquete", $singleIdPaquete)->whereNull("fecha_descarga")->first() === null) {
                return response()->json([
                    "message" => "Paquete con ID $singleIdPaquete ya descargado"
                ], 400);
            }

            if (AlmacenPropio::find($idAlmacen) === null) {
                return response()->json([
                    "message" => "Almacen con ID $idAlmacen no encontrado"
                ], 404);
            }

            if (Reparte::find($singleIdPaquete) !== null) {
                return $this->reparteRebotado($singleIdPaquete, $idAlmacen);
            }

            DB::select("CALL descargar_trae($singleIdPaquete, $idAlmacen, @error)");
            $error = DB::select("SELECT @error as error")[0]->error;
            if ($error !== 0) {
                return response()->json([
                    "message" => "Error al descargar paquete con ID $singleIdPaquete"
                ], 400);
            }

            $paquete = Paquete::find($singleIdPaquete);

            if ($paquete->ID_pickup == $idAlmacen) {
                if ($paquete->direccion == null) {
                    $lote = $this->paqueteToPickup($singleIdPaquete, $idAlmacen);
                    // return response()->json([
                    //     "message" => "Paquete con ID $singleIdPaquete descargado y pronto para recoger en pickup",
                    //     "paquete" => Paquete::find($singleIdPaquete),
                    //     "lote" => $lote,
                    // ], 200);
                }
                // return response()->json([
                //     "message" => "Paquete con ID $singleIdPaquete descargado y pronto para repartir",
                //     "paquete" => Paquete::find($singleIdPaquete),
                // ], 200);
            } else {
                $lote = $this->getOrCreateLote($idAlmacen, $paquete->ID_pickup);
                $this->asignarPaqueteToLote($singleIdPaquete, $lote->ID);
                // return response()->json([
                //     "message" => "Paquete con ID $singleIdPaquete descargado y lote asignado",
                //     "paquete" => $paquete,
                //     "lote" => $lote,
                // ], 200);
            }
        }

        return response()->json([
            "message" => "Paquete(s) descargado(s) exitosamente",
        ], 200);
    }


    /****************************************************************************************************************************************/

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

    public function cargaReparte(Request $request)
    {
        $idPaqueteArray = explode(',', $request->idPaquete);

        foreach ($idPaqueteArray as $singleIdPaquete) {
            $validator = Validator::make(["idPaquete" => $singleIdPaquete], [
                "idPaquete" => [
                    "bail",
                    "required",
                    "numeric",
                    "exists:PAQUETES,ID",
                    "unique:REPARTE,ID_paquete",
                    Rule::exists("PAQUETES", "ID")->whereNotNull("direccion"),
                    Rule::exists("REPARTE", "ID_paquete")->whereNotNull("fecha_asignado"),
                    Rule::exists("REPARTE", "ID_paquete")->whereNotNull("fecha_asignado")->whereNull("fecha_carga"),
                ],
            ]);

            if ($this->validacion($validator)) {
                return $this->validacion($validator);
            }

            $reparte = Reparte::find($singleIdPaquete);
            $reparte->fecha_carga = now();
            $reparte->save();
        }

        return response()->json([
            "message" => "Paquete(s) cargado(s) correctamente ",
        ], 200);
    }



    /*************************************************************************************************************************************/
}
