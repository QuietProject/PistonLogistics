<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Lote;
use App\Models\PaqueteLote;
use App\Models\Troncal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LlevaController extends Controller
{
    public function index()
    {
        $lotes = DB::select('SELECT LOTES.ID AS id,LOTES.codigo AS codigo,LOTES.ID_ALMACEN AS origen, LOTES.fecha_pronto pronto,DESTINO_LOTE.ID_almacen destino,DESTINO_LOTE.ID_troncal troncal,round(peso,2) peso,cantidad
        FROM LOTES INNER JOIN DESTINO_LOTE ON DESTINO_LOTE.ID_lote = LOTES.ID
        INNER JOIN PESO_LOTES ON PESO_LOTES.LOTE = DESTINO_LOTE.ID_lote
        WHERE LOTES.ID NOT IN (SELECT ID_lote FROM LLEVA)
        AND LOTES.fecha_cerrado IS NULL
        AND LOTES.fecha_pronto IS NOT NULL
        ORDER BY LOTES.fecha_pronto ASC');
        return view('lleva.index',['lotes'=>$lotes]);
    }

    public function show(Lote $lote)
    {
        $consulta = DB::select('SELECT LOTES.ID AS id,LOTES.codigo AS codigo,LOTES.ID_ALMACEN AS origen,DESTINO_LOTE.ID_almacen destino,DESTINO_LOTE.ID_troncal troncal,round(peso,2) peso,cantidad, LOTES.fecha_creacion, LOTES.fecha_pronto
        FROM LOTES
        INNER JOIN DESTINO_LOTE ON DESTINO_LOTE.ID_lote = LOTES.ID
        INNER JOIN PESO_LOTES ON PESO_LOTES.LOTE = DESTINO_LOTE.ID_lote
        WHERE LOTES.ID NOT IN   (SELECT ID_lote FROM LLEVA)
        AND LOTES.fecha_cerrado IS NULL
        AND LOTES.fecha_pronto IS NOT NULL
        AND LOTES.ID=?',[$lote->ID]);

        if (count($consulta)!=1) {
            return redirect()->back()->with('error',__('Ha ocurrido un error'));
        }
        $lote=$consulta[0];

        $paquetes=PaqueteLote::where('ID_lote',$lote->id)
            ->join('PAQUETES','PAQUETES.ID','PAQUETES_LOTES.ID_paquete')
            ->whereNull('PAQUETES_LOTES.hasta')
            ->get();

        $origen = Almacen::find($lote->origen);
        $destino = Almacen::find($lote->destino);
        $troncal = Troncal::find($lote->troncal);

        $camiones = DB::select('SELECT VEHICULOS.matricula, ifnull(round(sum(peso),2),0) carga_asignada, VEHICULOS.peso_max, max(LOTES.ID_troncal) troncal
        FROM CAMIONES
        INNER JOIN VEHICULOS ON VEHICULOS.matricula=CAMIONES.matricula
        LEFT JOIN (select * from LLEVA where fecha_carga is null) LLEVA ON VEHICULOS.matricula=LLEVA.matricula
        LEFT JOIN PESO_LOTES ON PESO_LOTES.lote = LLEVA.ID_lote
        LEFT JOIN LOTES ON LOTES.ID= LLEVA.ID_lote
        where VEHICULOS.baja =0
        and VEHICULOS.es_operativo=1
        and VEHICULOS.matricula not in(	SELECT TRAE.matricula
								FROM TRAE
								where fecha_carga is null)
        group by VEHICULOS.matricula, VEHICULOS.peso_max
        having carga_asignada + ?<peso_max
        and (troncal = ? or troncal is null)',[$lote->peso,$lote->troncal]);

        return view('lleva.show',[
            'lote'=>$lote,
            'paquetes'=>$paquetes,
            'origen'=>$origen,
            'destino'=>$destino,
            'lote'=>$lote,
            'troncal'=>$troncal,
            'camiones'=>$camiones,
        ]);

    }

    public function store(Request $request, Lote $lote)
    {
        $matricula = $request->validate([
            'camion'=> ['required','exists:CAMIONES,matricula']
            ])['camion'];

        $pesoLote = Lote::where('ID',$lote->ID)
            ->join('PESO_LOTES','PESO_LOTES.lote','LOTES.ID')
            ->get(['peso'])[0]->peso;


        $camion = DB::select('SELECT VEHICULOS.matricula, ifnull(round(sum(peso),2),0) carga_asignada, VEHICULOS.peso_max, max(LOTES.ID_troncal) troncal
        FROM CAMIONES
        INNER JOIN VEHICULOS ON VEHICULOS.matricula=CAMIONES.matricula
        LEFT JOIN (select * from LLEVA where fecha_carga is null) LLEVA ON VEHICULOS.matricula=LLEVA.matricula
        LEFT JOIN PESO_LOTES ON PESO_LOTES.lote = LLEVA.ID_lote
        LEFT JOIN LOTES ON LOTES.ID= LLEVA.ID_lote
        where VEHICULOS.baja =0
        and VEHICULOS.es_operativo=1
        and VEHICULOS.matricula = ?
        and VEHICULOS.matricula not in(	SELECT TRAE.matricula
								FROM TRAE
								where fecha_carga is null)
        group by VEHICULOS.matricula, VEHICULOS.peso_max
        having carga_asignada + ? < peso_max
        and (troncal = ? or troncal is null)',[$matricula,$pesoLote,$lote->ID_troncal]);
        if(count($camion)!=1){
            return redirect()->back()->with('error','Ha ocurrido un error');
        }

        DB::insert('INSERT into LLEVA (matricula, ID_lote) values (?, ?)', [$matricula, $lote->ID]);

        return to_route('lleva.index')->with('success',__('Se ha asignado correctamente'));
    }

    public function desasignar()
    {
        $lotes = DB::select('SELECT LOTES.ID AS id,LOTES.codigo AS codigo,LOTES.ID_ALMACEN AS origen, DESTINO_LOTE.ID_almacen destino, LOTES.fecha_pronto pronto,DESTINO_LOTE.ID_almacen destino,DESTINO_LOTE.ID_troncal troncal,round(peso,2) peso,cantidad, LLEVA.fecha_asignado as fecha_asignado, LLEVA.matricula
        FROM LOTES
        INNER JOIN DESTINO_LOTE ON DESTINO_LOTE.ID_lote = LOTES.ID
        INNER JOIN PESO_LOTES ON PESO_LOTES.LOTE = DESTINO_LOTE.ID_lote
        INNER JOIN LLEVA ON LLEVA.ID_lote = LOTES.ID
        WHERE LLEVA.fecha_carga is null
        ORDER BY LOTES.fecha_pronto ASC');

        return view('lleva.desasignar', ['lotes' => $lotes]);
    }

    public function destroy(Lote $lote)
    {
        $lotes = DB::select('SELECT *
        FROM LLEVA
        WHERE fecha_carga is null
        and ID_lote = ?', [$lote->ID]);

        if (count($lotes) != 1) {
            return redirect()->back()->with('error', 'Ha ocurrido un error');
        }

        DB::delete('DELETE FROM LLEVA where ID_lote = ?', [$lote->ID]);

        return to_route('lleva.desasignar')->with('success', __('Se ha Desasignado correctamente'));
    }

}
