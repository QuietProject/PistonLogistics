<?php

namespace App\Http\Controllers;

use App\Models\Paquete;
use App\Models\PaqueteAlmacen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;

class TraeController extends Controller
{
    public function index()
    {
        $paquetes = DB::select('SELECT PAQUETES.ID ID_paquete,codigo, fecha_registrado,ALMACENES.ID ID_almacen,ALMACENES.nombre nombre, CLIENTES.nombre cliente, CLIENTES.RUT RUT
        from PAQUETES
        inner join ALMACENES on PAQUETES.ID_almacen = ALMACENES.ID
        inner join ALMACENES_CLIENTES on ALMACENES_CLIENTES.ID = ALMACENES.ID
        inner join CLIENTES on ALMACENES_CLIENTES.RUT = CLIENTES.RUT
        where estado = 1
        and PAQUETES.ID not in (SELECT ID_paquete
                                FROM TRAE)
        order by PAQUETES.fecha_registrado asc');

        return view('trae.index', ['paquetes' => $paquetes]);
    }

    public function show(Paquete $paquete)
    {
        $consulta = DB::select('SELECT PAQUETES.ID ID_paquete,codigo, fecha_registrado,ALMACENES.ID ID_almacen,ALMACENES.nombre nombre, CLIENTES.nombre cliente, CLIENTES.RUT RUT
        from PAQUETES
        inner join ALMACENES on PAQUETES.ID_almacen = ALMACENES.ID
        inner join ALMACENES_CLIENTES on ALMACENES_CLIENTES.ID = ALMACENES.ID
        inner join CLIENTES on ALMACENES_CLIENTES.RUT = CLIENTES.RUT
        where estado = 1
        and PAQUETES.ID not in (SELECT ID_paquete
                                FROM TRAE)
        and PAQUETES.ID=?', [$paquete->ID]);

        if (count($consulta) != 1) {
            return redirect()->back()->with('error', __('Ha ocurrido un error'));
        }
        $paquete = $consulta[0];

        $vehiculos = DB::select('SELECT VEHICULOS.matricula, count(PAQUETES.ID) paquetes_asignados, VEHICULOS.peso_max,
		CASE
			WHEN exists(select 1 from CAMIONETAS where CAMIONETAS.matricula=VEHICULOS.matricula) then 1
			ELSE 2
		END as tipo
        FROM VEHICULOS
        LEFT JOIN TRAE ON TRAE.matricula = VEHICULOS.matricula
        LEFT JOIN PAQUETES ON TRAE.ID_paquete = PAQUETES.ID
        where VEHICULOS.baja =0
        and VEHICULOS.es_operativo=1
        and VEHICULOS.matricula not in(	SELECT REPARTE.matricula
                                        FROM REPARTE
                                        where fecha_carga is null)
		and VEHICULOS.matricula not in(	SELECT LLEVA.matricula
                                        FROM LLEVA
                                        where fecha_carga is null)
        and TRAE.fecha_carga is null
        group by VEHICULOS.matricula, VEHICULOS.peso_max');


        return view('trae.show', [
            'paquete' => $paquete,
            'vehiculos' => $vehiculos
        ]);
    }

    public function store(Request $request, Paquete $paquete)
    {
        $matricula = $request->validate([
            'vehiculo' => ['required', 'exists:VEHICULOS,matricula']
        ])['vehiculo'];

        $enAlmacen = Paquete::where('ID', $paquete->ID)
            ->where('estado', 1)
            ->get();

        if (count($enAlmacen) != 1) {
            return redirect()->back()->with('error', __('Ha ocurrido un error'));
        }

        $vehiculo = DB::select('SELECT VEHICULOS.matricula, count(PAQUETES.ID) paquetes_asignados, VEHICULOS.peso_max,
		CASE
			WHEN exists(select 1 from CAMIONETAS where CAMIONETAS.matricula=VEHICULOS.matricula) then 1
			ELSE 2
		END as tipo
        FROM VEHICULOS
        LEFT JOIN TRAE ON TRAE.matricula = VEHICULOS.matricula
        LEFT JOIN PAQUETES ON TRAE.ID_paquete = PAQUETES.ID
        where VEHICULOS.baja =0
        and VEHICULOS.es_operativo=1
        and VEHICULOS.matricula not in(	SELECT REPARTE.matricula
                                        FROM REPARTE
                                        where fecha_carga is null)
		and VEHICULOS.matricula not in(	SELECT LLEVA.matricula
                                        FROM LLEVA
                                        where fecha_carga is null)
        and TRAE.fecha_carga is null
        and VEHICULOS.matricula = ?
        group by VEHICULOS.matricula', [$matricula]);

        if (count($vehiculo) != 1) {
            return redirect()->back()->with('error', __('Ha ocurrido un error'));
        }

        DB::insert('INSERT into TRAE (matricula, ID_paquete) values (?, ?)', [$matricula, $paquete->ID]);

        return to_route('trae.index')->with('success', __('Se ha asignado correctamente'));
    }

    public function desasignar()
    {
        $paquetes = DB::select('SELECT PAQUETES.ID ID_paquete,codigo, fecha_registrado,ALMACENES.ID ID_almacen,ALMACENES.nombre nombre, CLIENTES.nombre cliente, CLIENTES.RUT RUT, TRAE.fecha_asignado fecha_asignado, TRAE.matricula matricula
        FROM TRAE
        INNER JOIN PAQUETES ON TRAE.ID_paquete = PAQUETES.ID
        inner join ALMACENES on PAQUETES.ID_almacen = ALMACENES.ID
        inner join ALMACENES_CLIENTES on ALMACENES_CLIENTES.ID = ALMACENES.ID
        inner join CLIENTES on ALMACENES_CLIENTES.RUT = CLIENTES.RUT
        WHERE TRAE.fecha_carga is null');

        return view('trae.desasignar', ['paquetes' => $paquetes]);
    }

    public function destroy(Paquete $paquete)
    {
        $paquetes = DB::select('SELECT *
        FROM TRAE
        WHERE fecha_carga is null
        and ID_paquete = ?', [$paquete->ID]);

        if (count($paquetes) != 1) {
            return redirect()->back()->with('error', __('Ha ocurrido un error'));
        }

        DB::delete('DELETE FROM TRAE where ID_paquete = ?', [$paquete->ID]);

        return to_route('reparte.desasignar')->with('success', __('Se ha Desasignado correctamente'));
    }
}
