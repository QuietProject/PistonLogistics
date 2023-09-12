<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/styleAlmacen.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"
        integrity="sha512-16esztaSRplJROstbIIdwX3N97V1+pZvV33ABoG1H2OyTttBxEGkTsoIVsiP1iaTtM8b3+hu2kB6pQ4Clr5yug=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script defer src="../JavaScript/scriptAlmacen.js"></script>
    <title>App para Almacen</title>
</head>

<body>
    <!-- Ham Menu -->
    <div class="hamMenu" id="hamMenu">
        <i class='bx bx-menu' id="menu"></i>
    </div>
    <div class="sideMenu" id="sideMenu" style="right: -15vw;">
        <input type="button" id="BtnLogOut" value="Log Out" class="itemSideMenu">
    </div>

    <div class="mainScreen" id="mainScreen">
        <div class="logo">
            <img src="../Source/logo.png">
        </div>
        <div class="opciones">
            <div class="descarga" id="descarga">
                <h1>Descarga</h1>
            </div>
            <div class="carga" id="carga">
                <h1>Carga</h1>
            </div>
        </div>

    </div>

    <div class="containerDescarga" id="containerDescarga">
        <div class="btnBack" id="btnBackDescarga"><i class='bx bx-left-arrow-alt'></i></div>
        <h1>Descarga</h1>
        <div class="qr">
            <h2>QR Cam Placeholder</h2>
        </div>
        <div class="ticketInfo">
            <h2>Ticket Info Placeholder</h2>
        </div>
        <div class="btnSubmit">Confirm</div>
    </div>

    <div class="containerCarga" id="containerCarga">
        <div class="btnBack" id="btnBackCarga"><i class='bx bx-left-arrow-alt'></i></div>
        <h1>Carga</h1>
        <div class="qr">
            <h2>QR Cam Placeholder</h2>
        </div>
        <div class="ticketInfo">
            <h2>Ticket Info Placeholder</h2>
        </div>
        <div class="btnSubmit">
            <h3>Confirm</h3>
        </div>
    </div>
</body>

</html>