<?php
class EditUserContr extends Users
{
    private $id;
    private $username;
    private $nombre;
    private $apellido;
    private $celular;
    private $licencia;
    private $changePass;
    private $pass;

    public function __construct($id, $username, $nombre, $apellido, $celular, $licencia, $changePass, $pass)
    {
        $this->id = $id;
        $this->username = $username;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->celular = $celular;
        $this->licencia = $licencia;
        $this->changePass = $changePass;
        $this->pass = $pass;
    }

    public function editUser()
    {
        $user = $this->getUserById($this->id);

        $this->validateUserInputs($user['username']);

        if ($user['rol'] == 2) {
            $this->validateTruckerInputs();
        }
        if ($this->changePass) {
            $this->validatePassInputs();
        }

        $this->updateUser($this->id, $this->username, $this->nombre, $this->apellido, $this->celular);
        if ($user['rol'] == 2) {
            $this->updateTrucker($this->id,$this->licencia);
        }
        if ($this->changePass) {
            $this->changePass($this->pass,$this->id,1);
        }
    }

    private function validateUserInputs($actualUsername)
    {
        if (!preg_match('/^[a-zA-Z0-9._]{4,20}$/', $this->username)) {
            echo json_encode('Usuario invalido');
            exit();
        }

        if ($actualUsername != $this->username) {
            if ($this->existsUsername($this->username)) {
                echo json_encode('Ya existe el nombre de usuario');
                exit();
            }
        }

        if (!preg_match('/^[\p{L}\s\'-]{1,32}$/u', $this->nombre)) {
            echo json_encode('Nombre invalido');
            exit();
        }
        if (!preg_match('/^[\p{L}\s\'-]{1,32}$/u', $this->apellido)) {
            echo json_encode('Apellido invalido');
            exit();
        }
        if (!preg_match('/^\d{4,9}$/', $this->celular)) {
            echo json_encode('Celular invalido');
            exit();
        }
    }
    private function validateTruckerInputs()
    {
        if (!is_int($this->licencia) && $this->licencia >= 0 && $this->licencia <= 3) {
            echo json_encode('Licencia invalida');
            exit();
        }
    }
    private function validatePassInputs()
    {
        if (!preg_match('/^[a-zA-Z0-9!@#$%^&*()_+,.;]{8,20}$/', $this->pass)) {
            echo json_encode('Contraseña invalida');
            exit();
        }
    }
}
