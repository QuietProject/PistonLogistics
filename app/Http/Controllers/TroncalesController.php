<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use App\Models\Troncal;
use Illuminate\Http\Request;

class TroncalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $troncales = Troncal::all();
        return view('troncales.index', ['troncales' => $troncales, 'troncal' => new Troncal()]);
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
        $nombre = $request->validate(['nombre' => ['required', 'max:32', 'unique:troncales']]);
        $troncal = Troncal::create($nombre);
        return to_route('troncales.show', $troncal)->with('success', 'La troncal se creo correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Troncal  $troncal
     * @return \Illuminate\Http\Response
     */
    public function show(Troncal $troncal)
    {
        $ordenes = Orden::where('ID_troncal', $troncal->ID)
            ->join('ALMACENES','ALMACENES.ID','ORDENES.ID_almacen')
            ->orderBy('ALMACENES.baja', 'asc')
            ->orderBy('ORDENES.baja', 'asc')
            ->orderBy('ORDENES.orden', 'asc')
            ->get(['ID_almacen','nombre','orden','ORDENES.baja as ordenBaja','ALMACENES.baja as almacenBaja']);
            //dd($ordenes);
        return view('troncales.show', ['troncal' => $troncal, 'ordenes'=>$ordenes]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Troncal  $troncal
     * @return \Illuminate\Http\Response
     */
    public function edit(Troncal $troncal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Troncal  $troncal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Troncal $troncal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Troncal  $troncal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Troncal $troncal)
    {
        //
    }
}
