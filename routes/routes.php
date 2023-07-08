<?php

$routesArray = explode("/", $_SERVER["REQUEST_URI"]);
$routesArray = array_filter($routesArray);

/*==============================================
Cuando no se hace ninguna petición a la API
==============================================*/

if(empty($routesArray)){

    $json = array(

        "status" => 404,
        "result" => "Not Found"
    );
    
    echo json_encode($json, http_response_code($json["status"]));
    return;
    
}

/*==============================================
Cuando si se hace una petición a la API
==============================================*/

if(isset($_SERVER["REQUEST_METHOD"]) && count($routesArray) == 1){

    $table = explode("?", $routesArray[1])[0];

    /*==============================================
    Peticiones GET
    ==============================================*/
    if($_SERVER["REQUEST_METHOD"] == "GET"){
        
        include "services/get.php";
        
    }

    /*==============================================
    Peticiones POST
    ==============================================*/
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        include "services/post.php";
        
    }

    /*==============================================
    Peticiones PUT
    ==============================================*/
    if($_SERVER["REQUEST_METHOD"] == "PUT"){
        
        include "services/put.php";
    
    }

    /*==============================================
    Peticiones DELETE
    ==============================================*/
    if($_SERVER["REQUEST_METHOD"] == "DELETE"){
        $json = array(

            "status" => 200,
            "result" => "Solicitud DELETE"
        );
        
        echo json_encode($json, http_response_code($json["status"]));
        return;
    }

}

