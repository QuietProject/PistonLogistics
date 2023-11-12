<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveAlmacenRequest;
use App\Models\Almacen;
use App\Models\AlmacenCliente;
use App\Models\AlmacenPropio;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;
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
        return view('almacenes.index', ['propios' => $propios, 'clientes' => $clientes, 'empresas' => $empresas, 'almacen' => new Almacen()]);
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
        $direccion = $request->validated()['direccion'].',Uruguay';
        $coordenadas = Http::acceptJson()->withOptions(['verify' => false])->get("https://geocode.search.hereapi.com/v1/geocode?q=$direccion&apiKey=$this->apiKey")["items"][0]["position"];
        $almacen = $request->validated();
        $tipo = $almacen['tipo'];
        if ($request->validated()['tipo'] == 'propio') {
            DB::enableQueryLog();
            DB::select('CALL almacen_propio (?,?,?,?,@ID,@fallo)', [$almacen['nombre'], $almacen['direccion'], $coordenadas['lng'], $coordenadas['lat']]);
            $queries = DB::getQueryLog();
            //dd($queries);
        } else {
            DB::select('CALL almacen_cliente (?,?,?,?,?,@ID,@fallo)', [$almacen['nombre'], $almacen['direccion'], $coordenadas['lng'], $coordenadas['lat'], $almacen['RUT']]);
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
     * @param  \App\Models\Almacen  $almacen
     * @return \Illuminate\Http\Response
     */
    public function show(Almacen $almacen)
    {
        $tipo = (DB::table('ALMACENES_PROPIOS')->where('ID', $almacen->ID)->exists()) ? 'propio' : 'cliente';

        if ($tipo == 'propio') {

            //Troncales en las que esta el almacen
            $troncales = DB::table('ORDENES')
                ->join('TRONCALES','TRONCALES.ID','ORDENES.ID_troncal')
                ->where('TRONCALES.baja',0)
                ->where('ORDENES.baja',0)
                ->where('ID_almacen',$almacen->ID)
                ->get(['TRONCALES.ID AS ID','TRONCALES.nombre AS nombre']);
            //Total de paquetes en almacen
            $paquetesEnAlmacen = DB::table('PAQUETES_ALMACENES')
                ->where('ID_almacen', $almacen->ID)
                ->whereNull('hasta')
                ->count();

            //Lotes en el almacen
            /*$lotesEnAlmacen = DB::table('LOTES_EN_ALMACENES')
            ->where('ID_almacen', $almacen->ID)
            ->get();*/

            //Total de paquetes que pasaron por el almacen
            $paquetesRecibidos = DB::table('PAQUETES_ALMACENES')
                ->where('ID_almacen', $almacen->ID)
                ->count();

            //Total de lotes en preparacion en el almacen
            $lotesEnPreparacion = DB::table('LOTES')
                ->where('ID_almacen', $almacen->ID)
                ->whereNull('fecha_pronto')
                ->count();

            //Total de lotes prontos
            $lotesProntos = DB::table('LOTES')
                ->leftJoin('LLEVA', 'LLEVA.ID_lote', 'LOTES.ID')
                ->where('LOTES.ID_almacen', $almacen->ID)
                ->whereNotNull('LOTES.fecha_pronto')
                ->whereNull('LLEVA.matricula')
                ->count();

            //Total de lotes creados en el almacen
            $lotesCreados = DB::table('LOTES')
                ->where('ID_almacen', $almacen->ID)
                ->count();

            // Total de lotes recibidos en el almacen
            $lotesRecibidos  = DB::table('LOTES')
                ->join('LLEVA', 'LOTES.ID', 'LLEVA.ID_lote')
                ->join('DESTINO_LOTE', 'LOTES.ID', 'DESTINO_LOTE.ID_lote')
                ->where('DESTINO_LOTE.ID_almacen', $almacen->ID)
                ->whereNotNull('LLEVA.fecha_descarga')
                ->count();

            // Total de lotes recibidos en el almacen que no fueron desarmados
            $lotesParaDesarmar  = DB::table('LOTES')
                ->join('LLEVA', 'LOTES.ID', 'LLEVA.ID_lote')
                ->join('DESTINO_LOTE', 'LOTES.ID', 'DESTINO_LOTE.ID_lote')
                ->where('DESTINO_LOTE.ID_almacen', $almacen->ID)
                ->whereNotNull('LLEVA.fecha_descarga')
                ->whereNull('LOTES.fecha_cerrado')
                ->count();

            return view('almacenes.show', [
                'almacen' => $almacen,
                'tipo' => $tipo,
                'troncales' => $troncales,
                //'lotesEnAlmacen' => $lotesEnAlmacen,
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

            // Total de paquetes ordenados por este almacen
            $paquetesEncargados = DB::table('ALMACENES_CLIENTES')
                ->join('PAQUETES', 'ALMACENES_CLIENTES.ID', 'PAQUETES.ID_almacen')
                ->where('ALMACENES_CLIENTES.ID', $almacen->ID)
                ->count();
            // Total de paquetes ordenados por este almacen que fueron entregados
            $paquetesEntregadosCliente = DB::table('ALMACENES_CLIENTES')
                ->join('PAQUETES', 'ALMACENES_CLIENTES.ID', 'PAQUETES.ID_almacen')
                ->where('ALMACENES_CLIENTES.ID', $almacen->ID)
                ->whereNotNull('PAQUETES.fecha_entregado',)
                ->count();

            //Total de paquetes que estan esperando en este almacen
            $paquetesEnCliente = DB::table('ALMACENES_CLIENTES')
                ->select('')
                ->join('PAQUETES', 'ALMACENES_CLIENTES.ID', 'PAQUETES.ID_almacen')
                ->leftJoin('TRAE', 'PAQUETES.id', '=', 'TRAE.ID_paquete')
                ->where('ALMACENES_CLIENTES.ID', $almacen->ID)
                ->whereNull('TRAE.fecha_carga')->count();

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
        $direccion = $request->validated()['direccion'].',Uruguay';
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
