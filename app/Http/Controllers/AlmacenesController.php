<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\AlmacenCliente;
use App\Models\AlmacenPropio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlmacenesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $propios = AlmacenPropio::all();
        $clientes = AlmacenCliente::all();
        return view('almacenes.index', ['propios' => $propios, 'clientes' => $clientes, 'almacen' => new Almacen()]);
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
     * @param  \App\Models\Almacen  $almacen
     * @return \Illuminate\Http\Response
     */
    public function show($almacen)
    {
        $almacen = Almacen::findOrFail($almacen);
        $tipo = (DB::table('almacenes_propios')->where('ID', $almacen->ID)->exists()) ? 'propio' : 'cliente';
        /*$camioneros = DB::table('conducen')
            ->join('camioneros', 'conducen.CI', 'camioneros.CI')
            ->where('conducen.matricula', $vehiculo->matricula)
            ->orderBy('desde', 'desc')
            ->get();
        $trae = Trae::where('trae.matricula', $vehiculo->matricula)->whereNull('fecha_descarga')->get();
        $lleva = Lleva::where('lleva.matricula', $vehiculo->matricula)->whereNull('fecha_descarga')->get();
        $reparte = Reparte::where('reparte.matricula', $vehiculo->matricula)->whereNull('fecha_descarga')->get();*/
        //dd(Almacen::findOrFail($almacen));
        return view('almacenes.show', [
            'almacen' => $almacen,
            'tipo' => $tipo/*,
            'camioneros' => $camioneros,
            'trae' => $trae,
            'lleva' => $lleva,
            'reparte' => $reparte*/
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Almacen  $almacen
     * @return \Illuminate\Http\Response
     */
    public function edit(Almacen $almacen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Almacen  $almacen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Almacen $almacen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Almacen  $almacen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Almacen $almacen)
    {
        //
    }
}
