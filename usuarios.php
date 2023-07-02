<?php

session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ./iniciarSesion.php");
}
if ($_SESSION['passDefault']) {
    header("Location: ./cambiarContrasena.php");
}

include "./classes/Db.classes.php";
include "./classes/Users.classes.php";
include "./classes/Users-view.classes.php";

$users = new UsersView();
$usersList = $users->fetchAllUsers();

?>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>
<body>
<h1>Piston logistics Backoffice</h1>
<a href="./agregarUsuarios.php">Agregar Usuarios</a>
<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Celular</th>
        <th>Rol</th>
        <th>Modificar</th>
        <th>Eliminar</th>
       
    </tr>
    <?php
    foreach ($usersList as $usuario) {
    ?>
        <tr>
            <?php
            foreach ($usuario as $valor) {
            ?>
                <td><?=$valor?></td>
            <?php
            }
            ?>
            <td><a href="#">Modificar</a></td>
            <td><a href="./includes/deleteUser.php?id=<?=$usuario['id']?>">Eliminar</a></td>
        <tr>
        <?php
    }
        ?>
</table>
    
</body>

</html>