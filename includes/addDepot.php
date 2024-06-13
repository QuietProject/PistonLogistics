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
require "../classes/Customer.classes.php";
require "../classes/Customer-View.classes.php";

$own =boolval($_POST['own']);

if (!$own) {
    $customerView = new CustomersView();
    if (!$customerView->customerExists($_POST['RUT'])) {
        echo json_encode('No existe el cliente');
        exit();
    }
}

$depotContr = new DepotContr();
echo json_encode($depotContr->addDepot($_POST['nombre'],$_POST['calle'],$_POST['numero'],$own,$_POST['RUT']));
