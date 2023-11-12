<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/styleMenu.css">
    <link rel="stylesheet" href="./css/styleCamionero.css">
    <title>App para camioneros</title>
</head>
<body>
    <header>
        <div id="logoDiv">
            <img src="./source/logoNegro.svg" alt="logo" class="" id="logo">
        </div>
        <div class="">
            <h1>Piston Logistics</h1>
        </div>
        <div>
            <div class="menuIcon" id="menuIcon" style="color: black">
                <div>
                    <i class='bx bx-menu' id="menu"></i>
                </div>
            </div>
        </div>
    </header>

    <!-- Ham Menu -->
    

    <div class="sideMenu" id="sideMenu">
        <div>
            <div>
                
            </div>
            <div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Cerrar sesión</button>
                </form>
            </div>
        </div>
    </div>

    <section id="section">

    </section>
    

    <footer id="footer">
        <div>
            <p>© 2023, Quick Carry, Inc.</p>
            <p>Todos los derechos reservados.</p>
        </div>
    </footer>

    <div id="envioComenzado">
        <div>
            <i class='bx bx-check-circle' ></i>
            <h1>¡Comenzando Envio!</h1>
        </div>
    </div>
    <div id="envioFinalizado">
        <div>
            <i class='bx bx-check-circle' ></i>
            <h1>¡Envio Finalizado Exitosamente!</h1>
        </div>
    </div>

    <script defer src="./javascript/scriptMenu.js"></script>
    <script defer src="./javascript/scriptCamionero.js"></script>
</body>
</html>