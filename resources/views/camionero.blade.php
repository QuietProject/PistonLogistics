<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/styleCamionero.css">
    <title>App para camioneros</title>
</head>
<body>
    <header>
        <div>
            <img src="./source/logoNegro.svg" alt="logo" class="" id="logo">
        </div>
        <div class="">
            <h1>Piston Logistics</h1>
        </div>
        <div class="">
            <i class='bx bx-menu' id="menu"></i> 
        </div>
    </header>
    <div class="sidebar" id="sidebar">
        <div>
            <i class='bx bx-x' id="closeMenu"></i> 
        </div>
            <div class="estado">
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
    </div>

    <section id="section">
        <div>Placeholder</div>
        <div>Placeholder</div>
        <div>Placeholder</div>
        <div>Placeholder</div>
        <div>Placeholder</div>
        <div>Placeholder</div>
        <div>Placeholder</div>
        <div>Placeholder</div>
    </section>
    <div id="blank" style="height: 10vh">

    </div>
    <footer id="footer">
        <div>
            © 2023, Quick Carry, Inc.
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js" integrity="sha512-16esztaSRplJROstbIIdwX3N97V1+pZvV33ABoG1H2OyTttBxEGkTsoIVsiP1iaTtM8b3+hu2kB6pQ4Clr5yug==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script defer src="../JavaScript/scriptCamionero.js"></script>
</body>
</html>