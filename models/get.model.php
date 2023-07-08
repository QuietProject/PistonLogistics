<?php

require_once "connection.php";

class GetModel{

    /*==============================================
    Petición GET sin filtro
    ==============================================*/

    static public function getData($table, $select, $orderBy, $orderMode, $startAt, $endAt){

        /*==============================================
        Validar existencia de una tabla en la base de datos
        ==============================================*/

        if(empty(Connection::getColumnsData($table, $select))){

            return null;

        }

        /*==============================================
        Sin ordenar ni limitar datos
        ==============================================*/

        $query = "SELECT $select FROM $table ";

        /*==============================================
        Ordenar datos sin limites
        ==============================================*/

        if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null){
            $query = "SELECT $select FROM $table ORDER BY $orderBy $orderMode";
        }

        /*==============================================
        Ordenar y limitar datos
        ==============================================*/

        if($orderBy != null && $orderMode != null && $startAt != null && $endAt != null){
            $query = "SELECT $select FROM $table ORDER BY $orderBy $orderMode LIMIT $startAt $endAt";
        }

        /*==============================================
        Limitar datos sin ordenar
        ==============================================*/

        if($orderBy == null && $orderMode == null && $startAt != null && $endAt != null){
            $query = "SELECT $select FROM $table LIMIT $startAt $endAt";
        }

        $stmt = Connection::connect()->prepare($query);

        try{

            $stmt->execute();

        }catch(PDOException $e){

            return null;

        }
        
        

        return $stmt->fetchAll(PDO::FETCH_CLASS);
    }

    /*==============================================
    Petición GET con filtro
    ==============================================*/

    static public function getDataFilter($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt){

        /*==============================================
        Validar existencia de una tabla en la base de datos
        ==============================================*/

        $columns = "$select,$linkTo";

        if(empty(Connection::getColumnsData($table, $columns))){

            return null;

        }

        $linkToArray = explode(",", $linkTo);
        $equalToArray = explode(",", $equalTo);
        $linkToText = "";

        if(count($linkToArray)>1){

            foreach($linkToArray as $key => $value){

                if($key > 0){

                    $linkToText .= "AND ".$value." = :".$value." ";
                }
            }
        }

        /*==============================================
        Sin ordenar ni filtrar datos
        ==============================================*/

        $query = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText";

        /*==============================================
        Ordenar datos sin limites
        ==============================================*/

        if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null){
            $query = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText ORDER BY $orderBy $orderMode";
        }

        /*==============================================
        Ordenar y limitar datos
        ==============================================*/

        if($orderBy != null && $orderMode != null && $startAt != null && $endAt != null){
            $query = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText ORDER BY $orderBy $orderMode LIMIT $startAt $endAt";
        }

         /*==============================================
        Limitar datos sin ordenar
        ==============================================*/

        if($orderBy == null && $orderMode == null && $startAt != null && $endAt != null){
            $query = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $linkToText LIMIT $startAt $endAt";
        }

        $stmt = Connection::connect()->prepare($query);

        foreach($linkToArray as $key => $value){

            $stmt->bindParam(":$value", $equalToArray[$key], PDO::PARAM_STR);

        }

        try{

            $stmt->execute();

        }catch(PDOException $e){

            return null;
            
        }

        return $stmt->fetchAll(PDO::FETCH_CLASS);

    }

    /*==============================================
    Petición GET sin filtro entre tablas relacionadas
    ==============================================*/

    static public function getRelData($rel, $type, $select, $orderBy, $orderMode, $startAt, $endAt){

        $relArray = explode(",", $rel);
        $typeArray = explode(",", $type);
        $innerJoinText = "";

        if(count($relArray)>1){

            foreach($relArray as $key => $value){

                /*==============================================
                Validar existencia de una tabla en la base de datos
                ==============================================*/

                if(empty(Connection::getColumnsData($value, "*"))){

                    return null;

                }

                if($key > 0){

                    $innerJoinText .= "INNER JOIN $value ON $relArray[0].ID_$typeArray[0] = $value.ID_$typeArray[$key] ";
                }
            }
        

            /*==============================================
            Sin ordenar ni limitar
            ==============================================*/
            
            $query = "SELECT $select FROM $relArray[0] $innerJoinText";
            
            /*==============================================
            Ordenar datos sin limites
            ==============================================*/
            
            if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null){
                $query = "SELECT $select FROM $relArray[0] $innerJoinText ORDER BY $orderBy $orderMode";
            }
            
            /*==============================================
            Ordenar y limitar datos
            ==============================================*/
            
            if($orderBy != null && $orderMode != null && $startAt != null && $endAt != null){
                $query = "SELECT $select FROM $$relArray[0] $innerJoinText ORDER BY $orderBy $orderMode LIMIT $startAt $endAt";
            }
            
            /*==============================================
            Limitar datos sin ordenar
            ==============================================*/
            
            if($orderBy == null && $orderMode == null && $startAt != null && $endAt != null){
                $query = "SELECT $select FROM $$relArray[0] $innerJoinText LIMIT $startAt $endAt";
            }
            
            $stmt = Connection::connect()->prepare($query);

            try{

                $stmt->execute();
    
            }catch(PDOException $e){
    
                return null;
                
            }
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{
            return null;
        }
    }

    /*==============================================
    Petición GET con filtro entre tablas relacionadas
    ==============================================*/
       
    static public function getRelDataFilter($rel, $type, $select, $linkTo, $equalTo, $orderBy, $orderMode, $startAt, $endAt){

        /*==============================================
        Organizamos los filtros
        ==============================================*/

        $columns = "$select,$linkTo";
        $linkToArray = explode(",", $linkTo);
        $equalToArray = explode(",", $equalTo);
        $linkToText = "";

        if(count($linkToArray)>1){

            foreach($linkToArray as $key => $value){

                if($key > 0){

                    $linkToText .= "AND ".$value." = :".$value." ";
                }
            }
        }

        /*==============================================
        Organizamos las relaciones
        ==============================================*/

        $relArray = explode(",", $rel);
        $typeArray = explode(",", $type);
        $innerJoinText = "";

        if(count($relArray)>1){

            foreach($relArray as $key => $value){

                /*==============================================
                Validar existencia de una tabla y las columnas
                ==============================================*/

                if(empty(Connection::getColumnsData($value, "*"))){

                    return null;

                }

                if($key > 0){

                    $innerJoinText .= "INNER JOIN $value ON $relArray[0].ID_$typeArray[0] = $value.ID_$typeArray[$key] ";
                }
            }
        

            /*==============================================
            Sin ordenar ni limitar
            ==============================================*/
            
            $query = "SELECT $select FROM $relArray[0] $innerJoinText WHERE $linkToArray[0] = :$linkToArray[0] $linkToText";
            
            /*==============================================
            Ordenar datos sin limites
            ==============================================*/
            
            if($orderBy != null && $orderMode != null && $startAt == null && $endAt == null){
                $query = "SELECT $select FROM $relArray[0] $innerJoinText WHERE $linkToArray[0] = :$linkToArray[0] $linkToText ORDER BY $orderBy $orderMode";
            }
            
            /*==============================================
            Ordenar y limitar datos
            ==============================================*/
            
            if($orderBy != null && $orderMode != null && $startAt != null && $endAt != null){
                $query = "SELECT $select FROM $$relArray[0] $innerJoinText WHERE $linkToArray[0] = :$linkToArray[0] $linkToText ORDER BY $orderBy $orderMode LIMIT $startAt $endAt";
            }
            
            /*==============================================
            Limitar datos sin ordenar
            ==============================================*/
            
            if($orderBy == null && $orderMode == null && $startAt != null && $endAt != null){
                $query = "SELECT $select FROM $$relArray[0] $innerJoinText WHERE $linkToArray[0] = :$linkToArray[0] $linkToText LIMIT $startAt $endAt";
            }
            
            $stmt = Connection::connect()->prepare($query);

            foreach($linkToArray as $key => $value){

                $stmt->bindParam(":$value", $equalToArray[$key], PDO::PARAM_STR);
    
            }
    
            try{

                $stmt->execute();
    
            }catch(PDOException $e){
    
                return null;
                
            }
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        }else{
            return null;
        }
    }
    
}