<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ./iniciarSesion.php");
}
if ($_SESSION['passDefault']) {
    header("Location: ./cambiarContrasena.php");
}
require "./classes/Db.classes.php";
require "./classes/Customer.classes.php";
require "./classes/Customer-view.classes.php";

$customers = new CustomersView();
$hay = $customers->hayCustomers();
$hidden = 'hidden';
$hidden = 'hidden';
$customerList;
if ($hay) {
    $hidden = '';
    $customerList = $customers->fetchAllCustomers();
}
?>


<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar almacenes</title>
</head>

<body>
    <a href="./almacenes.php">volver</a>
    <h1>agregar almacenes</h1>

    <form id="agregarAlmacenes">
        <div class="input">
            <label for="nombre">nombre:</label>
            <input type="text" id="nombre" required maxlength="32">
        </div>
        <div class="input">
            <label for="calle">calle:</label>
            <input type="text" id="calle" required maxlength="64">
        </div>
        <div class="input">
            <label for="numero">numero:</label>
            <input type="text" id="numero" required maxlength="8">
        </div>

        <div class="input">
            <input type="radio" id="own" name="tipo" value="own" checked>
            <label for="own">Propio</label>
        </div>

        <div class="input" <?= $hidden ?>>
            <input type="radio" id="customer" name="tipo" value="customer">
            <label for="customer">Cliente</label>
        </div>



        <div id="customers" hidden>
            <label for="customerList">Cliente: </label>
            <select id="customerList">
                <?php
                foreach($customerList as $customer){
                    ?>
                    <option value="<?=$customer['RUT']?>"><?=$customer['nombre']?></option>
                    <?php
                }
                ?>
            </select>
        </div>

        <button type="submit">Agregar</button>
    </form>
</body>
<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
<script src="./js/agregarAlmacenes.js"></script>

</html>