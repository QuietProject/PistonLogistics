<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/styleCliente.css">
    <title>Document</title>
</head>

<body>
    <!-- Paquetes -->
    <div class="container" id="ContainerPaquetes" style="display: flex;">
        <table class="tableInfo">
            <tr>
                <th>ID</th>
                <th>Peso</th>
                <th>Destino</th>
                <th>ID Lote</th>
            </tr>
        </table>
    </div>
    <!-- Lotes -->
    <div class="container" id="ContainerLotes" style="display: none;">
        <table class="tableInfo">
            <tr>
                <th>ID</th>
                <th>Estado</th>
                <th>Destino</th>
                <th></th>
            </tr>
        </table>
    </div>
    <!-- Crear Lote -->
    <div class="container" id="ContainerCrearLote" style="display: none;">
        <div class="qrContainer">
            <h1>QR Cam Placeholder</h1>
        </div>
        <div class="ticketInfo">
            <h1>Ticket Info Placeholder</h1>
        </div>
        <input type="button" value="Confirm" class="confirmButton">
    </div>
    <!-- QR Scanner -->
    <div class="container" id="ContainerQrScanner" style="display: none;">
        <div class="qrContainer">
            <h1>QR Cam Placeholder</h1>
        </div>
        <div class="ticketInfo">
            <h1>Ticket Info Placeholder</h1>
        </div>
        <input type="button" value="Confirm" class="confirmButton">
    </div>
    <!-- Ham Menu -->
    </div>
    <div class="hamMenu" id="hamMenu">
        <div class="hamMenuLine" id="hamMenuLine"></div>
        <div class="hamMenuLine" id="hamMenuLine"></div>
        <div class="hamMenuLine" id="hamMenuLine"></div>
    </div>
    <div class="sideMenu" id="sideMenu" style="right: -15vw;">
        <input type="button" id="BtnPaquetes" value="Paquetes" class="itemSideMenu">
        <input type="button" id="BtnLotes" value="Lotes" class="itemSideMenu">
        <input type="button" id="BtnCrearLote" value="Crear Lote" class="itemSideMenu">
        <input type="button" id="BtnQrScanner" value="QR Scanner" class="itemSideMenu">
        <input type="button" id="BtnLogOut" value="Log Out" class="itemSideMenu">
    </div>
</body>

</html>
<script>let str = document.getElementById("sideMenu").style.getPropertyValue('right');</script>
<script src="../javascript/scriptCliente.js"></script>