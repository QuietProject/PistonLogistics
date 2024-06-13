<?php

session_start();
if (!isset($_SESSION['id'])) {
    exit;
}
if ($_SESSION['passDefault']) {
    exit;
}

require "../classes/Db.classes.php";
require "../classes/Depot.classes.php";
require "../classes/Depot-View.classes.php";
require "../classes/Depot-Contr.classes.php";

$id=intval($_POST['id']);

$depotView = new DepotView();
if (!$depotView->depotExists($id)) {
    json_encode('No existe el almacen');
    exit;
}

$depotContr = new DepotContr();
$depotContr->editDepot($_POST['nombre'],$_POST['calle'],$_POST['numero'],$id);
echo json_encode('success');

