<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveAlmacenRequest;
use App\Models\Almacen;
use App\Models\AlmacenCliente;
use App\Models\AlmacenPropio;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Http;

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
        $empresas = Cliente::all();
        return view('almacenes.index', ['propios' => $propios, 'clientes' => $clientes,'empresas'=>$empresas, 'almacen' => new Almacen()]);
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
    private $apiKey = "9jLvsXLdz76cSLHe37HXXEJM4rw6SZ0hwSz3nZkSPV4";
    public function store(SaveAlmacenRequest $request)
    {
        $direccion = $request->validated()['direccion'];
        $coordenadas = Http::acceptJson()->withOptions(['verify' => false])->get("https://geocode.search.hereapi.com/v1/geocode?q=$direccion&apiKey=$this->apiKey")["items"][0]["position"];
        $almacen = $request->validated();
        $tipo = $almacen['tipo'];
        if ($request->validated()['tipo'] == 'propio') {
            DB::enableQueryLog();
            DB::select('CALL almacen_propio (?,?,?,?,@ID,@fallo)', [$almacen['nombre'], $almacen['direccion'], $coordenadas['lat'], $coordenadas['lng']]);
            $queries = DB::getQueryLog();
            //dd($queries);
        } else {
            DB::select('CALL almacen_cliente (?,?,?,?,?,@ID,@fallo)', [$almacen['nombre'], $almacen['direccion'], $coordenadas['lat'], $coordenadas['lng'], $almacen['RUT']]);
        }
        $nuevo = DB::select('SELECT @FALLO AS fallo,@ID as id')[0];
        if ($nuevo->fallo != 0) {
            return redirect()->back()->with('error', 'Ha ocurrido un error');
        }
        return to_route('almacenes.show', $nuevo->id)->with('success', 'El almacen se agrego correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Almacen  $almacenhi
     * @return \Illuminate\Http\Response
     */
    public function show(Almacen $almacen)
    {
        $tipo = (DB::table('almacenes_propios')->where('ID', $almacen->ID)->exists()) ? 'propio' : 'cliente';

        if ($tipo == 'propio') {

            //Total de paquetes en almacen
            $paquetesEnAlmacen = DB::table('paquetes_almacenes')
                ->where('ID_almacen', $almacen->ID)
                ->whereNull('hasta')
                ->count();

            //Total de paquetes que pasaron por el almacen
            $paquetesRecibidos = DB::table('paquetes_almacenes')
                ->where('ID_almacen', $almacen->ID)
                ->count();

            //Total de lotes en preparacion en el almacen
            $lotesEnPreparacion = DB::table('lotes')
                ->where('lotes.ID_almacen', $almacen->ID)
                ->whereNull('fecha_pronto')
                ->count();

            //Total de lotes prontos que estan esperando a ser cargados
            $lotesProntos = DB::table('lotes')
                ->leftJoin('lleva', 'lleva.ID_lote', 'lotes.ID')
                ->where('lotes.ID_almacen', $almacen->ID)
                ->whereNotNull('lotes.fecha_pronto')
                ->whereNull('lleva.matricula')
                ->count();

            //Total de lotes creados en el almacen
            $lotesCreados = DB::table('lotes')
                ->where('lotes.ID_almacen', $almacen->ID)
                ->count();

            // Total de lotes recibidos en el almacen
            $lotesRecibidos  = DB::table('lotes')
                ->join('lleva', 'lotes.ID', 'lleva.ID_lote')
                ->join('destino_lote', 'lotes.ID', 'destino_lote.ID_lote')
                ->where('destino_lote.ID_almacen', $almacen->ID)
                ->count();

            // Total de lotes recibidos en el almacen que no fueron desarmados
            $lotesParaDesarmar  = DB::table('lotes')
                ->join('lleva', 'lotes.ID', 'lleva.ID_lote')
                ->join('destino_lote', 'lotes.ID', 'destino_lote.ID_lote')
                ->where('destino_lote.ID_almacen', $almacen->ID)
                ->whereNotNull('lleva.fecha_descarga')
                ->whereNull('lotes.fecha_cerrado')
                ->count();

            return view('almacenes.show', [
                'almacen' => $almacen,
                'tipo' => $tipo,
                'paquetesEnAlmacen' => $paquetesEnAlmacen,
                'paquetesRecibidos' => $paquetesRecibidos,
                'lotesEnPreparacion' => $lotesEnPreparacion,
                'lotesProntos' => $lotesProntos,
                'lotesCreados' => $lotesCreados,
                'lotesRecibidos' => $lotesRecibidos,
                'lotesParaDesarmar' => $lotesParaDesarmar
            ]);
        } else {
            $cliente = $almacen->almacen_cliente->cliente;
            $paquetesEncargados = DB::table('almacenes_clientes')
                ->join('paquetes', 'almacenes_clientes.ID', 'paquetes.ID_almacen')
                ->where('almacenes_clientes.ID', $almacen->ID)
                ->count();
            // Total de paquetes ordenados por este almacen que fueron entregados
            $paquetesEntregadosCliente = DB::table('almacenes_clientes')
                ->join('paquetes', 'almacenes_clientes.ID', 'paquetes.ID_almacen')
                ->where('almacenes_clientes.ID', $almacen->ID)
                ->whereNull('paquetes.fecha_entregado',)
                ->count();

            //Total de paquetes que estan esperando en este almacen
            $paquetesEnCliente = DB::table('almacenes_clientes')
                ->select('')
                ->join('paquetes', 'almacenes_clientes.ID', 'paquetes.ID_almacen')
                ->leftJoin('trae', 'paquetes.id', '=', 'trae.ID_paquete')
                ->where('almacenes_clientes.ID', $almacen->ID)
                ->whereNull('trae.matricula')->count();

            return view('almacenes.show', [
                'almacen' => $almacen,
                'cliente' => $cliente,
                'tipo' => $tipo,
                'paquetesEncargados' => $paquetesEncargados,
                'paquetesEntregadosCliente' => $paquetesEntregadosCliente,
                'paquetesEnCliente' => $paquetesEnCliente
            ]);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Almacen  $almacen
     * @return \Illuminate\Http\Response
     */
    public function update(SaveAlmacenRequest $request, Almacen $almacen)
    {
        $direccion = $request->validated()['direccion'];
        $coordenadas = Http::acceptJson()->withOptions(['verify' => false])->get("https://geocode.search.hereapi.com/v1/geocode?q=$direccion&apiKey=$this->apiKey")["items"][0]["position"];
        $datos = $request->validated();
        $datos['latitud'] = $coordenadas['lat'];
        $datos['longitud'] = $coordenadas['lng'];
        $almacen->update($datos);
        return redirect()->back()->with('success', 'El almacen se ha actualizado correctamete');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Almacen  $almacen
     * @return \Illuminate\Http\Response
     */
    public function destroy($almacen)
    {
        $almacen = Almacen::findOrFail($almacen);
        $almacen->baja = !$almacen->baja;
        $almacen->save();
        $baja = $almacen->baja ? 'baja' : 'alta';
        return redirect()->back()->with('success', 'El almacen de dio de ' . $baja . ' correctamente');
    }
}