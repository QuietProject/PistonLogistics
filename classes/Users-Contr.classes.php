<?php
class UsersContr extends Users
{

    public function deleteUser($id)
    {
        $this->removeUser($id);
    }

    public function addUser($usuario, $pass, $nombre, $apellido, $celular, $rol, $licencia)
    {
        $this->validateInputs($usuario, $pass, $nombre, $apellido, $celular, $rol, $licencia);

        $hashedPass=password_hash($pass,PASSWORD_DEFAULT);
        $insertId = $this->insertUser($usuario, $hashedPass, $nombre, $apellido, $celular, $rol);
        
        if($rol==2){
            $this->insertCamionero($insertId, $licencia);
        }

        return $insertId;
    }

    private function validateInputs($usuario, $pass, $nombre, $apellido, $celular, $rol, $licencia)
    {
        if (!preg_match('/^[a-zA-Z0-9._]{4,20}$/', $usuario)) {
            echo json_encode('Usuario invalido');
            exit();
        }
        if (!preg_match('/^[a-zA-Z0-9!@#$%^&*()_+,.;]{8,20}$/', $pass)) {
            echo json_encode('Contraseña invalida');
            exit();
        }

        if (!preg_match('/^[\p{L}\s\'-]{1,32}$/u', $nombre)) {
            echo json_encode('Nombre invalido');
            exit();
        }
        if (!preg_match('/^[\p{L}\s\'-]{1,32}$/u', $apellido)) {
            echo json_encode('Apellido invalido');
            exit();
        }
        if (!preg_match('/^\d{4,9}$/', $celular)) {
            echo json_encode('Celular invalido');
            exit();
        }
        if (!is_int($rol) && $rol >= 0 && $rol <= 2) {
            echo json_encode('Rol invalido');
            exit();
        }
        if (!is_int($licencia) && $licencia >= 0 && $licencia <= 3) {
            echo json_encode('Licencia invalida');
            exit();
        }
    }

    
}
