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
        <div style="height: 2vh">

        </div>
    </header>

    <!-- Ham Menu -->
    <div class="menuIcon" id="menuIcon" style="color: black">
        <div>
            <i class='bx bx-menu' id="menu"></i>
        </div>
    </div>

    <div class="sideMenu" id="sideMenu">
        <div>
            <div>
                <div></div>
                <h4>Estado</h4>
                <form class="radioBtnEstados" name="estado">
                    <div>
                        <input type="radio" name="estado" id="manejando">
                        <label for="manejando" name="label" class="notChecked">Manejando</label>
                    </div>
                    <div>
                        <input type="radio" name="estado" id="descansando">
                        <label for="descansando" name="label" class="notChecked">Descansando</label>
                    </div>
                    <div>
                        <input type="radio" name="estado" id="fueraDeServicio">
                        <label for="fueraDeServicio" name="label" class="notChecked">Fuera de servicio</label>
                    </div>
                </form>
            </div>
            <div>
                <a href="">Log Out</a>
            </div>
        </div>
    </div>

    <section id="section">

    </section>
    
    <div id="disableDivs">

    </div>

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