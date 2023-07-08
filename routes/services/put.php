<?php

require_once "models/connection.php";
require_once "controllers/put.controller.php";

if(isset($_GET["id"]) && isset($_GET["nameId"])){

    /*==============================================
    Capturamos datos del formulario
    ==============================================*/

    $data = array();
    parse_str(file_get_contents("php://input"), $data);


    $columns = "";

    foreach(array_keys($data) as $key){
        
        $columns .= "$key,";

    }

    $columns .= $_GET["nameId"];

    /*==============================================
    Validar la tabla y las columnas
    ==============================================*/

    if(empty(Connection::getColumnsData($table, $columns))){

        $json = array(

            "status" => 400,
            "result" => "Error: Los campos en el formulario no coinciden con la base de datos"
        );

        echo json_encode($json, http_response_code($json["status"]));
        return;
    }

    $response = new PutController();
    $response->putData($table, $data, $_GET["id"], $_GET["nameId"]);
    


}