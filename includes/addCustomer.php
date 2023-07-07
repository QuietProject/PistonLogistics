<?php
session_start();
if (!isset($_SESSION['id'])) {
    exit;
}
if ($_SESSION['passDefault']) {
    exit;
}


require "../classes/Db.classes.php";
require "../classes/Customer.classes.php";
require "../classes/Customer-View.classes.php";
require "../classes/Customer-Contr.classes.php";

$customerView = new CustomersView();
if ($customerView->customerExists($_POST['RUT'])) {
    echo json_encode('Ya existe el RUT');
    exit();
}

$customerContr= new CustomerContr;
$customerContr->addCustomer($_POST['RUT'],$_POST['nombre']);

echo json_encode('success');

