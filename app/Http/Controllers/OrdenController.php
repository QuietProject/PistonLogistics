<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use App\Http\Controllers\Controller;
use App\Models\Almacen;
use App\Models\AlmacenPropio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdenController extends Controller
{


    /**
     * Devuelve las troncales en las que estan los almacenes pasados como parametro
     *Recive a los almacenes entre comas ej 2,3,5
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function almacen($almacen)
    {
        $almacen = AlmacenPropio::find($almacen);
        if (empty($almacen)) {
            return response()->json([
                "message" => "Almacen no existe"
            ], 400);
        }

        $troncales = DB::table('ORDENES')
        ->join('TRONCALES','TRONCALES.ID','ORDENES.ID_troncal')
        ->where('TRONCALES.baja',0)
        ->where('ORDENES.baja',0)
        ->where('ID_almacen',$almacen->ID)
        ->get(['TRONCALES.ID AS ID']);

        if (count($troncales)==0) {
            return response()->json([
                "message" => "El almacen no se encuentra en ninguna troncal"
            ], 400);
        }

        foreach ($troncales as $index => $troncal) {
            $idsTroncales[$index]=$troncal->ID;
        }
        $ordenes= DB::table('ORDENES')
        ->join('TRONCALES','TRONCALES.ID','ORDENES.ID_troncal')
        ->join('ALMACENES','ALMACENES.ID','ORDENES.ID_almacen')
        ->where('TRONCALES.baja',0)
        ->where('ORDENES.baja',0)
        ->where('ALMACENES.baja',0)
        ->whereIn('ORDENES.ID_troncal',$idsTroncales)
        ->where('ORDENES.ID_almacen','!=',$almacen->ID)
        ->get(['ORDENES.ID_almacen as ID_almacen','ORDENES.ID_troncal as ID_troncal','TRONCALES.nombre as nombre_troncal','ALMACENES.nombre as nombre_almacen']);

        return response()->json($ordenes, 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function troncal(Request $request)
    {
        //
    }
}
