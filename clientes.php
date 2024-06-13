<?php

session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ./iniciarSesion.php");
}
if ($_SESSION['passDefault']) {
    header("Location: ./cambiarContrasena.php");
}

require "./classes/Db.classes.php";
require "./classes/Customer.classes.php";
require "./classes/Customer-view.classes.php";

$customers = new CustomersView();
$customersList = $customers->fetchAllCustomers();

?>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <style> td{text-align: center;}</style>
</head>
<body>
<h1>Piston logistics Backoffice</h1>
<a href="./">volver</a>
<a href="./agregarClientes.php">Agregar Clientes</a>
<table>
    <tr>
        <th>RUT</th>
        <th>Nombre</th>
        <th>Modificar</th>
        <th>Eliminar</th>
       
    </tr>
    <?php
    foreach ($customersList as $customer) {
        //$licencia=$usuario['licencia']=='' ? '-':$usuario['licencia'];
    ?>
        <tr>
            <td><?=$customer['RUT']?></td>
            <td><?=$customer['nombre']?></td>
            <td><a href="./modificarCliente.php?rut=<?=$customer['RUT']?>">Modificar</a></td>
            <td><a href="./includes/deleteCustomer.php?rut=<?=$customer['RUT']?>">Eliminar</a></td>
        <tr>
        <?php
    }
        ?>
</table>
    
</body>

</html>