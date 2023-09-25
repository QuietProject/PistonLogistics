<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveCamioneroRequest;
use App\Models\Camionero;
use App\Models\Conducen;
use Carbon\Carbon;

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
        return   view('camioneros.index', ['camioneros' => $camioneros]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('camioneros.create', ['camionero' => new Camionero()]);
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
        return to_route('camioneros.show', $request->input('CI'))->with('success', 'El camionero se edito correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Camionero  $camionero
     * @return \Illuminate\Http\Response
     */
    public function show(Camionero $camionero)
    {
        $vehiculos = Conducen::where('CI', $camionero->CI)->orderBy('hasta', 'asc')->get();
        return view('camioneros.show', ['camionero' => $camionero, 'vehiculos' => $vehiculos]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Camionero  $camionero
     * @return \Illuminate\Http\Response
     */
    public function edit(Camionero $camionero)
    {
        return view('camioneros.edit', ['camionero' => $camionero]);
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
