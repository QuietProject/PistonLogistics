<?php
class LoginContr extends Users
{
    private $username;
    private $pwd;

    public function __construct($username, $pwd)
    {
    $this->username = $username;
        $this->pwd = $pwd;
    }

    public function login()
    {
        if ($this->emptyInput()) {
            echo json_encode("Debe completar los campos");
            exit();
        }

        $user = $this->getUserByUsername($this->username);

        if(!$user){
            echo json_encode('Usuario no existe');
            exit();
        } 
        if(!password_verify($this->pwd,$user['pass'])){
            echo json_encode('Contraseña incorrecta');
            exit();
        }
        if($user['rol']!=0){
            echo json_encode('El usuario no tiene los permisos necesarios');
            exit();
        }
        $_SESSION['id']=intval($user['id']);    
        $_SESSION['nombre']=$user['nombre'];
        $_SESSION['apellido']=$user['apellido'];
        $_SESSION['username']=$user['username'];
        $_SESSION['rol']=intval($user['rol']);
        $_SESSION['passDefault']=boolval($user['pass_deafault']);

    }

    private function emptyInput()
    {
        $result = false;
        if (empty($this->username) || empty($this->pwd)) {
            $result = true;
        }
        return $result;
    }
}
