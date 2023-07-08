<?php

require_once "models/connection.php";
require_once "controllers/post.controller.php";

if(isset($_POST)){

    $columns = "";

    foreach(array_keys($_POST) as $key){
        
        $columns .= "$key,";

    }

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

    $response = new PostController();
    $response->postData($table, $_POST);

}