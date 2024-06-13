<?php

session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ./iniciarSesion.php");
}
if ($_SESSION['passDefault']) {
    header("Location: ./cambiarContrasena.php");
}

require "./classes/Db.classes.php";
require "./classes/Depot.classes.php";
require "./classes/Depot-view.classes.php";

$depots = new DepotView();
$ownDepotsList = $depots->fetchOwnDepots();
$clientDepotList=$depots->fetchClientDepots();
?>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Almacenes</title>
    <style> td{text-align: center;}</style>
</head>
<body>
<h1>Piston logistics Backoffice</h1>
<a href="./">volver</a>
<a href="./agregarAlmacenes.php">Agregar Almacenes</a>
<h2>Almacenes propios</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Calle</th>
        <th>Numero</th>
        <th>Modificar</th>
        <th>Eliminar</th>
       
    </tr>
    <?php
    foreach ($ownDepotsList as $ownDepot) {
    ?>
        <tr>
            <td><?=$ownDepot['id']?></td>
            <td><?=$ownDepot['nombre']?></td>
            <td><?=$ownDepot['calle']?></td>
            <td><?=$ownDepot['numero']?></td>
            <td><a href="./modificarAlmacen.php?id=<?=$ownDepot['id']?>">Modificar</a></td>
            <td><a href="./includes/deleteDepot.php?id=<?=$ownDepot['id']?>">Eliminar</a></td>
        <tr>
        <?php
    }
        ?>
</table>
<h2>Almacenes de clientes</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Calle</th>
        <th>Numero</th>
        <th>Cliente</th>
        <th>Modificar</th>
        <th>Eliminar</th>
       
    </tr>
    <?php
    foreach ($clientDepotList as $clientDepot) {
    ?>
        <tr>
            <td><?=$clientDepot['id']?></td>
            <td><?=$clientDepot['nombre']?></td>
            <td><?=$clientDepot['calle']?></td>
            <td><?=$clientDepot['numero']?></td>
            <td><?=$clientDepot['cliente']?></td>
            <td><a href="./modificarAlmacen.php?id=<?=$clientDepot['id']?>">Modificar</a></td>
            <td><a href="./includes/deleteDepot.php?id=<?=$clientDepot['id']?>">Eliminar</a></td>
        <tr>
        <?php
    }
        ?>
</table>
    
</body>

</html>