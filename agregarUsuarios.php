<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ./iniciarSesion.php");
}
if ($_SESSION['passDefault']) {
    header("Location: ./cambiarContrasena.php");
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar usuarios</title>
</head>

<body>
    <a href="./usuarios.php">volver</a>
    <h1>agregar usuarios</h1>

    <form id="agregarUsuarios">
        <div class="input">
            <label for="user">Usuario:</label>
            <input type="text" id="user" required maxlength="20" pattern="^[a-zA-Z0-9_.]+$">
        </div>
        <div class="input">
            <label for="pass">Contraseña: </label>
            <input type="text" id="pass" required maxlength="20" value="Piston.Logistics" pattern="^[a-zA-Z0-9!@#$%^&*()_+,.;]{8,20}$">
        </div>
        <div class="input">
            <label for="nombre">nombre:</label>
            <input type="text" id="nombre" required maxlength="32" pattern="^[\p{Letter}\s'-]{1,32}$">
        </div>
        <div class="input">
            <label for="apellido">apellido:</label>
            <input type="text" id="apellido" required maxlength="32" pattern="^[\p{Letter}\s'-]{1,32}$">
        </div>
        <div class="input">
            <label for="celular">Celular:</label>
            <input type="number" id="celular" required maxlength="9" minlength="4">
        </div>
        <div class="input">
            <label for="rol">Rol: </label>
            <select id="rol">
                <option value="0">Administrador</option>
                <option value="1">Funcionario Almacen</option>
                <option value="2">Camionero</option>
            </select>
        </div>
        <div class="input" id="divLicencia" hidden>
            <label for="licencia">licencia: </label>
            <select id="licencia">
                <option value="0">A/E</option>
                <option value="2">B</option>
                <option value="2">C/F</option>
                <option value="3">D</option>
            </select>
        </div>
        <button type="submit">Agregar</button>
    </form>
</body>
<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
<script src="./js/agregarUsuarios.js"></script>

</html>