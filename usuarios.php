<?php

session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ./iniciarSesion.php");
}
if ($_SESSION['passDefault']) {
    header("Location: ./cambiarContrasena.php");
}

require "./classes/Db.classes.php";
require "./classes/Users.classes.php";
require "./classes/Users-view.classes.php";

$users = new UsersView();
$usersList = $users->fetchAllUsers();

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
<a href="./agregarUsuarios.php">Agregar Usuarios</a>
<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Celular</th>
        <th>Rol</th>
        <th>Licencia</th>
        <th>Modificar</th>
        <th>Eliminar</th>
       
    </tr>
    <?php
    foreach ($usersList as $usuario) {
    ?>
        <tr>
            <td><?=$usuario['id']?></td>
            <td><?=$usuario['username']?></td>
            <td><?=$usuario['nombre']?></td>
            <td><?=$usuario['apellido']?></td>
            <td><?=$usuario['telefono']?></td>
            <td><?=$usuario['rol']?></td>
            <td><?=$usuario['licencia']=='' ? '-':$usuario['licencia']?></td>
            <td><a href="./modificarUsuario.php?id=<?=$usuario['id']?>">Modificar</a></td>
            <td><a href="./includes/deleteUser.php?id=<?=$usuario['id']?>">Eliminar</a></td>
        <tr>
        <?php
    }
        ?>
</table>
    
</body>

</html>