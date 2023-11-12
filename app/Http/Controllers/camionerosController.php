<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveCamioneroRequest;
use App\Models\Camionero;
use App\Models\Conducen;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CamionerosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $camioneros = Camionero::all();
        return   view('camioneros.index', ['camioneros' => $camioneros,'camionero' => new Camionero()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveCamioneroRequest $request)
    {
        Camionero::create($request->validated());
        return to_route('camioneros.show', $request->input('CI'))->with('success', 'El camionero se creo correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Camionero  $camionero
     * @return \Illuminate\Http\Response
     */
    public function show(Camionero $camionero)
    {
        $vehiculos = Conducen::where('CI', $camionero->CI)->orderBy('desde', 'desc')->get();
        $vehiculosDisponibles = DB::select("SELECT DISTINCT VEHICULOS.matricula, IF (Exists (select 1 from CAMIONES where CAMIONES.matricula=VEHICULOS.matricula),'Camion','Camioneta') AS tipo FROM VEHICULOS INNER JOIN CONDUCEN ON VEHICULOS.matricula = CONDUCEN.matricula WHERE baja = 0 AND es_operativo = 1 AND VEHICULOS.matricula NOT IN (SELECT matricula FROM CONDUCEN WHERE hasta IS NULL)");
        return view('camioneros.show', ['camionero' => $camionero, 'vehiculos' => $vehiculos,'vehiculosDisponibles' => $vehiculosDisponibles]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Camionero  $camionero
     * @return \Illuminate\Http\Response
     */
    public function update(SaveCamioneroRequest $request, Camionero $camionero)
    {
        $camionero->update($request->validated());
        return to_route('camioneros.show', $camionero)->with('success', 'El camionero se actualizo correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Camionero  $camionero
     * @return \Illuminate\Http\Response
     */
    public function destroy(Camionero $camionero)
    {

        $conduce = Conducen::where('CI', $camionero->CI)->whereNull('hasta')->first();
        if($conduce!=null){
            Conducen::where('matricula', $conduce->matricula)
            ->where('ci', $conduce->CI)
            ->where('desde', $conduce->desde)
            ->update(['hasta' => Carbon::now()->toDateTimeString()]);
        }

        $camionero->update(['baja' => !$camionero->baja]);
        return redirect()->back()->with('success', 'El camionero se actualizo correctamente');
    }
}
