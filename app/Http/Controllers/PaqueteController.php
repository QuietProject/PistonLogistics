<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paquete;
use App\Models\Reparte;
use Illuminate\Support\Facades\DB;

class PaqueteController extends Controller
{
    /*public function entregarPaquete($id)
    {
        $paquete = Paquete::where($id);

        if (!$paquete) {
            return response()->json(["message" => "Paquete no encontrado"], 404);
        }

        if (!Reparte::where("ID_paquete", $id)->exists()) {
            return response()->json(["message" => "Paquete no cargado"], 400);
        }

        if/* ($paquete->)

        $paquete->estado = "Entregado";
        $paquete->save();
        return response()->json(["message" => "Paquete entregado"]);
    }*/

    public function entregarPaquete($codigo){
        $paquete = Paquete::where('codigo',$codigo)->first();

        if ($paquete === null) {
            return response()->json([
                "message" => "Paquete no encontrado"
            ], 404);
        }

        if ($paquete->estado != 8) {
            return response()->json([
                "message" => "Paquete no entregable"
            ], 400);
        }

        DB::select("CALL entregar_paquete(?, @error)", [$paquete->ID]);
        $error = DB::select("SELECT @error as error")[0]->error;
        if ($error !== 0) {
            return response()->json([
                "message" => "Error al entregar paquete"
            ], 400);
        }

        return response()->json([
            "message" => "Paquete entregado exitosamente",
            "paquete" => $paquete
        ], 200);
    }
}
