<?php

namespace App\Http\Controllers;

use App\Models\Paquete;
use App\Models\PaqueteAlmacen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReparteController extends Controller
{
    public function index()
    {
        $paquetes= DB::select('SELECT *
        from PAQUETES
        inner join PAQUETES_ALMACENES on PAQUETES_ALMACENES.ID_paquete = PAQUETES.ID
        inner join ALMACENES on PAQUETES_ALMACENES.ID_almacen = ALMACENES.ID
        where estado = 7
        and PAQUETES_ALMACENES.hasta is null
        and PAQUETES.peso is not null
        and PAQUETES.ID not in (SELECT ID_paquete
                                FROM REPARTE)
        order by PAQUETES_ALMACENES.desde asc');

        return view('reparte.index',['paquetes'=>$paquetes]);
    }

    public function show(Paquete $paquete)
    {
        $consulta = DB::select('SELECT PAQUETES.ID as ID_paquete,PAQUETES.codigo,PAQUETES.direccion as direccion,PAQUETES.fecha_registrado,PAQUETES_ALMACENES.desde,ALMACENES.ID as ID_almacen,ALMACENES.nombre as nombre,PAQUETES.peso
        from PAQUETES
        inner join PAQUETES_ALMACENES on PAQUETES_ALMACENES.ID_paquete = PAQUETES.ID
        inner join ALMACENES on PAQUETES_ALMACENES.ID_almacen = ALMACENES.ID
        where estado = 7
        and PAQUETES_ALMACENES.hasta is null
        and PAQUETES.peso is not null
        and PAQUETES.ID = ?
        and PAQUETES.ID not in (SELECT ID_paquete
                                FROM REPARTE)
        order by PAQUETES_ALMACENES.desde asc', [$paquete->ID]);

        if (count($consulta)!=1) {
            return redirect()->back()->with('error','Ha ocurrido un error');
        }
        $paquete=$consulta[0];

        $camionetas = DB::select('SELECT VEHICULOS.matricula, ifnull(round(sum(peso),2),0) carga_asignada,  VEHICULOS.peso_max, max(PAQUETES_ALMACENES.ID_almacen) almacen
        FROM VEHICULOS
        INNER JOIN CAMIONETAS ON VEHICULOS.matricula = CAMIONETAS.matricula
        LEFT JOIN REPARTE ON REPARTE.matricula = VEHICULOS.matricula
        LEFT JOIN PAQUETES ON REPARTE.ID_paquete = PAQUETES.ID
        LEFT JOIN PAQUETES_ALMACENES ON REPARTE.ID_paquete = PAQUETES_ALMACENES.ID_paquete
        where VEHICULOS.baja =0
        and VEHICULOS.es_operativo=1
        and VEHICULOS.matricula not in(	SELECT TRAE.matricula
                                        FROM TRAE
                                        where fecha_carga is null)
        and REPARTE.fecha_carga is null
        group by VEHICULOS.matricula, VEHICULOS.peso_max
        having carga_asignada + ? < peso_max
        and almacen is null or almacen = ?',[$paquete->peso,$paquete->ID_almacen]);



        return view('reparte.show',[
            'paquete'=>$paquete,
            'camionetas'=>$camionetas
        ]);

    }

    public function store(Request $request, Paquete $paquete)
    {
        $matricula = $request->validate([
            'camioneta'=> ['required','exists:CAMIONETAS,matricula']
        ])['camioneta'];

        $almacen = PaqueteAlmacen::where('ID_paquete',$paquete->ID)
        ->whereNull('hasta')
        ->get();

        if(count($almacen)!=1){
            return redirect()->back()->with('error','Ha ocurrido un error');
        }

        $camioneta = DB::select('SELECT VEHICULOS.matricula, ifnull(round(sum(peso),2),0) carga_asignada, VEHICULOS.peso_max, max(PAQUETES_ALMACENES.ID_almacen) almacen
        FROM VEHICULOS
        INNER JOIN CAMIONETAS ON VEHICULOS.matricula = CAMIONETAS.matricula
        LEFT JOIN REPARTE ON REPARTE.matricula = VEHICULOS.matricula
        LEFT JOIN PAQUETES ON REPARTE.ID_paquete = PAQUETES.ID
        LEFT JOIN PAQUETES_ALMACENES ON REPARTE.ID_paquete = PAQUETES_ALMACENES.ID_paquete
        where VEHICULOS.baja =0
        and VEHICULOS.es_operativo=1
        and VEHICULOS.matricula=?
        and VEHICULOS.matricula not in(	SELECT TRAE.matricula
                                        FROM TRAE
                                        where fecha_carga is null)
        and REPARTE.fecha_carga is null
        group by VEHICULOS.matricula
        having carga_asignada + ? < peso_max
        and almacen is null or almacen = ?',[$matricula,$paquete->peso,$almacen[0]->ID_almacen]);
        if(count($camioneta)!=1){
            return redirect()->back()->with('error','Ha ocurrido un error');
        }

        DB::insert('INSERT into REPARTE (matricula, ID_paquete) values (?, ?)', [$matricula,$paquete->ID]);

        return to_route('reparte.index')->with('success','Se ha asignado correctamente');
    }

    public function desasignar()
    {
        $paquetes = DB::select('SELECT *
		from PAQUETES
		inner join PAQUETES_ALMACENES on PAQUETES_ALMACENES.ID_paquete = PAQUETES.ID
		inner join ALMACENES on PAQUETES_ALMACENES.ID_almacen = ALMACENES.ID
        INNER JOIN REPARTE ON REPARTE.ID_paquete = PAQUETES.ID
		where estado = 7
		and PAQUETES_ALMACENES.hasta is null
		and PAQUETES.peso is not null
		and REPARTE.fecha_carga is null
		order by PAQUETES_ALMACENES.desde asc');

        return view('reparte.desasignar', ['paquetes' => $paquetes]);
    }

    public function destroy(Paquete $paquete)
    {
        $paquetes = DB::select('SELECT *
        FROM REPARTE
        WHERE fecha_carga is null
        and ID_paquete = ?', [$paquete->ID]);

        if (count($paquetes) != 1) {
            return redirect()->back()->with('error', 'Ha ocurrido un error');
        }

        DB::delete('DELETE FROM REPARTE where ID_paquete = ?', [$paquete->ID]);

        return to_route('reparte.desasignar')->with('success', 'Se ha Desasignado correctamente');
    }


}
