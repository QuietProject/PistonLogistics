<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lote;
use App\Http\Resources\LoteResource;
use App\Models\AlmacenPropio;
use App\Models\PaqueteLote;
use Illuminate\Support\Facades\DB;


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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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

    public function quitarPaquete(){
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
}
