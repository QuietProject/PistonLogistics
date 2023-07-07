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
if (!isset($_GET['rut'])) {
    header("Location: ../clientes.php");
}

require "../classes/Db.classes.php";
require "../classes/Customer.classes.php";
require "../classes/Customer-View.classes.php";
require "../classes/Customer-Contr.classes.php";

$customerView = new CustomersView();

if (!$customerView->customerExists($_GET['rut'])) {
    header("Location: ../clientes.php");
}

$customerContr= new CustomerContr;
$customerContr->deleteCustomer($_GET['rut']);
header("Location: ../clientes.php");
