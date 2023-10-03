<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ./iniciarSesion.php");
}
if (!$_SESSION['passDefault']) {
    header("Location: ./");
}
?>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar contraseña</title>
</head>

<body>
    <span class="titulo">Cambiar contraseña</span>
    <form id="cambiar">
        <div class="input">
            <label for="pwd">Nueva constraseña</label>
            <input type="password" id="pwd" name="pwd" minlength="8" maxlength="20" pattern="^[a-zA-Z0-9!@#$%^&*()_+,.;]{8,20}$">
        </div>
        <div class="input">
            <label for="pwdRepeat">Repita su constraseña</label>
            <input type="password" id="pwdRepeat" name="pwdRepeat" minlength="8" maxlength="20" pattern="^[a-zA-Z0-9!@#$%^&*()_+,.;]{8,20}$">
        </div>
        <div class="divBoton">
            <button type="submit" name="submit" type="button">Cambiar constraseña</button>
        </div>
        <ul>
    <li>Longitud: Debe tener entre 8 y 20 caracteres.</li>
    <li>Caracteres permitidos: Puede contener letras mayúsculas (A-Z), letras minúsculas (a-z), dígitos numéricos (0-9) y los siguientes caracteres especiales: !@#$%^&*()_+,.;</li>
    <li>Restricciones adicionales: No se permiten espacios en blanco ni otros caracteres especiales que no estén incluidos en la lista mencionada anteriormente.</li>
  </ul>
    </form>
    <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
    <script src="./js/cambiarContrasena.js"></script>
</body>

</html>