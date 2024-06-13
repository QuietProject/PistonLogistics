<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ./iniciarSesion.php");
}
if ($_SESSION['passDefault']) {
    header("Location: ./cambiarContrasena.php");
}
if (!isset($_GET['rut'])) {
    header("Location: ./cliente.php");
}

require "./classes/Db.classes.php";
require "./classes/Customer.classes.php";
require "./classes/Customer-View.classes.php";

$customerView = new CustomersView();

if (!$customerView->customerExists($_GET['rut'])) {
    header("Location: ./clientes.php");
}

$customer = $customerView->fetchCustomer($_GET['rut']);
print_r($customer);
?>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar clientes</title>
</head>

<body>
    <a href="./clientes.php">volver</a>
    <h1>agregar clientes</h1>

    <form id="modificarClientes">
    <div class="input">
            <label for="RUT">RUT:</label>
            <input type="number" id="RUT" required minlength="12" maxlength="12" value="<?=$customer['RUT']?>">
        </div>
        <div class="input">
            <label for="nombre">nombre:</label>
            <input type="text" id="nombre" required maxlength="32" value="<?=$customer['nombre']?>">
        </div>
        <button type="submit">Actualizar</button>
    </form>
</body>
<script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
<script src="./js/modificarClientes.js"></script>

</html>