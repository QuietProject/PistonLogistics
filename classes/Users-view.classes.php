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

    // public function fetchUser($ci){
    //     return $this->getUser($ci);
    // }

    public function userExists($ci)
    {
        return $this->existsUser($ci);
    }

    public function userExistsName($ci)
    {
        return $this->existsUsername($ci);
    }
}
