<?php

namespace App\Http\Controllers;

use App\Models\Paquete;
use App\Models\Trae;
use App\Models\Vehiculo;
use App\Models\Lote;
use App\Models\Orden;
use App\Models\PaqueteLote;
use App\Models\DestinoLote;
use Illuminate\Http\Request;
use App\Http\Resources\PaqueteResource;
use App\Models\Lleva;

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

    public function paquetesLote($id)
    {
        // foreach (Lleva::all() as $lleva) {
        //     $lotesLleva[] = $lleva->ID_lote;
        // }

        // $lotes = Lote::where("tipo", 0)
        // ->whereNull("fecha_cerrado")
        // ->whereNull("fecha_pronto")
        // ->where("ID_almacen", 5)
        // ->get();


        // foreach($lotes as $lote){
        //     $lotesArray[] = $lote->ID;
        // }


        // $lotesfinal = array_diff($lotesArray, $lotesLleva);

        // foreach($lotesfinal as $lote){
        //     $paquetesLote = PaqueteLote::where("ID_lote", $lote)->get();
        //     foreach ($paquetesLote as $paquete) {
        //         $paquete->paquete;
        //     }
        //     $paquetesLoteArray[] = $paquetesLote;
        // }
        // $paqueteLote = PaqueteLote::where("ID_lote", 5)->get();
        // foreach ($paqueteLote as $paquete) {
        //     $paquete->paquete;
        // }


        // $arrayPaquetes = PaqueteLote::where("ID_lote", $id)->get();
        // foreach ($arrayPaquetes as $paquete) {
        //     dd($paquete->paquete());
        //     $arrayPaquetesFiltrados[] = $paquete->paquete();
        // }
        // dd($arrayPaquetesFiltrados);
        $latestDateSubquery = PaqueteLote::where('ID_lote', $id)
            ->selectRaw('MAX(fecha)');

        dd($latestDateSubquery);

        $latestPaquete = PaqueteLote::where('ID_lote', $id)
            ->where('fecha', '=', $latestDateSubquery)
            ->with('paquete')
            ->get();

        return PaqueteResource::collection($latestPaquete);
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
            "numero" => "required|numeric",
            "ciudad" => "required",
            "peso" => "required",
            "volumen" => "required",
            "mail" => "required|email",
            "cedula" => "required|numeric|length:8",
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

    public function cargaCliente($id, $matricula)
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



    public function descarga($id)
    {

        $paquete = Paquete::find($id);
        if ($paquete === null) {
            return response()->json([
                "message" => "Paquete no encontrado"
            ], 404);
        }


        Trae::where(["ID_paquete" => $id])->update([
            "fecha_descarga" => now(),
        ]);

        $almacen = explode(".", session()->get("user"))[0];
        $paquete = Paquete::find($id);
        // busco si hay algun lote en la tabla destino_lote que tenga el mismo almacen destino que el paquete
        $destinoLote = DestinoLote::where("ID_almacen", $paquete->ID_pickup)->first();
        // Busco una troncal que tenga el mismo almacen que el paquete y agarro su ID
        $troncal = Orden::where("ID_almacen", $almacen)->first()->troncal->ID;
        // Si no hay ningun lote con el mismo almacen destino que el paquete o el lote es de tipo 1 (no se reparte) creo un nuevo lote
        if ($destinoLote === null || $destinoLote->lote->tipo == 1) {

            $lote = Lote::create([
                "ID_troncal" => $troncal,
                "ID_almacen" => $almacen,
                "tipo" => 0,
            ]);
        } else {
            // Si hay un lote con el mismo almacen destino que el paquete, lo agarro
            $lote = $destinoLote->lote;
        }

        PaqueteLote::create([
            "ID_paquete" => $id,
            "ID_lote" => $lote->ID,
            "fecha" => now(),
        ]);


        return response()->json([
            "message" => "Paquete descargado y lote asignado"
        ], 200);
    }

    public function cargaAlmacen($id, $matricula)
    {
        if (!is_numeric($id)) {
            return response()->json([
                "message" => "ID debe ser numérico"
            ], 400);
        }

        $lote = Lote::find($id);
        if ($lote === null) {
            return response()->json([
                "message" => "Lote no encontrado"
            ], 404);
        }

        // Find a vehiculo by its matricula (license plate)
        $vehiculo = Vehiculo::where('matricula', $matricula)->first();

        if ($vehiculo === null) {
            return response()->json([
                "message" => "Vehiculo no encontrado"
            ], 404);
        }

        Lleva::create([
            "ID_lote" => $id,
            "matricula" => $matricula,
        ]);

        return response()->json([
            "message" => "Lote cargado"
        ], 200);
    }
}
