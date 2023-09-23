<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveVehiculoRequest;
use App\Models\Vehiculo;
use Illuminate\Http\Request;
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
            ->join('camionetas', 'vehiculos.matricula', '=', 'camionetas.matricula')->get();

        $camiones = DB::table('vehiculos')
            ->join('camiones', 'vehiculos.matricula', '=', 'camiones.matricula')->get();

        return view('vehiculos.index', ['camionetas' => $camionetas], ['camiones' => $camiones]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vehiculos.create', ['camionero' => new Vehiculo()]);
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
        $request->validated()['tipo'];
        Vehiculo::create($request->validated());
        return to_route('cehiculos.show', $request->input('matricula'))->with('success', 'El camionero se edito correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vehiculo  $vehiculo
     * @return \Illuminate\Http\Response
     */
    public function show(Vehiculo $vehiculo)
    {
        $tipo = (DB::table('camiones')->where('matricula', $vehiculo->matricula)->exists()) ? 'Camion':'Camioneta';
        return view('vehiculos.show', ['vehiculo' => $vehiculo], ['tipo' => $tipo]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Vehiculo  $vehiculo
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehiculo $vehiculo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vehiculo  $vehiculo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehiculo $vehiculo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vehiculo  $vehiculo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehiculo $vehiculo)
    {
        //
    }
}
