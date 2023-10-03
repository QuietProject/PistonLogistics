<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ./iniciarSesion.php");
    exit;
}
if ($_SESSION['passDefault']) {
    header("Location: ./cambiarContrasena.php");
    exit;
}
if (!isset($_GET['id'])) {
    header("Location: ../usuarios.php");
}

require "../classes/Db.classes.php";
require "../classes/Users.classes.php";
require "../classes/Users-View.classes.php";
require "../classes/Users-Contr.classes.php";

$usersView = new UsersView();

if (!$usersView->userExists($_GET['id'])) {
    header("Location: ../usuarios.php");
}

$usersContr= new UsersContr;
$usersContr->deleteUser($_GET['id']);
header("Location: ../usuarios.php");
