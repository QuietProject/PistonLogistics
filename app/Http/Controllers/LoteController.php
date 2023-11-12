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
use App\Http\Controllers\PaqueteController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;


class LoteController extends Controller
{
    public function index()
    {
        $validator = Validator([
            "idAlmacen" => "bail|required|numeric|exists:almacenes_propios,ID",
        ]);
        if ($this->validacion($validator)) {
            return $this->validacion($validator);
        }

        $idAlmacen = request()->idAlmacen;

        if ($idAlmacen == null) {
            return Lote::all();
        }

        $lotes = DB::table("LOTES_EN_ALMACENES")->where("LOTES_EN_ALMACENES.ID_almacen", $idAlmacen)
        ->join("LOTES", "LOTES.ID", "LOTES_EN_ALMACENES.ID_lote")
        ->get();
        if ($lotes->isEmpty()) {
            return response([]);
        }

        // foreach ($result as $object) {
        //     $lotes[] = Lote::find($object->ID_lote);
        // }

        return $lotes;
    }

    public function store(Request $request)
    {
        $validated = request()->validate([
            "almacenOrigen" => "required|numeric|exists:almacenes_propios,ID",
            "ID_troncal" => "numeric|exists:troncales,ID",
            "ID_almacen_destino" => "numeric|exists:almacenes_propios,ID",
            "tipo" => "required|numeric|in:0,1",
        ]);

        $almacenOrigen = $validated["almacenOrigen"];

        if (AlmacenPropio::find($almacenOrigen) == null) {
            return response()->json([
                "message" => "Almacen origen no existe"
            ], 400);
        }
        if ($validated["tipo"] == 0) {
            $idAlmacenDestino = $validated["ID_almacen_destino"];
            $idTroncal = $validated["ID_troncal"];
        }

        do {
            $codigo = "L" . Str::random(7);
        } while (Lote::where('codigo', $codigo)->exists());


        if ($validated["tipo"] == 0) {
            DB::select("CALL lote_0(?, ?, ?, ?, @idLote, @error)", [$codigo, $almacenOrigen, $idAlmacenDestino, $idTroncal]);
            $error = DB::select("SELECT @error as error")[0]->error;
        } else {
            DB::select("CALL lote_1(?, ?, @idLote, @error)", [$codigo, $almacenOrigen]);
            $error = DB::select("SELECT @error as error")[0]->error;
        }

        if ($error != null) {
            return response()->json([
                "message" => $error
            ], 400);
        }

        $idLote = DB::select("SELECT @idLote as idLote")[0]->idLote;
        $lote = Lote::find($idLote);

        return response()->json([
            "message" => "Lote creado exitosamente",
            "lote" => new LoteResource($lote),
        ], 200);
    }

    /**************************************************************************************************************************/

    public function show($codigo)
    {
        $lote = Lote::where("codigo", $codigo)->first();
        if ($lote === null) {
            return response()->json([
                "message" => "Paquete no encontrado"
            ], 404);
        }
        return new LoteResource($lote);
    }

    /**************************************************************************************************************************/

    public function paquetesEnLote($idsLote)
    {
        $idsLote = array_map("intval", explode(",", $idsLote));
        // return $idsLote;
        $lotes = Lote::whereIn("ID", $idsLote)->get();
        if ($lotes == null) {
            return response()->json([
                "message" => "Lote no existe"
            ], 400);
        }

        $paquetesEnLotes = PaqueteLote::whereIn("ID_lote", $idsLote)->whereNull("hasta")->get();

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
                    $lotExists = DB::table('LOTES')->where('ID', $value)->exists();
                    $lotIsReady = DB::table('LOTES')->where('ID', $value)->whereNull('fecha_pronto')->exists();

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

        if (PaqueteLote::where("ID_lote", $request->idLote)->whereNull("hasta")->doesntExist()) {
            return response()->json([
                "message" => "El lote no tiene paquetes"
            ], 400);
        }

        $idLote = $request->idLote;

        $paquetesEnLote = Lote::find($idLote)->paquetes()->get();

        foreach ($paquetesEnLote as $paquete) {
            if ($paquete->peso == 0) {
                return response()->json([
                    "message" => "El lote contiene paquetes sin pesar"
                ], 400);
            }
        }

        $lote = lote::find($idLote);
        $lote->fecha_pronto = now();
        $lote->save();
        return response()->json([
            "message" => "Lote listo para enviar"
        ], 200);
    }

    /*************************************************************************************************************************************/

    public function cargaLote(Request $request)
{
    $idLoteArray = explode(',', $request->idLote);

    foreach ($idLoteArray as $singleIdLote) {
        $validator = Validator::make([
            "idLote" => $singleIdLote,
            "matricula" => $request->matricula,
        ], [
            "idLote" => [
                "bail",
                "required",
                "numeric",
                function ($attribute, $value, $fail) {
                    $loteExiste = DB::table('LOTES')->where('ID', $value)->exists();
                    $lotePronto = DB::table('LOTES')->where('ID', $value)->whereNull('fecha_pronto')->exists();
                    $loteAsignado = DB::table('LLEVA')->where('ID_lote', $value)->whereNotNull("fecha_asignado")->exists();
                    $loteCargado = DB::table('LLEVA')->where('ID_lote', $value)->whereNotNull("fecha_cargado")->exists();

                    if (!$loteExiste) {
                        $fail("El lote con ID $value no existe");
                    } elseif ($lotePronto) {
                        $fail("El lote con ID $value no está pronto");
                    } elseif (!$loteAsignado) {
                        $fail("El lote con ID $value no está asignado a ningún camión");
                    } elseif ($loteCargado) {
                        $fail("El lote con ID $value ya está cargado");
                    }
                },
            ],
            "matricula" => ["bail", "required", "string", "size:7", "exists:camiones,matricula"],
        ]);

        if ($this->validacion($validator)) {
            return $this->validacion($validator);
        }

        DB::select("INSERT into LLEVA (ID_lote, matricula) values ($singleIdLote, '$request->matricula')");
    }

    return response()->json([
        "message" => "Lote(s) cargado(s) exitosamente"
    ], 200);
}



    /*************************************************************************************************************************************/

    public function descargaLote(Request $request)
{
    $idLoteArray = explode(',', $request->idLote);

    foreach ($idLoteArray as $singleIdLote) {
        $validator = Validator::make([
            "idLote" => $singleIdLote,
        ], [
            "idLote" => ["bail", "required", "numeric", "exists:lotes,ID", function ($attribute, $value, $fail) {
                $loteCargado = DB::table('LLEVA')->where('ID', $value)->whereNull("fecha_carga")->exists();
                $loteDescargado = DB::table('LLEVA')->where('ID', $value)->whereNotNull("fecha_descarga")->exists();
                

                if ($loteCargado) {
                    $fail("El lote con ID $value no está cargado");
                } elseif ($loteDescargado) {
                    $fail("El lote con ID $value ya fue descargado");
                } 
            },],
        ]);

        if ($this->validacion($validator)) {
            return $this->validacion($validator);
        }

        //descarga el lote de lleva
        $idLote = $singleIdLote;
        $lleva = Lleva::where("ID_lote", $idLote)->first();
        $lleva->fecha_descarga = now();
        $lleva->save();

        //Cierra el lote y deja todos sus paquetes en la tabla paquetes_almacenes
        $lote = Lote::find($idLote);
        //tomo las ids de los paquetes del lote
        $paquetesIds = $lote->paquetes()->pluck("ID");
        //tomo el almacen destino del lote
        $destinoLote = $lote->destino_lote()->pluck("ID_almacen")->first();
        $lote->fecha_cerrado = now();
        $lote->save();

        $paquetesEnDestinoFinal = [];
        $paquetesEnPickUp = [];

        //recorro los paquetes y los que no estén en su destino final se agregan a un nuevo lote para ser enviados de nuevo
        foreach ($paquetesIds as $paqueteId) {
            $paquete = Paquete::find($paqueteId);
            // De los paquetes que ya están en su destino final asigno los que no se reparten a un lote de tipo 1
            if ($paquete->ID_pickup == $destinoLote) {
                if ($paquete->direccion == null) {
                    $this->paqueteToPickup($paqueteId, $destinoLote);
                    $paquetesEnPickUp[] = $paquete;
                }
                $paquetesEnDestinoFinal[] = $paquete;
                // Los que no estén en su destino final se agregan a un nuevo lote para ser enviados de nuevo
            } else {
                $lote = $this->getOrCreateLote($destinoLote, $paquete->ID_pickup);
                $this->asignarPaqueteToLote($paqueteId, $lote->ID);
            }
        }

        // $paquetesProntosParaRepartir = array_diff($paquetesEnDestinoFinal, $paquetesEnPickUp);

        // $paquetesARepartirNuevamente = Paquete::whereIn("ID", $paquetesIds)->where("ID_pickup", "!=", $destinoLote)->get();

        // return response()->json([
        //     "message" => "Lote descargado y paquetes asignados",
        //     "paquetesEnDestinoFinal" => [
        //         "paquetesProntosParaRepartir" => $paquetesProntosParaRepartir,
        //         "paquetesEnPickUp" => $paquetesEnPickUp,
        //     ],
        //     "paquetesARepartirNuevamente" => [
        //         "paquetes" => $paquetesARepartirNuevamente,
        //         "lote" => $lote,
        //     ],
        // ], 200);
    }

    return response()->json([
        "message" => "Lote(s) descargado(s) y paquete(s) asignado(s) exitosamente",
    ], 200);
}


    /*************************************************************************************************************************************/

    public function agregarPaqueteToLote()
    {
        $validated = request()->validate([
            "idPaquete" => "required|numeric|exists:paquetes,ID",
            "idLote" => "required|numeric|exists:lotes,ID",
        ]);

        $paquetesEnLotes = PaqueteLote::where("ID_paquete", $validated["idPaquete"])->whereNull("hasta")->get();
        // return $paquetesEnLotes;
        if (!empty(json_decode($paquetesEnLotes, true))) {
            return response()->json([
                "message" => "Paquete ya en un lote"
            ], 400);
        }

        $error = $this->asignarPaqueteToLote($validated["idPaquete"], $validated["idLote"]);
        if (!empty($error)) {
            return response()->json([
                "message" => $error
            ], 400);
        }

        return response()->json([
            "message" => "Paquete agregado a lote"
        ], 200);
    }

    /*************************************************************************************************************************************/
}
