<?php
class ChangePwdContr extends Users
{

    private $pwd;
    private $pwdRepeat;
    private $ci;

    public function __construct($pwd, $pwdRepeat, $ci)
    {
        $this->pwd = $pwd;
        $this->pwdRepeat = $pwdRepeat;
        $this->ci = $ci;
    }

    public function changePwd()
    {
        if ($this->emptyInput()) {
            $msg="Debe completar los campos";
            echo json_encode($msg);
            exit();
        }

        if(!$this->validPass()){
            echo json_encode('Contraseña invalida');
            exit();
        }

        if ($this->differentPwd()) {
            $msg="Las contraseñas no coinciden ";
            echo json_encode($msg);
            exit();
        }
        $this->changePass($this->pwd,$this->ci);

        $_SESSION['passDefault']=false;
    }

    private function emptyInput()
    {
        $result = false;
        if (empty($this->pwd) || empty($this->pwdRepeat) || empty($this->ci)) {
            $result = true;
        }
        return $result;
    }

    private function differentPwd()
    {
        $result = false;
        if ($this->pwd != $this->pwdRepeat) {
            $result = true;
        }
        return $result;
    }

    private function validPass()
    {
        $result=false;
        if (preg_match('/^[a-zA-Z0-9!@#$%^&*()_+,.;]{8,20}$/', $this->pwd)) {
            $result=true;
        }
        return $result;
    }

}
