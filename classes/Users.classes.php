<?php
class Users extends Db
{


    protected function getAllUsers()
    {
        $query = $this->conn()->prepare("SELECT usuarios.*, camioneros.licencia FROM usuarios LEFT JOIN camioneros ON usuarios.id = camioneros.id WHERE baja=0");
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function getUserByUsername($username)
    {
        $query = $this->conn()->prepare("SELECT * FROM `usuarios` WHERE `username`=:username AND `baja` = 0");
        $query->bindParam('username', $username);

        if (!$query->execute()) {
            echo json_encode('Error: ' . $query->errorInfo());
            exit();
        }
        return  $query->fetch(PDO::FETCH_ASSOC);
    }

    protected function getUserById($id)
    {
        $query = $this->conn()->prepare("SELECT * FROM `usuarios` WHERE `id`=:id AND `baja` = 0");
        $query->bindParam('id', $id);

        if (!$query->execute()) {
            echo json_encode('Error: ' . $query->errorInfo());
            exit();
        }
        return  $query->fetch(PDO::FETCH_ASSOC);
    }

    protected function getCamioneroById($id)
    {
        $query = $this->conn()->prepare("SELECT * FROM `camioneros` WHERE `id`=:id");
        $query->bindParam('id', $id);

        if (!$query->execute()) {
            echo json_encode('Error: ' . $query->errorInfo());
            exit();
        }
        return  $query->fetch(PDO::FETCH_ASSOC);
    }

    protected function existsUser($id)
    {
        $query = $this->conn()->prepare("SELECT COUNT(`id`) FROM `usuarios` WHERE `id`=:id AND `baja` = 0");
        $query->bindParam('id', $id);

        $query->execute();

        $result = true;
        if ($query->fetchColumn() == 0) {
            $result = !$result;
        }
        return $result;
    }

    protected function existsUsername($username)
    {
        $query = $this->conn()->prepare("SELECT COUNT(`id`) FROM `usuarios` WHERE `username`=:username AND `baja` = 0");
        $query->bindParam('username', $username);

        $query->execute();

        $result = true;
        if ($query->fetchColumn() == 0) {
            $result = !$result;
        }
        return $result;
    }

    protected function esCamionero($id)
    {
        $query = $this->conn()->prepare("SELECT COUNT(`id`) FROM `camionero` WHERE `id`=:id");
        $query->bindParam('id', $id);

        $query->execute();

        $result = true;
        if ($query->fetchColumn() == 0) {
            $result = !$result;
        }
        return $result;
    }

    protected function removeUser($id)
    {
        $query = $this->conn()->prepare("UPDATE `usuarios` SET `baja`= 1 WHERE `id`=:id");
        $query->bindParam('id', $id);
        $query->execute();
    }

    protected function removeCamionero($id)
    {
        $query = $this->conn()->prepare("DELETE FROM `camionero` WHERE `id`=:id");
        $query->bindParam('id', $id);
        $query->execute();
    }

    protected function insertUser($usuario, $pass, $nombre, $apellido, $celular, $rol)
    {
        $db = $this->conn();
        $query = $db->prepare("INSERT INTO `usuarios`(`username`, `pass`, `nombre`, `apellido`, `telefono`, `rol`) VALUES (:usuario, :pass, :nombre, :apellido, :telefono, :rol)");
        $query->bindParam(':usuario', $usuario);
        $query->bindParam(':pass', $pass);
        $query->bindParam(':nombre', $nombre);
        $query->bindParam(':apellido', $apellido);
        $query->bindParam(':telefono', $celular);
        $query->bindParam(':rol', $rol);
        if (!$query->execute()) {
            echo json_encode('Error 1: ' . $query->errorInfo());
            exit();
        }
        return $db->lastInsertID();
    }

    protected function insertCamionero($id, $licencia)
    {
        $query = $this->conn()->prepare("INSERT INTO `camioneros`(`id`, `licencia`) VALUES (:id, :licencia)");
        $query->bindParam(':id', $id);
        $query->bindParam(':licencia', $licencia);
        if (!$query->execute()) {
            echo json_encode('Error 2: ' . $query->errorInfo());
            exit();
        }
    }

    protected function updateUser($id, $username, $nombre, $apellido, $celular)
    {
        $query = $this->conn()->prepare("UPDATE `usuarios` SET `username`= :username, `nombre`= :nombre, `apellido`=:apellido,`telefono`=:celular WHERE `id`=:id");
        $query->bindParam('id', $id);
        $query->bindParam('username', $username);
        $query->bindParam('nombre', $nombre);
        $query->bindParam('apellido', $apellido);
        $query->bindParam('celular', $celular);

        if (!$query->execute()) {
            echo json_encode('Error: ' . $query->errorInfo());
            exit();
        }
    }

    protected function updateTrucker($id, $licencia)
    {
        $query = $this->conn()->prepare("UPDATE `camioneros` SET `licencia`= :licencia WHERE `id`=:id");
        $query->bindParam('id', $id);
        $query->bindParam('licencia', $licencia);

        if (!$query->execute()) {
            echo json_encode('Error: ' . $query->errorInfo());
            exit();
        }
    }

    

    protected function changePass($pass, $id, $default)
    {
        $query = $this->conn()->prepare("UPDATE `usuarios` SET `pass`= :pass, `pass_deafault`=:passDefault WHERE `id`=:id");
        $query->bindParam('id', $id);
        $hashedPass = password_hash($pass, PASSWORD_BCRYPT);
        $query->bindParam('pass', $hashedPass);
        $query->bindParam('passDefault', $default);

        if (!$query->execute()) {
            echo json_encode('Error: ' . $query->errorInfo());
            exit();
        }
    }
}
