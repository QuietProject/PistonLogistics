<?php
class Customer extends Db
{


    protected function getAllCustomers()
    {
        $query = $this->conn()->prepare("SELECT * FROM `clientes` WHERE `baja`=0");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function existsCustomer($rut)
    {
        $query = $this->conn()->prepare("SELECT COUNT(`RUT`) FROM `clientes` WHERE `RUT`=:rut AND `baja` = 0");
        $query->bindParam('rut', $rut);

        $query->execute();

        $result = true;
        if ($query->fetchColumn() == 0) {
            $result = !$result;
        }
        return $result;
    }
    
    protected function customersCount()
    {
        $query = $this->conn()->prepare("SELECT COUNT(`RUT`) FROM `clientes` WHERE `baja` = 0");
        $query->bindParam('rut', $rut);

        $query->execute();

        $result = true;
        if ($query->fetchColumn() == 0) {
            $result = !$result;
        }
        return $result;
    }
    

    protected function existsRut($rut)
    {
        $query = $this->conn()->prepare("SELECT COUNT(`RUT`) FROM `clientes` WHERE `RUT`=:rut");
        $query->bindParam('rut', $rut);

        $query->execute();

        $result = true;
        if ($query->fetchColumn() == 0) {
            $result = !$result;
        }
        return $result;
    }

    protected function insertCustomer($rut,$nombre)
    {
        $query = $this->conn()->prepare("INSERT INTO `clientes`(`RUT`, `nombre`) VALUES (:rut,:nombre)");
        $query->bindParam(':rut', $rut);
        $query->bindParam(':nombre', $nombre);
        if (!$query->execute()) {
            echo json_encode('Error 1: ' . $query->errorInfo());
            exit();
        }
    }
    protected function getCustomer($rut)
    {
        $query = $this->conn()->prepare("SELECT * FROM `clientes` WHERE `RUT`=:rut AND `baja` = 0");
        $query->bindParam('rut', $rut);

        if (!$query->execute()) {
            echo json_encode('Error: ' . $query->errorInfo());
            exit();
        }
        return  $query->fetch(PDO::FETCH_ASSOC);
    }

    protected function updateCustomer($oldRut, $rut, $nombre)
    {
        $query = $this->conn()->prepare("UPDATE `clientes` SET `RUT`= :RUT, `nombre`= :nombre WHERE `RUT`=:oldRut");
        $query->bindParam('oldRut', $oldRut);
        $query->bindParam('RUT', $rut);
        $query->bindParam('nombre', $nombre);
        
        if (!$query->execute()) {
            echo json_encode('Error: ' . $query->errorInfo());
            exit();
        }
    }
    
    protected function removeCustomer($rut)
    {
        $query = $this->conn()->prepare("UPDATE `clientes` SET `baja`= 1 WHERE `rut`=:rut");
        $query->bindParam('rut', $rut);
        $query->execute();
    }
        

}
