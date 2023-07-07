<?php
session_start();
if (isset($_SESSION['nombre'])) {
    header("Location: ./");
}
?>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesion</title>
</head>

<body>
    <span class="titulo">Iniciar Sesión</span>
    <form id="iniciar">
        <div class="input">
            <label for="usuario">Usuario</label>
            <input type="text" id="usuario" name="usuario" required placeholder=" Ingrese su Usuario">
        </div>
        <div class="input">
            <label for="pwd">Constraseña</label>
            <input type="password" id="pwd" name="pwd" required placeholder=" Ingrese su Contraseña">
        </div>
        <div class="divBoton">
            <button type="submit" name="submit" type="button">Iniciar Sesion</button>
        </div>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <script src="./js/login.js"></script>
    <p>Usuario:usuario Contraseña:default1</p>
</body>

</html>