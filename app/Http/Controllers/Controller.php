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
            DB::select("INSERT INTO PAQUETES_LOTES (ID_paquete, ID_lote) VALUES ($id, $loteId)");
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 500);
        }
    }


    public function getOrCreateLote($loteAlmacenOrigen, $paqueteAlmacenDestino)
    {
        
        $result = DB::select("SELECT destino.ID_almacen, destino.ID_troncal
            FROM (
            select ORDENES.* from ORDENES
            INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
            WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=?
            ) origen
            INNER JOIN (
            select ORDENES.* from ORDENES
            INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
            WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=?
            ) destino ON origen.ID_troncal = destino.ID_troncal
            LIMIT 1", [$loteAlmacenOrigen, $paqueteAlmacenDestino]);

        if (count($result) == 0) {
            $result = DB::select("SELECT o1.ID_almacen as almacen, o1.ID_troncal as troncal
                from (
                select * 
                from ORDENES
                where id_troncal in (
                select distinct ID_troncal from ORDENES
                INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
                WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=?)
                AND ID_almacen!=?
                ) o1
                JOIN (
                select * 
                from ORDENES
                where id_troncal in (
                select distinct ID_troncal from ORDENES
                INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
                WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=?)
                AND ID_almacen!=?) o2 ON o1.ID_almacen=o2.ID_almacen 
                LIMIT 1", [$loteAlmacenOrigen, $loteAlmacenOrigen, $paqueteAlmacenDestino,  $paqueteAlmacenDestino]);
            if (count($result) == 0) {
                DB::select("SELECT o1.ID_almacen, o1.ID_troncal
                    from (
                    select * 
                    from ORDENES
                    where id_troncal in (
                    select distinct ID_troncal from ORDENES
                    INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
                    WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=?) -- origen
                    AND ID_almacen!=?                                             -- origen
                    ) o1
                    JOIN (
                    select * 
                    from ORDENES
                    where id_troncal in (
                    select d.ID_troncal
                    from(
                    select distinct ID_troncal 
                    from ORDENES
                    INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
                    WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen in(
                    select ID_almacen 
                    from ORDENES
                    where id_troncal in (
                    select distinct ID_troncal from ORDENES
                    INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
                    WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=?) -- origen
                    AND ID_almacen!=?) -- origen
                    AND id_troncal not in(
                    select distinct ID_troncal from ORDENES
                    INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
                    WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=?) -- origen
                    )as d
                    INNER JOIN (
                    select distinct ID_troncal 
                    from ORDENES
                    INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
                    WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen in(
                    select ID_almacen 
                    from ORDENES
                    where id_troncal in (
                    select distinct ID_troncal from ORDENES
                    INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
                    WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=?)    -- destino
                    AND ID_almacen!=?)                                             -- destino
                    AND id_troncal not in(
                    select distinct ID_troncal from ORDENES
                    INNER JOIN TRONCALES ON ORDENES.ID_troncal = TRONCALES.ID
                    WHERE TRONCALES.baja=0 and ORDENES.baja=0 and ID_almacen=?) -- destino
                    )as o ON d.id_troncal = o.id_troncal)
                    ) o2 ON o1.ID_almacen=o2.ID_almacen
                    LIMIT 1", [$loteAlmacenOrigen, $loteAlmacenOrigen, $loteAlmacenOrigen, $loteAlmacenOrigen, $loteAlmacenOrigen, $paqueteAlmacenDestino, $paqueteAlmacenDestino, $paqueteAlmacenDestino]);
            }
        }

        $troncal = $result[0]->ID_troncal;
        $almacenDestino = $result[0]->ID_almacen;


        // // busco si hay algun lote en la tabla destino_lote que tenga el mismo almacen destino que el paquete y la misma troncal
        $idLote = DB::select("SELECT LOTES.ID from LOTES join DESTINO_LOTE on DESTINO_LOTE.ID_lote = LOTES.ID where DESTINO_LOTE.ID_almacen = $almacenDestino and DESTINO_LOTE.ID_troncal = $troncal and LOTES.ID_almacen = $loteAlmacenOrigen and LOTES.fecha_pronto is null");

        // Si encuentra un lote con el mismo almacen destino que el paquete y la misma troncal, lo agarro
        if ($idLote != null) {
            $lote = Lote::find($idLote[0]->ID);

            // Si no hay ningun lote con el mismo almacen destino que el paquete o el lote es de tipo 1 (no se reparte) creo un nuevo lote
        } else {
            $codigo = Lote::getCodigo();
            DB::select("CALL lote_0(?, ?, ?, ?, @id_lote, @error)", [$codigo, $loteAlmacenOrigen, $paqueteAlmacenDestino, $troncal]);
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

    public function paqueteToPickup($paqueteId, $destinoPaquete)
    {
        $paquete = Paquete::find($paqueteId);
        //Busco si existe un lote tipo 1 en el almacen destino del paquete
        $lote = Lote::where("ID_almacen", $destinoPaquete)->whereNull("fecha_cerrado")->where("tipo", 1)->first();
        //Si no existe, lo creo
        if ($lote == null) {
            DB::select("CALL lote_1(?, @idLote, @error)", [$destinoPaquete]);
            $error = DB::select("SELECT @error as error")[0]->error;
            if ($error != null) {
                return response()->json([
                    "message" => $error
                ], 400);
            }
            $lote = Lote::find(DB::select("SELECT @idLote as idLote")[0]->idLote);
        }
        //Asigno los paquetes que no se vayan a repartir al lote tipo 1
        if ($paquete->direccion == null) {
            $this->asignarPaqueteToLote($paqueteId, $lote->ID);
        }

        return $lote;
    }
}
