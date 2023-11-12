<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paquete;
use App\Models\Reparte;

class PaqueteController extends Controller
{
    public function entregarPaquete($id)
    {
        $paquete = Paquete::find($id);

        if (!$paquete) {
            return response()->json(["message" => "Paquete no encontrado"], 404);
        }

        if (!Reparte::where("ID_paquete", $id)->exists()) {
            return response()->json(["message" => "Paquete no cargado"], 400);
        }

        if ($paquete->)

        $paquete->estado = "Entregado";
        $paquete->save();
        return response()->json(["message" => "Paquete entregado"]);
    }
}
