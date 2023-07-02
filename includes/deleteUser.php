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

if (!$usersView->userExists($_GET['id'])) {
    header("Location: ../");
}

$usersContr= new UsersContr;
$usersContr->deleteUser($_GET['id']);
header("Location: ../");
