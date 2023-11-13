<?php

namespace App\Http\Controllers;

use App\Models\AlmacenPropio;
use App\Models\Orden;
use App\Models\Troncal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\returnSelf;

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
        $nombre = $request->validate(['nombre' => ['required', 'max:32', 'unique:TRONCALES']]);
        $troncal = Troncal::create($nombre);
        return to_route('troncales.show', $troncal)->with('success', __('La troncal se creo correctamente'));
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
            ->join('ALMACENES', 'ALMACENES.ID', 'ORDENES.ID_almacen')
            ->where('ORDENES.baja', 0)
            ->orderBy('ALMACENES.baja', 'asc')
            ->orderBy('ORDENES.baja', 'asc')
            ->orderBy('ORDENES.orden', 'asc')
            ->get(['ID_almacen', 'nombre', 'orden', 'ALMACENES.baja as almacenBaja']);
        //dd($ordenes);
        return view('troncales.show', ['troncal' => $troncal, 'ordenes' => $ordenes]);
    }

    /**
     *
     *
     * @param  \App\Models\Troncal  $troncal
     * @return \Illuminate\Http\Response
     */
    public function ordenes(Troncal $troncal)
    {
        $ordenes =  $ordenes = Orden::where('ID_troncal', $troncal->ID)
            ->join('ALMACENES', 'ALMACENES.ID', 'ORDENES.ID_almacen')
            ->where('ORDENES.baja', 0)
            ->where('ALMACENES.baja', 0)
            ->orderBy('ALMACENES.baja', 'asc')
            ->orderBy('ORDENES.baja', 'asc')
            ->orderBy('ORDENES.orden', 'asc')
            ->get(['ID_almacen', 'nombre', 'ALMACENES.baja as almacenBaja', 'direccion']);

        $almacenes = DB::select('select * from ALMACENES join ALMACENES_PROPIOS on ALMACENES.ID = ALMACENES_PROPIOS.ID where ALMACENES.baja=0 and ALMACENES.ID not in(select ID_almacen from ORDENES where baja=0 and ID_troncal=?)', [$troncal->ID]);
        return view('troncales.ordenes', ['troncal' => $troncal, 'ordenes' => $ordenes, 'almacenes' => $almacenes]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Troncal  $troncal
     * @return \Illuminate\Http\Response
     */
    public function ordenesUpdate(Request $request, Troncal $troncal)
    {
        $cadena = $request->input('ordenes');
        if (!preg_match('/^(?:\d+(?:,\d+)*)?$/m', $cadena)) {
            return redirect()->back()->with('error', __('ha ocurido un error'));
        }
        $ordenes = explode(',', $cadena);

        if (count($ordenes) !== count(array_unique($ordenes))) {
            return redirect()->back()->with('error', __('ha ocurido un error'));
        }
        if (empty($ordenes[0])) {
            DB::update('update ORDENES set baja=1 where ID_troncal=?', [$troncal->ID]);
            return to_route('troncales.show', $troncal)->with('success', __('La troncal se ha actualizado correctamente'));
        }
        for ($i = 0; $i < count($ordenes); $i++) {
            $almacen = AlmacenPropio::find($ordenes[$i]);
            if (empty($almacen)) {
                return redirect()->back()->with('error', __('ha ocurido un error'));
            }
            if ($almacen->almacen->baja) {
                return redirect()->back()->with('error', __('ha ocurido un error'));
            }
        }


        DB::update('update ORDENES set baja=1 where ID_troncal=?', [$troncal->ID]);
        for ($i = 0; $i < count($ordenes); $i++) {
            if (
                0 == Orden::where('ID_almacen', $ordenes[$i])
                ->where('ID_troncal', $troncal->ID)
                ->count()
            ) {
                Orden::create(['ID_almacen' => $ordenes[$i], 'ID_troncal' => $troncal->ID, 'orden' => $i + 1]);
            } else {
                DB::update('update ORDENES set orden=?, baja=0 where ID_troncal=? and ID_almacen = ?', [$i + 1, $troncal->ID, $ordenes[$i]]);
            }
        }

        return to_route('troncales.show', $troncal)->with('success', __('La troncal se ha actualizado correctamente'));
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
        $validated = $request->validate([
            'nombre' => ['required', 'max:32', 'unique:troncales']
        ]);
        $troncal->update($validated);
        return redirect()->back()->with('success', __('La troncal se actualizo correctamente'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Troncal  $troncal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Troncal $troncal)
    {
        $troncal->update(['baja' => !$troncal->baja]);
        return redirect()->back()->with('success', __('La troncal se actualizo correctamente'));
    }
}
