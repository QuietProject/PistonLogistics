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
    <div class="sideMenu" id="sideMenu" style="right: -20vw; height: 48.1vh;" tabindex="-1">
        <a href="" class="itemSideMenu" tabindex="-1">Carga</a>
        <a href="" class="itemSideMenu" tabindex="-1">Descarga</a>
        <a href="" class="itemSideMenu" tabindex="-1">Paquetes</a>
        <a href="" class="itemSideMenu" tabindex="-1">Lotes</a>
        <a href="" class="itemSideMenu" tabindex="-1">Crear Lotes</a>
        <input type="button" id="BtnLogOut" value="Log Out" class="itemSideMenu" tabindex="-1">
    </div>

    <!-- Main Container -->
    <div class="scanContainer">
        <img src="../source/logoNegro.svg" alt="Logo" class="containerLogo">
        <a href="../views/almacenCarga.blade.php" class="accessButton">Carga</a>
        <a href="../views/almacenDescarga.blade.php" class="accessButton">Descarga</a>
    </div>
</body>

</html>