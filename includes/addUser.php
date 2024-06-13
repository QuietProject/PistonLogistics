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
require "../classes/Users-Contr.classes.php";

$usersView = new UsersView();
if ($usersView->userExistsName($_POST['usuario'])) {
    echo json_encode('Ya existe el nombre');
    exit();
}

$rol=intval($_POST['rol']);
$licencia=intval($_POST['licencia']);

$usersContr= new UsersContr;
echo json_encode($usersContr->addUser($_POST['usuario'],$_POST['pass'],$_POST['nombre'],$_POST['apellido'],$_POST['celular'],$rol,$licencia));
