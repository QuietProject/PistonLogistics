<?php

namespace App\Http\Controllers;

use App\Models\Paquete;
use App\Models\Trae;
use App\Models\Vehiculo;
use App\Models\Lote;
use App\Models\DestinoLote;
use Illuminate\Http\Request;
use App\Http\Resources\PaqueteResource;


class PaqueteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Paquete::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = request()->validate([
            "ID_almacen" => "required",
            "ID_pickup" => "required",
            "calle" => "required",
            "numero" => "required",
            "ciudad" => "required",
            "peso" => "required",
            "volumen" => "required",
            "mail" => "required",
            "cedula" => "required",
        ]);

        $paquete = Paquete::create($validated);
        return new PaqueteResource($paquete);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Paquete  $paquete
     * @return \Illuminate\Http\Response
     */
    public function show(Paquete $paquete)
    {
        return new PaqueteResource($paquete);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Paquete  $paquete
     * @return \Illuminate\Http\Response
     */
    public function edit(Paquete $paquete)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Paquete  $paquete
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paquete $paquete)
    {
        //
    }

    public function carga($id, $matricula)
    {
        if (!is_numeric($id)) {
            return response()->json([
                "message" => "ID debe ser numérico"
            ], 400);
        }

        $paquete = Paquete::find($id);
        if ($paquete === null) {
            return response()->json([
                "message" => "Paquete no encontrado"
            ], 404);
        }

        // Find a vehiculo by its matricula (license plate)
        $vehiculo = Vehiculo::where('matricula', $matricula)->first();

        if ($vehiculo === null) {
            return response()->json([
                "message" => "Vehiculo no encontrado"
            ], 404);
        }

        Trae::create([
            "ID_paquete" => $id,
            "matricula" => $matricula,
        ]);

        return response()->json([
            "message" => "Paquete cargado"
        ], 200);
    }



    public function descargaAlmacen($id){

        $paquete = Paquete::find($id);
        if ($paquete === null) {
            return response()->json([
                "message" => "Paquete no encontrado"
            ], 404);
        }


        //  Trae::where(["ID_paquete" => $id, "matricula" => $matricula,])->update([
        //      "fecha_descarga" => now(),]);

        $paquete = Paquete::find($id);
        $destinoLote = DestinoLote::where("ID_almacen", $paquete->ID_pickup)->first();
        if($destinoLote === null || $destinoLote->lote->tipo == 1){
            Lote::create([
                "ID_troncal" => 1,
                "ID_almacen" => $paquete->ID_pickup,
                "tipo" => 0,
            ]);
        }
        return $destinoLote->lote;

        return response()->json([
            "message" => "Paquete descargado"
        ], 200);
    }
}
