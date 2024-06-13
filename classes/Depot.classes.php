<?php
class Depot extends Db
{


    protected function getOwnDepots()
    {
        $query = $this->conn()->prepare("SELECT * FROM `almacenes` WHERE baja=0 AND `id`IN( SELECT `id` FROM `almacenes_propios` );");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    protected function getClientDepots()
    {
        $query = $this->conn()->prepare("SELECT almacenes.id,almacenes.nombre,almacenes.calle,almacenes.numero,clientes.nombre as cliente FROM `almacenes_clientes`,`clientes`,`almacenes` WHERE almacenes.id=almacenes_clientes.id AND clientes.RUT=almacenes_clientes.RUT AND clientes.baja=0 AND almacenes.baja=0");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function existsDepot($id)
    {
        $query = $this->conn()->prepare("SELECT COUNT(`id`) FROM `almacenes` WHERE `id`=:id AND `baja` = 0");
        $query->bindParam('id', $id);

        $query->execute();

        $result = true;
        if ($query->fetchColumn() == 0) {
            $result = !$result;
        }
        return $result;
    }
    protected function removeDepot($id)
    {
        $query = $this->conn()->prepare("UPDATE `almacenes` SET `baja`= 1 WHERE `id`=:id");
        $query->bindParam('id', $id);
        $query->execute();
    }

    protected function insertDepot($nombre, $calle, $numero)
    {
        $db = $this->conn();
        $query = $db->prepare("INSERT INTO `almacenes`(`nombre`, `calle`, `numero`) VALUES (:nombre, :calle, :numero)");
        $query->bindParam(':nombre', $nombre);
        $query->bindParam(':calle', $calle);
        $query->bindParam(':numero', $numero);
        if (!$query->execute()) {
            echo json_encode('Error 1: ' . $query->errorInfo());
            exit();
        }
        return $db->lastInsertID();
    }
    protected function insertOwnDepot($id)
    {
        $query = $this->conn()->prepare("INSERT INTO `almacenes_propios`(`id`) VALUES (:id)");
        $query->bindParam(':id', $id);
        if (!$query->execute()) {
            echo json_encode('Error 1: ' . $query->errorInfo());
            exit();
        }
    }
    protected function insertCustomerDepot($id, $rut)
    {
        $query = $this->conn()->prepare("INSERT INTO `almacenes_clientes`(`id`,`RUT`) VALUES (:id,:rut)");
        $query->bindParam(':id', $id);
        $query->bindParam(':rut', $rut);
        if (!$query->execute()) {
            echo json_encode('Error 2: ' . $query->errorInfo());
            exit();
        }
    }

    protected function customerIs($id)
    {
        $query = $this->conn()->prepare("SELECT COUNT(`id`) FROM `almacenes_clientes` WHERE `id`=:id AND `baja` = 0");
        $query->bindParam('id', $id);

        $query->execute();

        $result = true;
        if ($query->fetchColumn() == 0) {
            $result = !$result;
        }
        return $result;
    }
    protected function ownIs($id)
    {
        $query = $this->conn()->prepare("SELECT COUNT(`id`) FROM `almacenes_propios` WHERE `id`=:id AND `baja` = 0");
        $query->bindParam('id', $id);

        $query->execute();

        $result = true;
        if ($query->fetchColumn() == 0) {
            $result = !$result;
        }
        return $result;
    }

    protected function getDepot($id)
    {
        $query = $this->conn()->prepare("SELECT * FROM `almacenes` WHERE `id`=:id AND `baja` = 0");
        $query->bindParam('id', $id);

        if (!$query->execute()) {
            echo json_encode('Error: ' . $query->errorInfo());
            exit();
        }
        return  $query->fetch(PDO::FETCH_ASSOC);
    }

    protected function updateDepot($nombre, $calle, $numero, $id)
    {
        $query = $this->conn()->prepare("UPDATE `almacenes` SET `nombre`= :nombre, `calle`=:calle,`numero`=:numero WHERE `id`=:id");
        $query->bindParam('id', $id);
        $query->bindParam('nombre', $nombre);
        $query->bindParam('calle', $calle);
        $query->bindParam('numero', $numero);

        if (!$query->execute()) {
            echo json_encode('Error: ' . $query->errorInfo());
            exit();
        }
    }
}
