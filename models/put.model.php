<?php

require_once "connection.php";
require_once "get.php";

class PutModel{

    /*==============================================
    Peticion PUT para editar datos de forma dinámica
    ==============================================*/

    static public function putData($table, $data, $id, $nameId){

        /*==============================================
        Validar la tabla y las columnas
        ==============================================*/

        
   
        $set = "";

        foreach($data as $key => $value){

            $set .= "$key = :$key,";

        }

        $set =  rtrim($set, ",");
        
        $query = "UPDATE $table SET $set WHERE $nameId = :$nameId";

        $link = Connection::connect();
        $stmt = $link->prepare($query);

        foreach ($data as $key => $value) {
            
            $stmt->bindParam(":$key", $data[$key], PDO::PARAM_STR);
        }

        $stmt->bindParam(":$nameId", $id, PDO::PARAM_STR);

        if($stmt->execute()){

            $response = array(

                    "lastId" => $link->lastInsertId(),  
                    "comment" => "El proceso fue exitoso"
            );
            return $response;
        }else{

            return $link->errorInfo();

        }

    }
}