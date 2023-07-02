<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ./iniciarSesion.php");
}
if ($_SESSION['passDefault']) {
    header("Location: ./cambiarContrasena.php");
}
var_dump($_SESSION)
?>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
</head>

<body>
<h1>Piston logistics Backoffice</h1>
<a href="./usuarios.php">Usuarios</a>
<a href="./includes/logOut.php">Cerrar Sesion</a>
</body>

</html>