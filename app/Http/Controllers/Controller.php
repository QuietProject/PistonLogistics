<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Lote;
use App\Models\Paquete;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function validacion($validator)
    {
        if ($validator->fails()) {
            $response = [
                'message' => 'Error en la validación',
                'errors' => $validator->errors()
            ];

            return response()->json($response, 422); // Puedes ajustar el código de respuesta (HTTP status code) según tus necesidades
        }
    }

    // Método para asignar un paquete a un lote
    public function asignarPaqueteToLote($id, $loteId)
    {
        try {
            DB::select("INSERT INTO paquetes_lotes (ID_paquete, ID_lote) VALUES ($id, $loteId)");
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 500);
        }
    }


    // Método para obtener o crear un lote
    public function getOrCreateLote($loteAlmacenOrigen, $paqueteAlmacenDestino)
    {
        // $validated = request()->validate([
        //     "loteAlmacenOrigen" => "required|numeric",
        //     "paqueteAlmacenDestino" => "required|numeric",
        // ]);

        // $loteAlmacenOrigen = $validated["loteAlmacenOrigen"];
        // $paqueteAlmacenDestino = $validated["paqueteAlmacenDestino"];

        // // tomo todas las troncales que contengan el almacen de origen y de destino del paquete
        $troncales = Orden::whereIn("ID_almacen", [$loteAlmacenOrigen, $paqueteAlmacenDestino])->pluck("ID_troncal");
        $troncales = array_values(array_unique(array_diff_assoc($troncales->toArray(), array_unique($troncales->toArray()))));

        // // busco si hay algun lote en la tabla destino_lote que tenga el mismo almacen destino que el paquete y la misma troncal
        // $destinoLote = DestinoLote::where("ID_almacen", $paquetePickup)->where("ID_troncal", $troncales)->first();
        $idLote = DB::select("SELECT lotes.ID from lotes join destino_lote on destino_lote.ID_lote = lotes.ID where destino_lote.ID_almacen = $paqueteAlmacenDestino and destino_lote.ID_troncal = $troncales[0] and lotes.ID_almacen = $loteAlmacenOrigen and lotes.fecha_pronto is null");

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

    public function paqueteToPickup($paqueteId, $destinoPaquete){
        $paquete = Paquete::find($paqueteId);
        //Busco si existe un lote tipo 1 en el almacen destino del paquete
        $lote = Lote::where("ID_almacen", $destinoPaquete)->whereNull("fecha_cerrado")->where("tipo", 1)->first();
        //Si no existe, lo creo
        if ($lote == null) {
            DB::select("CALL lote_1($destinoPaquete, @idLote, @error)");
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

        return $lote;
    }
}
