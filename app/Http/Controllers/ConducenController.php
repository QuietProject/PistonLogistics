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
        $camioneros = DB::select('SELECT DISTINCT camioneros.CI, camioneros.nombre, camioneros.apellido FROM camioneros INNER JOIN conducen ON camioneros.ci = conducen.ci WHERE baja = 0 AND camioneros.CI NOT IN ( SELECT CI FROM conducen WHERE hasta IS NULL );');
        if (count($camioneros)==0) {
            return redirect()->back()->with('error', 'No hay camioneros disponibles');
        }
        return view('conducen.vehiculo', ['vehiculo' => $vehiculo,'camioneros'=>$camioneros]);
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
        $camionero=Camionero::where('CI',$request->input('CI'))->where('baja',0)->firstOrFail();
        $vehiculo=Vehiculo::where('matricula',$request->input('matricula'))->where('baja',0)->where('es_operativo',1)->firstOrFail();

        Conducen::where('CI',$camionero->CI)->whereNull('hasta')->Orwhere('matricula',$camionero->matricula)->whereNull('hasta')->dd();
        
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Conducen  $conducen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Conducen $conducen)
    {
        //
    }
}
