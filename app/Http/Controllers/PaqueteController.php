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
use App\Models\Troncal;
use Illuminate\Auth\Events\Validated;

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
    public function index()
    {
        $validator = Validator([
            "idAlmacen" => "bail|required|numeric|exists:almacenes_propios,ID",
        ]);
        if ($this->validacion($validator)) {
            return $this->validacion($validator);
        }

        $idAlmacen = request()->idAlmacen;

        if ($idAlmacen == null){
            return PaqueteResource::collection(Paquete::all());
        }

        $paquetesEnAlmacen = PaqueteAlmacen::where("ID_almacen", $idAlmacen)->whereNull("hasta")->get();
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
        ]);
        return response()->json([
            "message" => "Paquete creado exitosamente",
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
            "message" => "Paquete cargado exitosamente",
        ], 200);
    }

    /*************************************************************************************************************************************/

    public function descargaPaquete($idPaquete, $idAlmacen)
    {
        // try {
            if (!is_numeric($idPaquete)) {
                return response()->json([
                    "message" => "ID debe ser numérico"
                ], 400);
            }

            if (Paquete::find($idPaquete) === null) {
                return response()->json([
                    "message" => "Paquete no encontrado"
                ], 404);
            }

            if (Trae::find($idPaquete) === null) {
                return response()->json([
                    "message" => "Paquete no cargado"
                ], 400);
            }

            if (Trae::where("ID_paquete", $idPaquete)->whereNull("fecha_descarga")->first() === null) {
                return response()->json([
                    "message" => "Paquete ya descargado"
                ], 400);
            }

            if (AlmacenPropio::find($idAlmacen) === null) {
                return response()->json([
                    "message" => "Almacen no encontrado"
                ], 404);
            }

            if (Reparte::find($idPaquete) !== null) {
                return $this->reparteRebotado($idPaquete, $idAlmacen);
            }


            DB::select("CALL descargar_trae($idPaquete, $idAlmacen, @error)");
            $error = DB::select("SELECT @error as error")[0]->error;
            if ($error !== 0) {
                return response()->json([
                    "message" => "Error al descargar paquete"
                ], 400);
            }

            $paquete = Paquete::find($idPaquete);

            if ($paquete->ID_pickup == $idAlmacen) {
                if ($paquete->direccion == null){
                    $lote = $this->paqueteToPickup($idPaquete, $idAlmacen);
                    return response()->json([
                        "message" => "Paquete descargado y pronto para recoger en pickup",
                        "paquete" => Paquete::find($idPaquete),
                        "lote" => $lote,
                    ], 200);
                }
                return response()->json([
                    "message" => "Paquete descargado y pronto para repartir",
                    "paquete" => Paquete::find($idPaquete),
                ], 200);
            // Los que no estén en su destino final se agregan a un nuevo lote para ser enviados de nuevo
            }else{
                $lote = $this->getOrCreateLote($idAlmacen, $paquete->ID_pickup);
                $this->asignarPaqueteToLote($idPaquete, $lote->ID);
                return response()->json([
                    "message" => "Paquete descargado y lote asignado",
                    "paquete" => $paquete,
                    "lote" => $lote,
                ], 200);
            }

            
        // } catch (\Exception $e) {
        //     return response()->json([
        //         "message" => "Error inesperado"
        //     ], 500);
        // }
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
        $validator = Validator::make($request->all(), [
            "idPaquete" => [
                "bail",
                "required",
                "numeric",
                "exists:PAQUETES,ID",
                "unique:REPARTE,ID_paquete",
                Rule::exists("PAQUETES", "ID")->whereNotNull("direccion")
            ],
            "matricula" => [
                "bail",
                "required",
                "string",
                "exists:CAMIONETAS,matricula",
            ],
        ], );
        if ($this->validacion($validator)) {
            return $this->validacion($validator);
        }

        DB::select("Insert into REPARTE (ID_paquete, matricula) values ($request->idPaquete, '$request->matricula')");

        return response()->json([
            "message" => "Paquete cargado correctamente ",
        ], 200);
    }


    /*************************************************************************************************************************************/

    public function getOrCreateLote(/*$loteAlmacenOrigen, $paqueteAlmacenDestino*/)
    {
        $validated = request()->validate([
            "loteAlmacenOrigen" => "required|numeric",
            "paqueteAlmacenDestino" => "required|numeric",
        ]);

        $loteAlmacenOrigen = $validated["loteAlmacenOrigen"];
        $paqueteAlmacenDestino = $validated["paqueteAlmacenDestino"];

        // tomo todas las troncales que contengan el almacen de origen y de destino del paquete
        $troncales = Orden::whereIn("ID_almacen", [$loteAlmacenOrigen, $paqueteAlmacenDestino])->pluck("ID_troncal");
        $troncalesFinales = array_values(array_unique(array_diff_assoc($troncales->toArray(), array_unique($troncales->toArray()))));
        // $troncalesAlmacenOrigen = Orden::where("ID_almacen", $loteAlmacenOrigen)->pluck("ID_troncal");
        // $troncalesAlmacenDestino = Orden::where("ID_almacen", $paqueteAlmacenDestino)->pluck("ID_troncal");
        // return $troncalesAlmacenOrigen;
        // // return $troncalesFinales;
        // if(empty($troncalesFinales)){
        //     $troncal = Orden::whereIn("ID_troncal", [$troncalesAlmacenOrigen, ])->pluck("ID_troncal");
        // }
        // return $troncal;

        // // busco si hay algun lote en la tabla destino_lote que tenga el mismo almacen destino que el paquete y la misma troncal
        $idLote = DB::select("SELECT LOTES.ID from LOTES join DESTINO_LOTE on DESTINO_LOTE.ID_lote = LOTES.ID where DESTINO_LOTE.ID_almacen = $paqueteAlmacenDestino and DESTINO_LOTE.ID_troncal = $troncalesFinales[0] and LOTES.ID_almacen = $loteAlmacenOrigen and LOTES.fecha_pronto is null");

        // Si encuentra un lote con el mismo almacen destino que el paquete y la misma troncal, lo agarro
        if ($idLote != null) {
            $lote = Lote::find($idLote[0]->ID);

            // Si no hay ningun lote con el mismo almacen destino que el paquete o el lote es de tipo 1 (no se reparte) creo un nuevo lote
        } else {
            DB::select("CALL lote_0($loteAlmacenOrigen, $paqueteAlmacenDestino, $troncales[0], @id_lote, @error)");
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

    
}
