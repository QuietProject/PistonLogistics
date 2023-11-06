<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/styleAlmacenCarga.css">
    <link rel="stylesheet" href="./css/styleMenu.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Almacen Carga</title>
</head>

<body>
    @if (session('status'))
        <script>
            Swal.fire({
                position: 'top',
                icon: 'success',
                title: '{{ session('status') }}',
                showConfirmButton: false,
                timer: 800
            })
        </script>
    @endif
    
    <form class="container" method="POST" enctype="multipart/form-data" action=" {{ route("almacenCarga.scan") }} ">
        @csrf


        <div class="qrContainer" id="qrContainer">
            <div class="qr" id="qr">
                <img src="./source/qr.svg" alt="QR" id="qrSvg" xmlns="http://www.w3.org/2000/svg">
            </div>

            <input type="submit" value="Confirm" class="confirmButton" id="confirmButton">
        </div>

        <div class="ticketInfo" id="ticketInfo">
            <div>
                <input type="text" id="ticketInfoInput" name="ticketInfoInput" hidden>
            </div>
        </div>




    </form>

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
                <a href="../verPaquetes">Paquetes</a>
                <a href="../verLotes">Lotes</a>
                <a href="../crearLote">Crear Lote</a>
            </div>

            <div>
                <a href="">Log Out</a>
            </div>
        </div>
    </div>

    <script src="./javascript/instascan.min.js"></script>
    <script src="./javascript/scriptAlmacenCarga.js"></script>
    <script defer src="./javascript/scriptMenu.js"></script>
</body>

</html>