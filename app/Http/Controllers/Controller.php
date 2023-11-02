<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function validacion($validator){
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

    public function prueba(){
        return response()->json([
            "message" => "prueba"
        ], 200);
    }
}
