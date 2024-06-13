<?php
class DepotContr extends Depot
{

    public function deleteDepot($id)
    {
        $this->removeDepot($id);
    }

    public function addDepot($nombre, $calle, $numero, $own, $rut)
    {
        $this->validateInputs($nombre, $calle, $numero);
        $id = $this->insertDepot($nombre, $calle, $numero);
        if ($own) {
            $this->insertOwnDepot($id);
        } else {
            $this->insertCustomerDepot($id, $rut);
        }
        return $id;
    }

    private function validateInputs($nombre, $calle, $numero)
    {
        if (empty($nombre) || strlen($nombre) >= 32) {
            echo json_encode('Nombre invalid' . $nombre);
            exit();
        }

        if (empty($calle) || strlen($calle) >= 64) {
            echo json_encode('Calle invalida');
            exit();
        }

        if (empty($numero) || strlen($numero) >= 8) {
            echo json_encode('Nombre invalido');
            exit();
        }
    }



    public function editDepot($nombre, $calle, $numero, $id)
    {
        $this->validateInputs($nombre, $calle, $numero);
        $this->updateDepot($nombre, $calle, $numero,$id);
    }
}
