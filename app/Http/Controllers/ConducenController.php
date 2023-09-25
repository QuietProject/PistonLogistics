<?php

namespace App\Http\Controllers;

use App\Models\Conducen;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
    public function edit(Conducen $conducen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Conducen  $conducen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Conducen $conducen)
    {
        //
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
