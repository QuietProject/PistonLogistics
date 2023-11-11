<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Almacen;
use Illuminate\Http\Request;
use App\Models\Lleva;
use App\Models\Paquete;
use App\Models\PaqueteLote;
use App\Models\Lote;
use App\Models\Conducen;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CamionController extends Controller
{
    public function verPaquetes()
    {

        //$ci = session("user");
        $ci = "56789012";
        $matricula = Conducen::where('CI', $ci)->whereNull("hasta")->get("matricula")[0]->matricula;
        $ID_lote = Lleva::where('matricula', $matricula)->pluck('ID_lote');
        $lleva = PaqueteLote::whereIn('ID_lote', $ID_lote)->pluck('ID_paquete');
        return Paquete::whereIn('ID', $lleva)->get();
        

    }

    public function verLotes(){
        //$ci = session("user");
        $ci = "56789012";
        $matricula = Conducen::where('CI', $ci)->whereNull("hasta")->get("matricula")[0]->matricula;
        $ID_lote = Lleva::where('matricula', $matricula)->pluck('ID_lote');
        return Lote::whereIn('ID', $ID_lote)->get();
    }

    public function arranque($matricula){
        //$ci = session("user");
        $ci = "56789012";

        if(Conducen::where('CI', $ci)->whereNull("hasta")->count() > 0){
            return "El usuario ya está en un camion";
        }

        if(Conducen::where('matricula', $matricula)->whereNull("hasta")->count() > 0){
            return "El camion ya esta en marcha";
        }

        // $a = Conducen::create([
        //     "CI" => $ci,
        //     "matricula" => $matricula
        // ]);

        $a = new Conducen();
        $a->CI = $ci;
        $a->matricula = $matricula;
        $a->save();

        return "Jornal iniciado";
        
    }

    public function parada(){
        //$ci = session("user");
        $ci = "56789012";

        if(Conducen::where('CI', $ci)->whereNull("hasta")->count() == 0){
            return "El usuario no está en un camion";
        }

        $matricula = Conducen::where('CI', $ci)->whereNull("hasta")->get("matricula")[0]->matricula;

        if(Conducen::where('matricula', $matricula)->whereNull("hasta")->count() == 0){
            return "El camion no esta en marcha";
        }

        Conducen::where('CI', $ci)->whereNull("hasta")->update([
            "hasta" => now()
        ]);

        return "Jornal finalizado";
        
    }

    public function verEstado($id){
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

    public function camion($cedula){
        $camion = Conducen::where('CI', $cedula)->whereNull("hasta")->pluck("matricula");
        return $camion;
    }

    public function mapa(Request $request){
        $validator = Validator::make($request->all(), [
            'cedula' => 'required|digits:8|exists:camioneros,CI'
        ]);
        if ($this->validacion($validator)) {
            return $this->validacion($validator);
        }

        $matricula = self::camion($request->cedula);
        if (count($matricula) == 0) {
            return response()->json([
                'message' => 'El camionero no está en un camion',
            ], 422);
        }

        $lotes = Lleva::where('matricula', $matricula[0])->whereNull("fecha_descarga")->whereNotNull("fecha_carga")->pluck("ID_lote");
        
        foreach ($lotes as $lote){
            $destinos[] = Almacen::where("ID", $lote->destino_lote()->ID_almacen)->pluck("direccion");
        }

        $origen = Lleva::where("matricula", $matricula[0])->whereNull("fecha_descarga")->whereNull("fecha_carga")->pluck("ID_lote");
    }


}
