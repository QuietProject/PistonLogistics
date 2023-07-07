<?php
class UsersView extends Users
{

    public function fetchAllUsers()
    {
        $users = $this->getAllUsers();
        foreach ($users as $index => $user) {
            switch ($user['rol']) {
                case 0:
                    $users[$index]['rol'] = 'administrador';
                    break;
                case 1:
                    $users[$index]['rol'] = 'almacen';
                    break;
                case 2:
                    $users[$index]['rol'] = 'camionero';
                    break;
            }
        }
        return $users;
    }

    public function fetchUser($id){
        return $this->getUserById($id);
    }

    public function fetchCamionero($id){
        return $this->getCamioneroById($id);
    }

    public function userExists($id)
    {
        return $this->existsUser($id);
    }

    public function userExistsName($id)
    {
        return $this->existsUsername($id);
    }
}
