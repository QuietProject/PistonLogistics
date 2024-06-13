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
    header("Location: ../almacenes.php");
}

require "../classes/Db.classes.php";
require "../classes/Depot.classes.php";
require "../classes/Depot-View.classes.php";
require "../classes/Depot-Contr.classes.php";

$depotView = new DepotView();

if (!$depotView->depotExists($_GET['id'])) {
    header("Location: ../almacenes.php");
}

$depotContr= new DepotContr;
$depotContr->deleteDepot($_GET['id']);
header("Location: ../almacenes.php");
