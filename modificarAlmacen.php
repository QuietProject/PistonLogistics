<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ./iniciarSesion.php");
}
if ($_SESSION['passDefault']) {
    header("Location: ./cambiarContrasena.php");
}
if (!isset($_GET['id'])) {
    header("Location: ./almacenes.php");
}

require "./classes/Db.classes.php";
require "./classes/Depot.classes.php";
require "./classes/Depot-view.classes.php";

$depotView = new DepotView();
if(!$depotView->depotExists($_GET['id'])){
    header("Location: ./almacenes.php");
}
$depot=$depotView->fetchDepot($_GET['id']);
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar almacenes</title>
</head>

<body>
    <a href="./almacenes.php">volver</a>
    <h1>modificar almacenes</h1>

    <form id="modificarAlmacenes">
        <div class="input">
            <label for="nombre">nombre:</label>
            <input type="text" id="nombre" required maxlength="32" value="<?=$depot['nombre']?>">
        </div>
        <div class="input">
            <label for="calle">calle:</label>
            <input type="text" id="calle" required maxlength="64" value="<?=$depot['calle']?>">
        </div>
        <div class="input">
            <label for="numero">numero:</label>
            <input type="text" id="numero" required maxlength="8" value="<?=$depot['numero']?>">
        </div>
        <button type="submit">Actualizar</button>
    </form>
</body>
<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
<script src="./js/modificarAlmacenes.js"></script>

</html>