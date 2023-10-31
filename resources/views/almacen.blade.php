<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/styleAlmacen.css">
    <link rel="stylesheet" href="./css/styleMenu.css">
    
    <title>App para Almacen</title>
</head>

<body>
    <!-- Ham Menu -->
    <div class="menuIcon" id="menuIcon">
        <div>
            <i class='bx bx-menu' id="menu"></i>
        </div>
    </div>

    <div class="sideMenu" id="sideMenu">
        <div>
            <div>
                <div></div>
                <a href="">Paquetes</a>
                <a href="">Lotes</a>
                <a href="">Crear Lote</a>
            </div>

            <div>
                <a href="">Log Out</a>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="scanContainer">
        <h1><i class='bx bxs-truck'></i>Almacen<i class='bx bxs-truck'></i></h1>
        <img src="../source/logoNegro.svg" alt="Logo" class="containerLogo">
        <a href="../almacenCarga" class="accessButton">Carga</a>
        <a href="../almacenDescarga" class="accessButton">Descarga</a>
    </div>

    <script defer src="./javascript/scriptAlmacen.js"></script>
    <script defer src="./javascript/scriptMenu.js"></script>
</body>

</html>