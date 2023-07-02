<?php
// session_start();
// if (!isset($_SESSION['ci'])) {
//     header("Location: ../iniciarsesion.php");
// } else if (!isset($_POST['id'])) {
//     header("Location: ../gestionarEquipos.php");
// }

include "../classes/Db.classes.php";
include "../classes/Users.classes.php";
include "../classes/Users-View.classes.php";
include "../classes/Users-Contr.classes.php";

$usersView = new UsersView();
if ($usersView->userExistsName($_POST['usuario'])) {
    echo json_encode('Ya existe el nombre');
    exit();
}

$rol=intval($_POST['rol']);
$licencia=intval($_POST['licencia']);

$usersContr= new UsersContr;
echo json_encode($usersContr->addUser($_POST['usuario'],$_POST['pass'],$_POST['nombre'],$_POST['apellido'],$_POST['celular'],$rol,$licencia));

//print_r($_POST);