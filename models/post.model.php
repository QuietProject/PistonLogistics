<?php

require_once "models/connection.php";

class PostModel{

    /*==============================================
    Peticion POST para crear datos de forma dinámica
    ==============================================*/

    static public function postData($table, $data){

        $columns = "";
        $params = "";

        foreach($data as $key => $value){
            //echo '<pre>'; print_r($key); echo '</pre>';
            //echo '<pre>'; print_r($value); echo '</pre>';


            $columns .= "$key, ";
            $params .= ":$key, ";

        }

        $columns = rtrim($columns, ", ");
        $params = rtrim($params, ", ");

        $query = "INSERT INTO $table ($columns) VALUES ($params)";

        $link = Connection::connect();
        $stmt = $link->prepare($query);

        foreach ($data as $key => $value) {
            
            $stmt->bindParam(":$key", $data[$key], PDO::PARAM_STR);
        }

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