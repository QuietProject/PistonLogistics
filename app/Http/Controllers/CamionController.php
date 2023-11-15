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
use App\Models\PaqueteAlmacen;
use App\Models\Reparte;
use App\Models\Trae;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use LDAP\Result;

use function PHPUnit\Framework\directoryExists;

class CamionController extends Controller
{
    private $apiKey = "9jLvsXLdz76cSLHe37HXXEJM4rw6SZ0hwSz3nZkSPV4";

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

    private function camion($cedula)
    {
        $camion = Conduce::where('CI', $cedula)->whereNull("hasta")->first("matricula");
        return $camion;
        return response()->json([
            'message' => 'El vehiculo no tiene carga asignada',
        ], 422);
    }

    public function getCamion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cedula' => 'required|digits:8|exists:CAMIONEROS,CI'
        ]);

        if ($this->validacion($validator)) {
            return $this->validacion($validator);
        }

        $matricula = self::camion($request->cedula);

        if (is_null($matricula)) {

            return response()->json([
                'message' => 'El camionero no está en un camion',
            ], 422);
        }
        $matricula = $matricula->matricula;
        return response()->json([
            'matricula' => $matricula
        ], 200);
    }

    public function mapa(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cedula' => 'required|digits:8|exists:CAMIONEROS,CI'
        ]);

        if ($this->validacion($validator)) {
            return $this->validacion($validator);
        }

        $matricula = self::camion($request->cedula);

        if (is_null($matricula)) {

            return response()->json([
                'message' => 'El camionero no está en un camion',
            ], 422);
        }
        $matricula = $matricula->matricula;

        //LLEVA LOTES
        if (Lleva::where('matricula', $matricula)->whereNotNull('fecha_carga')->whereNull('fecha_descarga')->exists()) {
            return $this->mapaLleva($matricula);
        }

        //TRAE PAQUETES
        if (Trae::where('matricula', $matricula)->whereNotNull('fecha_carga')->whereNull('fecha_descarga')->exists()) {
            return response()->json([
                'message' => 'TRAE PAQUETES',
            ], 422);
        }
        //REPARTE PAQUETES
        if (Reparte::where('matricula', $matricula)->whereNotNull('fecha_carga')->whereNull('fecha_descarga')->exists()) {
            return $this->mapaReparte($matricula);
        }

        //LLEVA ASIGNADO
        if (Lleva::where('matricula', $matricula)->whereNull('fecha_carga')->exists()) {
            return $this->mapaLleva($matricula);
        }

        //TRAE ASIGNADO
        if (Trae::where('matricula', $matricula)->whereNull('fecha_carga')->exists()) {
            return response()->json([
                'message' => 'TRAE ASIGNADO',
            ], 422);
        }
        //REPARTE ASIGNADO
        if (Reparte::where('matricula', $matricula)->whereNull('fecha_carga')->exists()) {
            return $this->mapaReparte($matricula);
        }


        return response()->json([
            'message' => 'El vehiculo no tiene carga asignada',
        ], 422);
    }


    private function mapaReparte($matricula){

        $carga = Reparte::where('matricula', $matricula)->whereNotNull('fecha_carga')->whereNull('fecha_descarga')->get();
        $asignado = Reparte::where('matricula', $matricula)->whereNull('fecha_carga')->get();

        if(count($carga)==0){

            $almacen = DB::select('SELECT *
            FROM PAQUETES_ALMACENES
            INNER JOIN ALMACENES ON ALMACENES.ID = PAQUETES_ALMACENES.ID_almacen
            where ID_paquete=?
            and hasta is null',[$asignado[0]->ID_paquete])[0];

            return response()->json([
                'modo' => 'reparte',
                'puntos' => [['lat'=>$almacen->latitud,'lng'=>$almacen->latitud],'direccion'=> $almacen->direccion,'codigo'=>$almacen->nombre,'peso'=>false]
            ], 200);

        }



        $almacenOrigen = DB::select('SELECT *
        FROM PAQUETES_ALMACENES
        INNER JOIN ALMACENES ON ALMACENES.ID = PAQUETES_ALMACENES.ID_almacen
        where ID_paquete=?
        order by hasta desc
        limit 1',[$carga[0]->ID_paquete])[0];


        foreach($carga as $paquete){
            $direccion = $this->idPaqueteToDireccion($paquete->ID_paquete);
            $data = $this->idPaqueteToData($paquete->ID_paquete);
            $puntos[] = ['coordenadas'=>$this->direccionToCooredenadas($direccion),'direccion'=>$direccion, 'codigo'=>$data->codigo,'peso'=>$data->peso];
        }

        $puntos[] = [['lat'=>$almacenOrigen->latitud,'lng'=>$almacenOrigen->latitud],'direccion'=> $almacenOrigen->direccion,'codigo'=>$almacenOrigen->nombre,'peso'=>false];

        dd($puntos);
        return response()->json([
            'modo' => 'reparte',
            'puntos' => $puntos
        ], 200);
    }





    private function mapaLleva($matricula)
    {

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
        $lotesCargados = DB::select('SELECT LLEVA.ID_lote, ORDENES.orden, SENTIDO_LOTES.sentido direccion
        FROM LLEVA
        INNER JOIN DESTINO_LOTE ON DESTINO_LOTE.ID_lote=LLEVA.ID_lote
        INNER JOIN ORDENES ON ORDENES.ID_almacen = DESTINO_LOTE.ID_almacen and ORDENES.ID_troncal = DESTINO_LOTE.ID_troncal
        INNER JOIN SENTIDO_LOTES ON SENTIDO_LOTES.ID = LLEVA.ID_lote
        WHERE fecha_carga is not null
        and fecha_descarga is null
        and matricula = ?
        ', [$matricula]);

        $lotesAsignados = DB::select('SELECT LLEVA.ID_lote, ORDENES.orden, SENTIDO_LOTES.sentido direccion
        FROM LLEVA
        INNER JOIN LOTES ON LOTES.ID=LLEVA.ID_lote
        INNER JOIN ORDENES ON ORDENES.ID_almacen = LOTES.ID_almacen and ORDENES.ID_troncal = LOTES.ID_troncal
        INNER JOIN SENTIDO_LOTES ON SENTIDO_LOTES.ID = LLEVA.ID_lote
        WHERE fecha_carga is null
        and matricula = ?', [$matricula]);


        //SI EL CAMION NO TIENE LOTES CARGADOS
        if (count($lotesCargados) == 0) {

            if (count($lotesAsignados) == 0) {
                //return no hay nada
                return response()->json([
                    'message' => 'No hay destinos asignados',
                ], 200);
            }

            //DETERMINA LA DIRECCION DE ACUERDO AL ORDEN ORIGEN
            if ($ordenOrigen == 1) {
                $direccion = 'asc';
            } else if ($ordenOrigen == $ultimoOrdenDeTroncal) {
                $direccion = 'desc';
            } else {
                //SI EL ORDEN ORIGEN NO CORRESPONDE AL EXTREMO DE LA TRONCAL BUSCA EL ORDEN ORIGEN ANTERIOR
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


                if (!isset($loteOrigen[0]) || $loteOrigen[0]->esta == 0) {
                    //SI EL ORDEN ORIGEN ANTERIOR NO CORRESPONDE CON LA TRONCAL SE DEJA 1 COMO EL ORDEN ORIGEN ANTERIOR
                    $orden2 = 1;
                } else {
                    $almacenOrigen2 = $loteOrigen[0]->almacen;
                    $orden2 = $this->almacenToOrden($almacenOrigen2, $troncal);
                }

                $direccion = $orden2 < $ordenOrigen ? 'asc' : 'desc';
            }



            //TOMA LOS LOTES QUE TIENE QUE CARGAR EN SENTIDO DE LA DIRECCION
            foreach ($lotesAsignados as  $lote) {
                if (($direccion == 'asc' &&  $ordenOrigen <= $lote->orden) || ($direccion == 'desc' &&  $ordenOrigen >= $lote->orden)) {
                    $lotesProximos[] = $lote;
                }
            }
            //SI EN SENTIDO DE LA DIRECCION NO HAY LOTES PARA CARGAR INVIERTE EL SENTIDO DE LA DIRECCION
            if (!isset($lotesProximos)) {
                $direccion = $direccion == 'asc' ? 'desc' : 'asc';
                foreach ($lotesAsignados as  $lote) {

                    if (($direccion == 'asc' &&  $ordenOrigen <= $lote->orden) || ($direccion == 'desc' &&  $ordenOrigen >= $lote->orden)) {
                        $lotesProximos[] = $lote;
                    }
                }
            }

            //TOMA LOS LOTES PROXIMOS QUE EL SENTIDO COINCIDA CON EL DEL CAMION
            foreach ($lotesProximos as  $lote) {

                if (($direccion == $lote->direccion)) {
                    $lotesFinales[] = $lote;
                }
            }
            //SI NINGUNO COINCIDE TOMO TODOS LOS LOTES
            if (!isset($lotesFinales)) {
                $lotesFinales = $lotesProximos;
            }


            $carga = [];
            foreach ($lotesFinales as $index => $lote) {

                if ($index == 0) {
                    $carga[] = $lote;
                } else if ($carga[0]->orden == $lote->orden) {
                    $carga[] = $lote;
                } else if (($direccion == 'desc' &&  $carga[0]->orden < $lote->orden) || ($direccion == 'asc' &&  $carga[0]->orden > $lote->orden)) {
                    $carga = [];
                    $carga[] = $lote;
                }
            }

            foreach ($carga as $lote) {
                $idLotesCarga[] = $this->idLoteToData($lote->ID_lote);
            }
            $coordenadasOrigen = $this->almacenToCoordenadas($this->ordenToAlmacen($troncal, $ordenOrigen));
            $coordenadasDestino = $this->almacenToCoordenadas(($this->ordenToAlmacen($troncal, $carga[0]->orden)));

            $coordenadas[] = $coordenadasOrigen;
            $coordenadas[] = $coordenadasDestino;


            return response()->json([
                'modo' => 'lleva',
                'coordenadas' => $coordenadas,
                'almacen' => [$this->almacenToDireccion( $this->ordenToAlmacen($troncal, $ordenOrigen)),$this->almacenToDireccion($this->ordenToAlmacen($troncal, $carga[0]->orden))],
                'descargar' => [],
                'cargar' => $idLotesCarga
            ], 200);
        }

        //OBTENER LA DIRECCION DE LA DIRECCION DE LOS LOTES CARGADOS
        $direccion = $lotesCargados[0]->direccion;

        $carga = [];
        $descarga = [];

        //VER CUALES LOTES CARGADOS ESTAN UBICADOS DEL LADO HACIA EL QUE VA LA DIRECCION DEL CAMION
        foreach ($lotesAsignados as  $lote) {
            if (($direccion == 'asc' &&  $ordenOrigen <= $lote->orden) || ($direccion == 'desc' &&  $ordenOrigen >= $lote->orden)) {
                $lotesCargaProximos[] = $lote;
            }
        }
        if (isset($lotesCargaProximos)) {
            //SI HAY VER CUALES SU DIRECCION COINCIDE CON LA DEL CAMION
            foreach ($lotesCargaProximos as  $lote) {

                if (($direccion == $lote->direccion)) {
                    $lotesCargaFinales[] = $lote;
                }
            }
            if (isset($lotesCargaFinales)) {
                //VER CUALES SON QUE ESTAN EN UN PUNTO MAS CERCANO AL ALMACEN ORIGEN
                foreach ($lotesCargaFinales as $index => $lote) {

                    if ($index == 0) {
                        $carga[] = $lote;
                    } else if ($carga[0]->orden == $lote->orden) {
                        $carga[] = $lote;
                    } else if (($direccion == 'desc' &&  $carga[0]->orden < $lote->orden) || ($direccion == 'asc' &&  $carga[0]->orden > $lote->orden)) {
                        $carga = [];
                        $carga[] = $lote;
                    }
                }
            }
        }
        //TOMO ORDEN DESTINO COMO EL ORDEN DEL PAQUETE ASIGNADO MAS CERCANO O COMO EL PRIMERO DE LA TRONCAL(EN CASO DE LA DIRECCION SER DESCENDENTE) O EL ULTMO (EN CASO DE SER ASCENDENTE)
        if (!empty($carga)) {
            $ordenDestino = $carga[0]->orden;
        } else {
            $ordenDestino = $direccion == 'asc' ? $ultimoOrdenDeTroncal : 1;
        }

        foreach ($lotesCargados as $index => $lote) {

            if ($ordenDestino == $lote->orden) {
                $descarga[] = $lote;
            } else if (($direccion == 'desc' &&  $ordenDestino < $lote->orden) || ($direccion == 'asc' &&  $ordenDestino > $lote->orden)) {
                $descarga = [];
                $carga = [];
                $descarga[] = $lote;
                $ordenDestino = $lote->orden;
            }
        }
        $codigoLotesCarga = [];
        foreach ($carga as $lote) {
            $codigoLotesCarga[] = $this->idLoteToData($lote->ID_lote);
        }
        $codigoLotesDescarga = [];
        foreach ($descarga as $lote) {
            $codigoLotesDescarga[] = $this->idLoteToData($lote->ID_lote);
        }
        $coordenadasOrigen = $this->almacenToCoordenadas($this->ordenToAlmacen($troncal, $ordenOrigen));
        $coordenadasDestino = $this->almacenToCoordenadas($this->ordenToAlmacen($troncal, $ordenDestino));

        $coordenadas[] = $coordenadasOrigen;
        $coordenadas[] = $coordenadasDestino;




        return response()->json([
            'modo' => 'lleva',
            'coordenadas' => $coordenadas,
            'almacen' => [$this->almacenToDireccion($this->ordenToAlmacen($troncal, $ordenOrigen)),$this->almacenToDireccion($this->ordenToAlmacen($troncal, $ordenDestino))],
            'descargar' => $codigoLotesDescarga,
            'cargar' => $codigoLotesCarga
        ], 200);
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
            $ordenOrigen = $this->almacenToOrden($almacenOrigen, $troncal);
        }
        return $ordenOrigen;
    }

    private function ordenToAlmacen($troncal, $orden)
    {
        return DB::select('SELECT ID_almacen
        FROM ORDENES
        WHERE ID_troncal =?
        and orden =?
        order by baja desc
        limit 1', [$troncal, $orden])[0]->ID_almacen;
    }

    private function almacenToOrden($almacen, $troncal)
    {
        return DB::select('SELECT orden
        FROM ORDENES
        WHERE ID_almacen=?
        AND ID_troncal=?
        ', [$almacen, $troncal])[0]->orden;
    }
    private function almacenToCoordenadas($almacen)
    {
        return DB::select('SELECT latitud lat, longitud lng
        FROM ALMACENES
        WHERE ID=?
        ', [$almacen])[0];
    }
    private function almacenToDireccion($almacen)
    {
        return DB::select('SELECT direccion
        FROM ALMACENES
        WHERE ID=?
        ', [$almacen])[0]->direccion;
    }

    private function idLoteToData($idLote)
    {
        return DB::select('SELECT codigo, peso
        FROM LOTES
        INNER JOIN PESO_LOTES ON PESO_LOTES.lote = LOTES.ID
        WHERE ID=?
        ', [$idLote])[0];
    }
    private function idPaqueteToData($idPaquete)
    {
        return DB::select('SELECT codigo, peso
        FROM PAQUETES
        WHERE ID=?
        ', [$idPaquete])[0];
    }
    private function direccionToCooredenadas($direccion)
    {
        $coordenadas = Http::acceptJson()->withOptions(['verify' => false])->get("https://geocode.search.hereapi.com/v1/geocode?q=$direccion&apiKey=$this->apiKey")["items"][0]["position"];
        return $coordenadas;
    }
    private function idPaqueteToDireccion($id)
    {
        return Paquete::where('ID',$id)->pluck('direccion')[0];

    }
}
