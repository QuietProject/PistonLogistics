<?php
session_start();
if (!isset($_SESSION['id'])) {
    exit;
}
if ($_SESSION['passDefault']) {
    exit;
}

require "../classes/Db.classes.php";
require "../classes/Users.classes.php";
require "../classes/Users-View.classes.php";
require "../classes/EditUser-Contr.classes.php";

$id=intval($_POST['id']);
$licencia=intval($_POST['licencia']);
$changePass=boolval($_POST['changePass']);

$usersView = new UsersView();
if (!$usersView->userExists($_POST['id'])) {
    echo json_encode('No existe el usuario');
    exit();
}



$EditUserContr= new EditUserContr($id,$_POST['usuario'],$_POST['nombre'],$_POST['apellido'],$_POST['celular'],$licencia,$changePass,$_POST['pass']);
$EditUserContr->editUser();
echo json_encode('succes');
