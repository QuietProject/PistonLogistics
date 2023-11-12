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
        $camionetas = DB::table('VEHICULOS')
            ->join('CAMIONETAS', 'VEHICULOS.matricula', 'CAMIONETAS.matricula')->get();

        $camiones = DB::table('VEHICULOS')
            ->join('CAMIONES', 'VEHICULOS.matricula', 'CAMIONES.matricula')->get();

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
        DB::select('CALL ' . $request->validated()['tipo'] . '(?,?,@fallo)', [$vehiculo['matricula'], $vehiculo['peso_max']]);
        if (DB::select('SELECT @FALLO AS fallo')[0]->fallo != 0) {
            return redirect()->back()->with('error','Ha ocurrido un error');
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
        $tipo = (DB::table('CAMIONES')->where('matricula', $vehiculo->matricula)->exists()) ? 'Camion' : 'Camioneta';
        $camioneros = DB::table('CONDUCEN')
            ->join('CAMIONEROS', 'CONDUCEN.CI', 'CAMIONEROS.CI')
            ->where('CONDUCEN.matricula', $vehiculo->matricula)
            ->orderBy('desde', 'desc')
            ->get();
        $trae = Trae::where('TRAE.matricula', $vehiculo->matricula)->whereNull('fecha_descarga')->join('PAQUETES','PAQUETES.ID','TRAE.ID_paquete')->get();
        $lleva = Lleva::where('LLEVA.matricula', $vehiculo->matricula)->whereNull('fecha_descarga')->join('LOTES','LOTES.ID','LLEVA.ID_lote')->get();
        $reparte = Reparte::where('REPARTE.matricula', $vehiculo->matricula)->whereNull('fecha_descarga')->join('PAQUETES','PAQUETES.ID','REPARTE.ID_paquete')->get();

        $camionerosDisponibles = DB::select('SELECT DISTINCT CAMIONEROS.CI, CAMIONEROS.nombre FROM CAMIONEROS INNER JOIN CONDUCEN ON CAMIONEROS.ci = CONDUCEN.ci WHERE baja = 0 AND CAMIONEROS.CI NOT IN ( SELECT CI FROM CONDUCEN WHERE hasta IS NULL );');

        return view('vehiculos.show', [
            'vehiculo' => $vehiculo,
            'tipo' => $tipo,
            'camioneros' => $camioneros,
            'trae' => $trae,
            'lleva' => $lleva,
            'camionerosDisponibles' => $camionerosDisponibles,
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
    // public function destroy(Vehiculo $vehiculo)
    // {
    //     try {
    //         $vehiculo->delete();
    //     } catch (\PDOException $e) {
    //         return redirect()->back()->with('error', 'No se puede elminiar el vehiculo Error SQL:' . $e->errorInfo[1]);
    //     }
    //     return to_route('vehiculos.index')->with('success', 'El vehiculo se elimino correctamente');
    // }

    public function baja(Vehiculo $vehiculo)
    {
        $vehiculo->baja = !$vehiculo->baja;
        $vehiculo->save();
        $baja = $vehiculo->baja ? 'baja' : 'alta';

        $conduce = Conducen::where('matricula', $vehiculo->matricula)->whereNull('hasta')->first();
        if ($conduce != null) {
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
