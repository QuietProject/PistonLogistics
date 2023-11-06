<?php

namespace App\Http\Controllers;

use App\Models\Camionero;
use App\Models\Conducen;
use App\Models\Vehiculo;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConducenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Conducen  $conducen
     * @return \Illuminate\Http\Response
     */
    public function hasta($matricula, $ci)
    {
        $conducen = Conducen::where('matricula', $matricula)->where('ci', $ci)->whereNull('hasta')->firstOrFail();
        Conducen::where('matricula', $matricula)
            ->where('ci', $ci)
            ->where('desde', $conducen->desde)
            ->update(['hasta' => Carbon::now()->toDateTimeString()]);
        return redirect()->back()->with('success', 'Se desasigno el conductor del vehiculo correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Conducen  $conducen
     * @return \Illuminate\Http\Response
     */
    public function vehiculo(Vehiculo $vehiculo)
    {
        if ($vehiculo->baja || !$vehiculo->es_operativo) {
            return redirect()->back()->with('error', 'El vehiculo no esta operativo');
        }
        $camioneros = DB::select('SELECT DISTINCT CAMIONEROS.CI, CAMIONEROS.nombre FROM CAMIONEROS INNER JOIN CONDUCEN ON CAMIONEROS.ci = CONDUCEN.ci WHERE baja = 0 AND CAMIONEROS.CI NOT IN ( SELECT CI FROM CONDUCEN WHERE hasta IS NULL );');
        if (count($camioneros) == 0) {
            return redirect()->back()->with('error', 'No hay camioneros disponibles');
        }
        return view('conducen.vehiculo', ['vehiculo' => $vehiculo, 'camioneros' => $camioneros]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Conducen  $conducen
     * @return \Illuminate\Http\Response
     */
    public function  camionero(Camionero $camionero)
    {
        if ($camionero->baja) {
            return redirect()->back()->with('error', 'El camionero no esta dado de baja');
        }
        $vehiculos = DB::select("SELECT DISTINCT VEHICULOS.matricula, IF (Exists (select 1 from CAMIONES where CAMIONES.matricula=VEHICULOS.matricula),'Camion','Camioneta') AS tipo FROM VEHICULOS INNER JOIN CONDUCEN ON VEHICULOS.matricula = CONDUCEN.matricula WHERE baja = 0 AND es_operativo = 1 AND VEHICULOS.matricula NOT IN (SELECT matricula FROM CONDUCEN WHERE hasta IS NULL);");
        if (count($vehiculos) == 0) {
            return redirect()->back()->with('error', 'No hay vehiculo disponibles');
        }
        return view('conducen.camionero', ['vehiculos' => $vehiculos, 'camionero' => $camionero]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Conducen  $conducen
     * @return \Illuminate\Http\Response
     */
    public function desde(Request $request)
    {
        $camionero = Camionero::where('CI', $request->input('CI'))->where('baja', 0)->firstOrFail();
        $vehiculo = Vehiculo::where('matricula', $request->input('matricula'))->where('baja', 0)->where('es_operativo', 1)->firstOrFail();

        $a = Conducen::where('CI', $camionero->CI)->whereNull('hasta')->Orwhere('matricula', $vehiculo->matricula)->whereNull('hasta')->get();
        
        $ruta = app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName();

        if (count($a) > 0) {
            return redirect()->back()->with('error', 'Error');
        }

        Conducen::create(['CI' => $camionero->CI, 'matricula' => $vehiculo->matricula]);

        if ($ruta == 'conducen.vehiculo') {
            return to_route('vehiculos.show', ['vehiculo' => $vehiculo->matricula])->with('success', 'Se le a asignado un camionero al vehiculo correctamente');
        } else {
            return to_route('camioneros.show', ['camionero' => $camionero->CI])->with('success', 'Se le a asignado un vehiculo al camionero correctamente');
        }
    }

}
