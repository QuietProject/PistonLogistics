<?php

require_once "models/get.model.php";

class GetController{

    static public function getData($table, $select, $orderBy, $orderMode, $startAt, $endAt){

        /*==============================================
        Petición GET sin filtro
        ==============================================*/

        $response = GetModel::getData($table, $select, $orderBy, $orderMode, $startAt, $endAt);

        $return = new GetController();
        $return->fncResponse($response);

    }       

    static public function getDataFilter($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt){

        /*==============================================
        Petición GET con filtro
        ==============================================*/

        $response = GetModel::getDataFilter($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt);

        $return = new GetController();
        $return->fncResponse($response);

    }       

    static public function getRelData($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt){

        /*==============================================
        Petición GET sin filtro entre tablas relacionadas
        ==============================================*/

        $response = GetModel::getRelData($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt);

        $return = new GetController();
        $return->fncResponse($response);

    }       

    static public function getRelDataFilter($rel, $type, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt){

        /*==============================================
        Petición GET con filtro entre tablas relacionadas
        ==============================================*/

        $response = GetModel::getRelDataFilter($rel, $type, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt);

        $return = new GetController();
        $return->fncResponse($response);

    }       


    public function fncResponse($response){

        if(!empty($response)){

            $json = array(

                "status" => 200,
                "total" => count($response),
                "result" => $response
            );

        }else{

            $json = array(

                "status" => 404,
                "result" => "Not Found",
                "method" => "GET"
            );
            
        }

        echo json_encode($json, http_response_code($json["status"]));

    } 
}