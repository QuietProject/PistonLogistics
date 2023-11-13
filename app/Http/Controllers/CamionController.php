<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Almacen;
use Illuminate\Http\Request;
use App\Models\Lleva;
use App\Models\Paquete;
use App\Models\PaqueteLote;
use App\Models\Lote;
use App\Models\Conduce;
use App\Models\Orden;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CamionController extends Controller
{
    public function verPaquetes()
    {

        //$ci = session("user");
        $ci = "56789012";
        $matricula = Conduce::where('CI', $ci)->whereNull("hasta")->get("matricula")[0]->matricula;
        $ID_lote = Lleva::where('matricula', $matricula)->pluck('ID_lote');
        $lleva = PaqueteLote::whereIn('ID_lote', $ID_lote)->pluck('ID_paquete');
        return Paquete::whereIn('ID', $lleva)->get();
    }

    public function verLotes()
    {
        //$ci = session("user");
        $ci = "56789012";
        $matricula = Conduce::where('CI', $ci)->whereNull("hasta")->get("matricula")[0]->matricula;
        $ID_lote = Lleva::where('matricula', $matricula)->pluck('ID_lote');
        return Lote::whereIn('ID', $ID_lote)->get();
    }

    public function arranque($matricula)
    {
        //$ci = session("user");
        $ci = "56789012";

        if (Conduce::where('CI', $ci)->whereNull("hasta")->count() > 0) {
            return "El usuario ya está en un camion";
        }

        if (Conduce::where('matricula', $matricula)->whereNull("hasta")->count() > 0) {
            return "El camion ya esta en marcha";
        }

        // $a = Conducen::create([
        //     "CI" => $ci,
        //     "matricula" => $matricula
        // ]);

        $a = new Conduce();
        $a->CI = $ci;
        $a->matricula = $matricula;
        $a->save();

        return "Jornal iniciado";
    }

    public function parada()
    {
        //$ci = session("user");
        $ci = "56789012";

        if (Conduce::where('CI', $ci)->whereNull("hasta")->count() == 0) {
            return "El usuario no está en un camion";
        }

        $matricula = Conduce::where('CI', $ci)->whereNull("hasta")->get("matricula")[0]->matricula;

        if (Conduce::where('matricula', $matricula)->whereNull("hasta")->count() == 0) {
            return "El camion no esta en marcha";
        }

        Conduce::where('CI', $ci)->whereNull("hasta")->update([
            "hasta" => now()
        ]);

        return "Jornal finalizado";
    }

    public function verEstado($id)
    {
        return DB::select(DB::raw("SELECT paquetes.id as 'ID PAQUETE', lotes.id as 'ID LOTE',
        CASE
            WHEN trae.matricula is not null and trae.fecha_descarga is null THEN trae.matricula
            WHEN lleva.matricula is not null and lleva.fecha_descarga is null THEN lleva.matricula
            WHEN reparte.matricula is not null and reparte.fecha_descarga is null THEN reparte.matricula
            ELSE null
          END AS MATRICULA,
          destino_lote.ID_almacen as 'ALMACEN DESTINO', paquetes.direccion, paquetes.id_pickup,
          CASE
            WHEN paquetes.fecha_entregado is not null then 'Entregado'
            WHEN reparte.matricula is not null and reparte.fecha_descarga is null THEN 'Llevando hacia el destino final'
            WHEN lotes.ID is not null and tipo = 1 THEN 'Paquete esperando en pickUp'
            WHEN lleva.matricula is not null and lleva.fecha_descarga is null THEN 'Transportando hacia almacen secundario'
            WHEN trae.matricula is not null and trae.fecha_descarga is null THEN 'Trayendo hacia almacenes de QC'
            WHEN trae.ID_paquete is null THEN 'En almacenes del proveedor'
            ELSE 'En almacenes de QC'
          END AS 'ESTADO_ENVIO'

        FROM paquetes
        LEFT JOIN (
        SELECT paquetes_lotes.id_paquete, paquetes_lotes.id_lote, paquetes_lotes.fecha FROM paquetes_lotes INNER JOIN (
            SELECT id_paquete, MAX(fecha) AS max_fecha FROM paquetes_lotes GROUP BY id_paquete ) subquery
                ON paquetes_lotes.id_paquete = subquery.id_paquete AND paquetes_lotes.fecha = subquery.max_fecha
        ) paquetes_lotes ON paquetes.id = paquetes_lotes.id_paquete
        LEFT JOIN lotes ON paquetes_lotes.ID_lote = lotes.ID
        LEFT JOIN destino_lote ON lotes.ID = destino_lote.ID_lote
        LEFT JOIN lleva ON lotes.ID = lleva.id_lote
        LEFT JOIN trae ON paquetes.ID = trae.id_paquete
        LEFT JOIN reparte ON paquetes.ID = reparte.id_paquete
        WHERE paquetes.fecha_registrado < DATE_SUB(current_timestamp(), INTERVAL 0 DAY) AND paquetes.ID = $id"))[0]->ESTADO_ENVIO;
    }

    public function camion($cedula)
    {
        $camion = Conduce::where('CI', $cedula)->whereNull("hasta")->pluck("matricula");
        return $camion;
    }

    public function mapa(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cedula' => 'required|digits:8|exists:camioneros,CI'
        ]);
        if ($this->validacion($validator)) {
            return $this->validacion($validator);
        }

        $matricula = self::camion($request->cedula)[0];
        if ($matricula == null) {
            return response()->json([
                'message' => 'El camionero no está en un camion',
            ], 422);
        }

        // Tomo la troncal de los lotes que lleva el camion
        $troncal = DB::select("SELECT ID_troncal
        from LLEVA
        INNER JOIN LOTES ON LOTES.ID = LLEVA.ID_lote
        WHERE fecha_carga is not null
        and fecha_descarga is null
        and matricula = ?
        LIMIT 1", [$matricula]);

        // si lo anterior devuelve vacio tomo la troncal de los que tiene asignados
        if (count($troncal) != 1) {
            $troncal = DB::select("SELECT ID_troncal
            from LLEVA
            INNER JOIN LOTES ON LOTES.ID = LLEVA.ID_lote
            WHERE fecha_carga is null
            and matricula = ?
            LIMIT 1", [$matricula]);
        }
        if (count($troncal) != 1) {
            //return no hay nada
            return response()->json([
                'message' => 'No hay destinos asignados',
            ], 200);
        }


        //defino la troncal que tiene el camion
        $troncal = $troncal[0]->ID_troncal;

        //ultima orden troncal
        $ultimoOrdenDeTroncal = Orden::where('baja', 0)->where('ID_troncal', $troncal)->max('orden');

        $ordenOrigen = self::ordenOrigen($troncal, $matricula, 0);
        
        $lotesCargados = DB::select('SELECT LLEVA.ID_lote, ORDENES.orden
        FROM LLEVA
        INNER JOIN DESTINO_LOTE ON DESTINO_LOTE.ID_lote=LLEVA.ID_lote
        INNER JOIN ORDENES ON ORDENES.ID_almacen = DESTINO_LOTE.ID_almacen and ORDENES.ID_troncal = DESTINO_LOTE.ID_troncal
        WHERE fecha_carga is not null
        and fecha_descarga is null
        and matricula = ?
        ', [$matricula]);




        if (count($lotesCargados) == 0) {

            $lotesAsignados = DB::select('SELECT LLEVA.ID_lote, ORDENES.orden
            FROM LLEVA
            INNER JOIN LOTES ON LOTES.ID=LLEVA.ID_lote
            INNER JOIN ORDENES ON ORDENES.ID_almacen = LOTES.ID_almacen and ORDENES.ID_troncal = LOTES.ID_troncal
            WHERE fecha_carga is null
            and matricula = ?', [$matricula]);

            if (count($lotesAsignados) == 0) {
                //return no hay nada
                return response()->json([
                    'message' => 'No hay destinos asignados',
                ], 200);
            }
            //  COMPRUEBA SI TIENE LOTES PARA CARGAR EN EL ALMCEN ORIGEN
            // foreach($lotesAsignados as $lote){
            //     if($o)
            // }

            if ($ordenOrigen == 1) {
                $direccion = 'asc';
            } else if ($ordenOrigen == $ultimoOrdenDeTroncal) {
                $direccion = 'desc';
            } else {
                $almacenOrigen = $this->ordenToAlmacen($troncal, $ordenOrigen);

                $loteOrigen = DB::select('SELECT LLEVA.Id_lote,
                CASE
                    WHEN fecha_descarga is not null THEN fecha_descarga
                    ELSE fecha_carga
                    END as fecha,
                CASE
                    WHEN fecha_descarga is not null THEN DESTINO_LOTE.ID_almacen
                    ELSE LOTES.ID_almacen
                END as almacen,
                CASE
					WHEN exists( select ID_almacen from ORDENES where id_troncal = ? and id_almacen=almacen and baja =0) THEN 1
					ELSE 0
				END as esta
                 FROM LLEVA
                 INNER JOIN LOTES ON LOTES.ID = LLEVA.ID_lote
                 INNER JOIN DESTINO_LOTE ON LOTES.ID = DESTINO_LOTE.ID_lote
                 where !(fecha_descarga is not null and DESTINO_LOTE.ID_almacen=?) and !(fecha_descarga is null and LOTES.ID_almacen=?)
                 and matricula=?
                 order by fecha DESC
                 limit 1', [$troncal, $almacenOrigen, $almacenOrigen, $matricula]);


                if (!isset($loteOrigen[0]) || $loteOrigen[0]->esta == 1) {
                    $orden2 = 1;
                } else {
                    $almacenOrigen = $loteOrigen[0]->almacen;

                    $orden2 = DB::select('SELECT orden
                    FROM ORDENES
                    WHERE ID_almacen=?
                    AND ID_troncal=?
                    ', [$almacenOrigen[0]->ID_almacen, $troncal])[0]->orden;
                }
                $direccion = $orden2 < $ordenOrigen ? 'asc' : 'desc';
            }

            return $lotesAsignados;
        }

        // si alguna orden de lotes cargados es igual a la orden origen devolver que descargue ese lote en el almacen de la orden origen
        foreach ($lotesCargados as $lote) {
            if ($lote->orden == $ordenOrigen) {
                return response()->json([
                    'message' => "Descargar lote $lote en el almacen",
                ], 200);
            }
        }


        //determinar direccion del camion en la troncal
        // $direccionCamion = $ordenOrigen < $lotesCargados[0];
    }

    private function ordenOrigen($troncal, $matricula, $offset)
    {
        //busco el ultimo lote que descargo o cargo el camion
        $loteOrigen = DB::select('SELECT LLEVA.Id_lote,
        CASE
            WHEN fecha_descarga is not null THEN fecha_descarga
            ELSE fecha_carga
            END as fecha,
        CASE
            WHEN fecha_descarga is not null THEN DESTINO_LOTE.ID_almacen
            ELSE LOTES.ID_almacen
        END as almacen,
        CASE
            WHEN exists( select ID_almacen from ORDENES where id_troncal = ? and id_almacen=almacen and baja =0) THEN 1
            ELSE 0
        END as esta
         FROM LLEVA
         INNER JOIN LOTES ON LOTES.ID = LLEVA.ID_lote
         INNER JOIN DESTINO_LOTE ON LOTES.ID = DESTINO_LOTE.ID_lote
         where matricula=?
         and fecha_carga is not null
         order by fecha DESC
         limit 2', [$troncal, $matricula]);


        if (!isset($loteOrigen[$offset]) || $loteOrigen[$offset]->esta == 0) {
            $ordenOrigen = 1;
        } else {
            $almacenOrigen = $loteOrigen[0]->almacen;
            return $almacenOrigen;
            $ordenOrigen = DB::select('SELECT orden
            FROM ORDENES
            WHERE ID_almacen=?
            AND ID_troncal=?
            ', [$almacenOrigen[0]->ID_almacen, $troncal])[0]->orden;
        }

        return $ordenOrigen;
    }

    private function ordenToAlmacen($troncal, $orden)
    {
        return DB::select('SELECT ID_almacen
        FROM ORDENES
        WHERE troncal =?
        and orden =?
        order by baja desc
        limit 1', [$troncal, $orden])[0]->ID_almacen;
    }
}
