<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveVehiculoRequest;
use App\Models\Camion;
use App\Models\Camioneta;
use App\Models\Conducen;
use App\Models\Lleva;
use App\Models\Reparte;
use App\Models\Trae;
use App\Models\Vehiculo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VehiculosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $camionetas = DB::table('vehiculos')
            ->join('camionetas', 'vehiculos.matricula', 'camionetas.matricula')->get();

        $camiones = DB::table('vehiculos')
            ->join('camiones', 'vehiculos.matricula', 'camiones.matricula')->get();

        return view('vehiculos.index', ['camionetas' => $camionetas, 'camiones' => $camiones, 'vehiculo' => new Vehiculo()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveVehiculoRequest $request)
    {
        $vehiculo = $request->validated();
        unset($vehiculo['tipo']);
        $matricula = $request->validated()['matricula'];

        Vehiculo::create($vehiculo);
        if ($request->validated()['tipo'] == 'camion') {
            Camion::create(['matricula' => $matricula]);
        } else {
            Camioneta::create(['matricula' => $matricula]);
        }

        return to_route('vehiculos.show', $request->input('matricula'))->with('success', 'El vehiculo se agrego correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vehiculo  $vehiculo
     * @return \Illuminate\Http\Response
     */
    public function show(Vehiculo $vehiculo)
    {
        $tipo = (DB::table('camiones')->where('matricula', $vehiculo->matricula)->exists()) ? 'Camion' : 'Camioneta';
        $camioneros = DB::table('conducen')
            ->join('camioneros', 'conducen.CI', 'camioneros.CI')
            ->where('conducen.matricula', $vehiculo->matricula)
            ->orderBy('desde', 'desc')
            ->get();
        $trae = Trae::where('trae.matricula', $vehiculo->matricula)->whereNull('fecha_descarga')->get();
        $lleva = Lleva::where('lleva.matricula', $vehiculo->matricula)->whereNull('fecha_descarga')->get();
        $reparte = Reparte::where('reparte.matricula', $vehiculo->matricula)->whereNull('fecha_descarga')->get();
        return view('vehiculos.show', [
            'vehiculo' => $vehiculo,
            'tipo' => $tipo,
            'camioneros' => $camioneros,
            'trae' => $trae,
            'lleva' => $lleva,
            'reparte' => $reparte
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vehiculo  $vehiculo
     * @return \Illuminate\Http\Response
     */
    public function update(SaveVehiculoRequest $request, Vehiculo $vehiculo)
    {
        $vehiculo->update($request->validated());
        return to_route('vehiculos.show', $vehiculo)->with('success', 'El vehiculo se actualizo correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vehiculo  $vehiculo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehiculo $vehiculo)
    {
        try {
            $vehiculo->delete();
        } catch (\PDOException $e) {
            return redirect()->back()->with('error', 'No se puede elminiar el vehiculo Error SQL:' . $e->errorInfo[1]);
        }
        return to_route('vehiculos.index')->with('success', 'El vehiculo se elimino correctamente');
    }

    public function baja(Vehiculo $vehiculo)
    {
        $vehiculo->baja = !$vehiculo->baja;
        $vehiculo->save();
        $baja = $vehiculo->baja ? 'baja' : 'alta';

        $conduce = Conducen::where('matricula', $vehiculo->matricula)->whereNull('hasta')->first();
        if($conduce!=null){
            Conducen::where('matricula', $conduce->matricula)
            ->where('ci', $conduce->CI)
            ->where('desde', $conduce->desde)
            ->update(['hasta' => Carbon::now()->toDateTimeString()]);
        }

        return redirect()->back()->with('success', "El vehiculo se dio de $baja correctamente");
    }

    public function operativo(Vehiculo $vehiculo)
    {
        $vehiculo->es_operativo = !$vehiculo->es_operativo;
        $vehiculo->save();
        $operaivo = $vehiculo->es_operativo ? 'operativo' : 'fuera de servicio';
        return redirect()->back()->with('success', "El vehiculo se cambio a $operaivo correctamente");
    }
}
