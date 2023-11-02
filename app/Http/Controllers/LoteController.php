<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lote;
use App\Http\Resources\LoteResource;
use App\Models\AlmacenPropio;
use App\Models\PaqueteLote;
use App\Models\Lleva;
use App\Models\Paquete;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class LoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Lote::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $almacenOrigen = $request->almacenOrigen;
        $validated = request()->validate([
            "ID_troncal" => "numeric|exists:troncales,ID",
            "ID_almacen_destino" => "numeric|exists:almacenes_propios,ID",
            "tipo" => "required|numeric|in:0,1",
        ]);

        if (AlmacenPropio::find($almacenOrigen) == null) {
            return response()->json([
                "message" => "Almacen origen no existe"
            ], 400);
        }
        if ($validated["tipo"] == 0) {
            $idAlmacenDestino = $validated["ID_almacen_destino"];
            $idTroncal = $validated["ID_troncal"];
        }


        if ($validated["tipo"] == 0) {
            DB::select("CALL lote_0($almacenOrigen, $idAlmacenDestino, $idTroncal, @idLote, @error)");
            $error = DB::select("SELECT @error as error")[0]->error;
        } else {
            DB::select("CALL lote_1($almacenOrigen, @idLote, @error)");
            $error = DB::select("SELECT @error as error")[0]->error;
        }

        if ($error != null) {
            return response()->json([
                "message" => $error
            ], 400);
        }

        $idLote = DB::select("SELECT @idLote as idLote")[0]->idLote;
        $lote = Lote::find($idLote);

        return new LoteResource($lote);
    }

    /**************************************************************************************************************************/

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Lote::find($id);
    }

    /**************************************************************************************************************************/

    public function paquetesEnLote(Request $request)
    {
        $idsLote = array_map("intval", explode(",", $request->idsLote));
        // return $idsLote;
        $lotes = Lote::whereIn("ID", $idsLote)->get();
        // return $lote;
        if ($lotes == null) {
            return response()->json([
                "message" => "Lote no existe"
            ], 400);
        }

        $paquetesEnLotes = PaqueteLote::whereIn("ID_lote", $idsLote)->get();

        // Verifica si se encontraron registros
        if ($paquetesEnLotes->isEmpty()) {
            return response()->json([
                "message" => "No se encontraron paquetes en los lotes especificados"
            ], 400);
        }

        // Organiza los paquetes por lote
        $paquetesPorLote = [];

        foreach ($paquetesEnLotes as $paqueteEnLote) {
            $loteID = $paqueteEnLote->ID_lote;
            $paquete = $paqueteEnLote->paquete;

            if (!isset($paquetesPorLote[$loteID])) {
                $paquetesPorLote[$loteID] = [];
            }

            $paquetesPorLote[$loteID][] = $paquete;
        }

        return response()->json($paquetesPorLote, 200);
    }

    /*************************************************************************************************************************************/

    public function quitarPaquete()
    {
        $validated = request()->validate([
            "ID_lote" => "required|numeric|exists:lotes,ID",
            "ID_paquete" => "required|numeric|exists:paquetes,ID",
        ]);

        $lote = Lote::find($validated["ID_lote"]);
        $paquete = $lote->paquetes()->where("ID", $validated["ID_paquete"])->first();

        if ($paquete == null) {
            return response()->json([
                "message" => "Paquete no existe en el lote"
            ], 400);
        }

        $lote->paquetes()->detach($validated["ID_paquete"]);

        return response()->json([
            "message" => "Paquete quitado del lote"
        ], 200);
    }

    /*************************************************************************************************************************************/

    public function lotePronto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "idLote" => [
                "bail",
                "required",
                "numeric",
                function ($attribute, $value, $fail) {
                    $lotExists = DB::table('lotes')->where('ID', $value)->exists();
                    $lotIsReady = DB::table('lotes')->where('ID', $value)->whereNull('fecha_pronto')->exists();

                    if (!$lotExists) {
                        $fail("El lote no existe");
                    } elseif (!$lotIsReady) {
                        $fail("El lote ya está pronto");
                    }
                },
            ],
        ], [
            "idLote.required" => "El id del lote es requerido",
            "idLote.numeric" => "El id del lote debe ser un número",
        ]);
        if ($this->validacion($validator)) {
            return $this->validacion($validator);
        }

        $lote = lote::find($request->idLote);
        $lote->fecha_pronto = now();
        $lote->save();
        return response()->json([
            "message" => "Lote listo para enviar"
        ], 200);
    }

    /*************************************************************************************************************************************/

    public function cargaLote(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                "idLote" => [
                    "bail",
                    "required",
                    "numeric",
                    "unique:Lleva,ID_lote",
                    function ($attribute, $value, $fail) {
                        $loteExiste = DB::table('lotes')->where('ID', $value)->exists();
                        $lotePronto = DB::table('lotes')->where('ID', $value)->whereNull('fecha_pronto')->exists();


                        if (!$loteExiste) {
                            $fail("El lote no existe");
                        } elseif ($lotePronto) {
                            $fail("El lote no está pronto");
                        }
                    },
                ],
                "matricula" => ["bail", "required", "string", "size:7", "exists:camiones,matricula"],
            ],
            [
                "idLote.required" => "El id del lote es requerido",
                "idLote.numeric" => "El id del lote debe ser un número",
                "idLote.unique" => "El lote ya está cargado",
                "matricula.required" => "La matricula es requerida",
                "matricula.string" => "La matricula debe ser un string",
                "matricula.size" => "La matricula debe tener 7 caracteres",
                "matricula.exists" => "La matricula no existe",
            ]
        );
        if ($this->validacion($validator)) {
            return $this->validacion($validator);
        }

        Lleva::create([
            "ID_lote" => $request->idLote,
            "matricula" => $request->matricula,
        ]);

        return response()->json([
            "message" => "Lote cargado"
        ], 200);
    }


    /*************************************************************************************************************************************/

    public function descargaLote(Request $request)
    {
        // try {
            $validator = Validator::make($request->all(), [
                "idLote" => ["required", "numeric", "exists:lotes,ID", Rule::exists("lleva", "ID_lote")->whereNull("fecha_descarga")],
                "matricula" => ["required", "string", "size:7", "exists:camiones,matricula"],
            ]);
            if ($this->validacion($validator)) {
                return $this->validacion($validator);
            }

            //descarga el lote de lleva
            $idLote = $request->idLote;
            // return $idLote;
            // $lleva = Lleva::where("ID_lote", $idLote)->whereNull("fecha_descarga")->first();
            // $lleva->fecha_descarga = now();
            // $lleva->save();

            //Cierra el lote y deja todos sus paquetes en la tabla paquetes_almacenes
            $lote = Lote::find($idLote);
            //tomo las ids de los paquetes del lote
            $paquetesIds = $lote->paquetes()->pluck("ID");
            //tomo el almacen destino del lote
            $destinoLote = $lote->destino_lote()->pluck("ID_almacen")->first();
            // $lote->fecha_cerrado = now();
            // $lote->save();

            //recorro los paquetes y los que no estén en su destino final se agregan a un nuevo lote para ser enviados de nuevo
            foreach ($paquetesIds as $paqueteId) {
                // De los paquetes que ya están en su destino final asigno los que no se reparten a un lote de tipo 1
                if ($paqueteId->ID_pickup == $destinoLote){
                    $this->paqueteToPickup($paqueteId, $destinoLote);
                }

                // Los que no estén en su destino final se agregan a un nuevo lote para ser enviados de nuevo
                
                
            }


            return response()->json([
                "message" => "Lote descargado y paquetes asignados",
                "ID_lote" => $lote->ID,
            ], 200);
        // } catch (\Exception $e) {
        //     return response()->json([
        //         "message" => "Error inesperado"
        //     ], 500);
        // }
    }

    private function paqueteToPickup($paqueteId, $destinoLote){
        $paquete = Paquete::find($paqueteId);
        //Busco si existe un lote tipo 1 en el almacen destino del paquete
        $lote = Lote::where("ID_almacen", $destinoLote)->whereNull("fecha_cerrado")->where("tipo", 1)->first();
        //Si no existe, lo creo
        if ($lote == null) {
            DB::select("CALL lote_1($destinoLote, @idLote, @error)");
            $error = DB::select("SELECT @error as error")[0]->error;
            if ($error != null) {
                return response()->json([
                    "message" => $error
                ], 400);
            }
            $lote = Lote::find(DB::select("SELECT @idLote as idLote")[0]->idLote);
        }
        //Asigno los paquetes que no se vayan a repartir al lote tipo 1
        if($paquete->direccion == null){
            $this->asignarPaqueteToLote($paqueteId, $lote->ID);
        }


    }

    /*************************************************************************************************************************************/

    public function prueba(){
        return response()->json([
            "message" => "prueba"
        ], 200);
    }
}
