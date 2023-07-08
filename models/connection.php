<?php

use FTP\Connection as FTPConnection;

class Connection{

    /*==============================================
    Información de la base de datos
    ==============================================*/

    static public function infoDatabase(){

        $infoDB = array(

            "database" => "Piston_Logisitics",
            "user" => "root",
            "pass" => ""

        );
        
        return $infoDB;

    }

    /*==============================================
    Conexión a la base de datos
    ==============================================*/

    static public function connect(){

        try{
            $conn = new PDO("mysql:host=localhost;dbname=". Connection::infoDatabase()["database"],
            Connection::infoDatabase()["user"],
            Connection::infoDatabase()["pass"]);

            $conn->exec("set names utf8");
        }catch(PDOException $e){
            die("Error".$e->getMessage());
        }

        return $conn;
    }

    /*==============================================
    Validar existencia de una tabla en la base de datos
    ==============================================*/

    static public function getColumnsData($table, $columns){

        $database = Connection::infoDatabase()["database"];

        $validate = Connection::connect()
        ->query("SELECT COLUMN_NAME AS item FROM information_schema.columns WHERE table_schema = '$database' AND table_name = '$table'")
        ->fetchAll(PDO::FETCH_OBJ);

        if(empty($validate)){

            return null;

        }else{

            if($columns == "*" ){

                return $validate;           
            }

            $sum = 0;
            $selectArray = array_filter(array_unique(explode(",", $columns)));

            foreach($validate as $key => $value){

                $sum += in_array($value->item, $selectArray);

            }

            return count($selectArray) == $sum ? $validate : null;

        }
    }
}