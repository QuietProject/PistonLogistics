<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ./iniciarSesion.php");
}
if ($_SESSION['passDefault']) {
    header("Location: ./cambiarContrasena.php");
}
if (!isset($_GET['id'])) {
    header("Location: ./usuarios.php");
}

require "./classes/Db.classes.php";
require "./classes/Users.classes.php";
require "./classes/Users-View.classes.php";

$usersView = new UsersView();

if (!$usersView->userExists($_GET['id'])) {
    header("Location: ./usuarios.php");
}

$usuario = $usersView->fetchUser($_GET['id']);
$camionero = $usersView->fetchCamionero($_GET['id']);
$hidden = 'hidden';
$selected = array("", "", "", "");

if ($camionero){
    $hidden='';
    $selected[$camionero['licencia']]='selected';
}
?>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar usuarios</title>
</head>

<body>
    <a href="./usuarios.php">volver</a>
    <h1>agregar usuarios</h1>

    <form id="modificarUsuarios">
        <div class="input">
            <label for="user">Usuario:</label>
            <input type="text" id="user" required maxlength="20" pattern="^[a-zA-Z0-9_.]+$" value="<?= $usuario['username'] ?>">
        </div>
        <div class="input">
            <label for="nombre">nombre:</label>
            <input type="text" id="nombre" required maxlength="32" pattern="^[\p{Letter}\s'-]{1,32}$" value="<?= $usuario['nombre'] ?>">
        </div>
        <div class="input">
            <label for="apellido">apellido:</label>
            <input type="text" id="apellido" required maxlength="32" pattern="^[\p{Letter}\s'-]{1,32}$" value="<?= $usuario['apellido'] ?>">
        </div>
        <div class="input">
            <label for="celular">Celular:</label>
            <input type="number" id="celular" required maxlength="9" minlength="4" value="<?= $usuario['telefono'] ?>">
        </div>
        <div class="input" id="divLicencia" <?= $hidden ?>>
            <label for="licencia">licencia: </label>
            <select id="licencia">
                <option value="0" <?= $selected[0] ?>>A/E</option>
                <option value="1" <?= $selected[1] ?>>B</option>
                <option value="2" <?= $selected[2] ?>>C/F</option>
                <option value="3" <?= $selected[3] ?>>D</option>
            </select>
        </div>
        <div class="input">
            <label for="changePass">Cambiar contraseña: </label>
            <input type="checkbox" id="changePass" ">
        </div>
        <div class="input" id="passDiv" hidden>
            <label for="pass">Contraseña: </label>
            <input type="text" id="pass" required maxlength="20" value="Piston.Logistics" pattern="^[a-zA-Z0-9!@#$%^&*()_+,.;]{8,20}$">
        </div>
        <button type="submit">Actualizar</button>
    </form>
</body>
<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
<script src="./js/modificarUsuarios.js"></script>

</html>