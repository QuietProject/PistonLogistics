<?php
class CustomerContr extends Customer
{

    public function deleteCustomer($rut)
    {
        $this->removeCustomer($rut);
    }

    public function addCustomer($rut, $nombre)
    {
        $this->validateInputs($rut,$nombre);
        $this->insertCustomer($rut,$nombre);
    }

    private function validateInputs($rut, $nombre)
    {
        if (!is_numeric($rut) || strlen($rut)!=12) {
            echo json_encode('Rut invalido');
            exit();
        }
        if (!preg_match('/^[\p{L}\s\'-]{1,32}$/u', $nombre)) {
            echo json_encode('Nombre invalido');
            exit();
        }


    }

    public function editCustomer($oldRut, $rut, $nombre)
    {
        $this->validateInputs($rut,$nombre);

        if($oldRut!=$rut){
            if($this->existsRut($rut)){
                echo json_encode('Ya existe el rut');
                exit();
            }
        }
        $this->updateCustomer($oldRut,$rut,$nombre);
    }

    
}
