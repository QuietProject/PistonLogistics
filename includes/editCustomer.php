<?php
session_start();
if (!isset($_SESSION['id'])) {
    exit;
}
if ($_SESSION['passDefault']) {
    exit;
}

var_dump($_POST);
require "../classes/Db.classes.php";
require "../classes/Customer.classes.php";
require "../classes/Customer-View.classes.php";
require "../classes/Customer-Contr.classes.php";


$customerView = new CustomersView();
if (!$customerView->customerExists($_POST['oldRut'])) {
    echo json_encode('No existe el cliente');
    exit();
}



$customerContr= new CustomerContr();
$customerContr->editCustomer($_POST['oldRut'],$_POST['rut'],$_POST['nombre']);
echo json_encode('succes');
