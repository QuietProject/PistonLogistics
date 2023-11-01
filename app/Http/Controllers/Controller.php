<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

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
}
