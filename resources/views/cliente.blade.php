<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/styleCliente.css">
    <title>Cliente</title>
</head>

<body>
    <form class="container" method="POST" enctype="multipart/form-data" action=" {{ route("cliente.scan") }} ">
        @csrf 
        <a class="qrContainer" href="{{ route("scanner") }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" fill="currentColor" class="bi bi-qr-code-scan" viewBox="0 0 16 16">
                <path d="M0 .5A.5.5 0 0 1 .5 0h3a.5.5 0 0 1 0 1H1v2.5a.5.5 0 0 1-1 0v-3Zm12 0a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0V1h-2.5a.5.5 0 0 1-.5-.5ZM.5 12a.5.5 0 0 1 .5.5V15h2.5a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5v-3a.5.5 0 0 1 .5-.5Zm15 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1H15v-2.5a.5.5 0 0 1 .5-.5ZM4 4h1v1H4V4Z"/>
                <path d="M7 2H2v5h5V2ZM3 3h3v3H3V3Zm2 8H4v1h1v-1Z"/>
                <path d="M7 9H2v5h5V9Zm-4 1h3v3H3v-3Zm8-6h1v1h-1V4Z"/>
                <path d="M9 2h5v5H9V2Zm1 1v3h3V3h-3ZM8 8v2h1v1H8v1h2v-2h1v2h1v-1h2v-1h-3V8H8Zm2 2H9V9h1v1Zm4 2h-1v1h-2v1h3v-2Zm-4 2v-1H8v1h2Z"/>
                <path d="M12 9h2V8h-2v1Z"/>
            </svg>
        </a>
        <div class="ticketInfo" id="ticketInfo"></div>
        <input type="text" id="ticketInfoInput" name="ticketInfoInput" hidden>
        <input type="submit" value="Confirm" class="confirmButton" id="confirmButton">
    </form>
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
    <script src="/javascript/scriptCliente.js"></script>
</body>

</html>
