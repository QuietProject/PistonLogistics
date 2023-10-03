<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ./iniciarSesion.php");
}
if ($_SESSION['passDefault']) {
    header("Location: ./cambiarContrasena.php");
}
?>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar clientes</title>
</head>

<body>
    <a href="./clientes.php">volver</a>
    <h1>agregar clientes</h1>

    <form id="agregarClientes">
        <div class="input">
            <label for="RUT">RUT:</label>
            <input type="number" id="RUT" required minlength="12" maxlength="12">
        </div>
        <div class="input">
            <label for="nombre">nombre:</label>
            <input type="text" id="nombre" required maxlength="32">
        </div>
        <button type="submit">Agregar</button>
    </form>
</body>
<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
<script src="./js/agregarClientes.js"></script>

</html>