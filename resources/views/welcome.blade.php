<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/styleIndex.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Quick Carry</title>
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
        <a href="#home">Home</a>
        <a href="#aboutUs">Sobre Nosotros</a>
    </div>
    <section id="home" class="home">
        <div class="menuRastreo">
            <form class="rastreo" method="GET" action="">
                <div>
                    <h2>¡Rastrea tu paquete!</h2>
                    <i class='bx bxs-truck'></i>
                </div>
                <div>
                    <label for="codPaquete">Codigo del paquete</label>
                    <input id="codPaquete" type="number" required>
                </div>
                <input type="submit" value="Rastrear">
            </form>
        </div>
    </section>
    <section id="aboutUs" class="aboutUs">
        <h3>Sobre Nosotros</h3>
        <div class="texto">
            <p>En Quick Carry, nos dedicamos al transporte de paquetería en distribución nacional. Somos una empresa
                líder en el sector logístico, con una amplia red de plataformas estratégicamente ubicadas en la
                proximidad de las principales ciudades y centros poblados en la casi totalidad de los departamentos.</p>
            <br>
            <p>Contamos con un equipo altamente capacitado de profesionales en logística y transporte que se dedican a
                garantizar la entrega oportuna y segura de cada paquete. Nuestros conductores, administradores y
                personal de atención al cliente están comprometidos con la excelencia en el servicio, brindando una
                experiencia excepcional a nuestros clientes en cada etapa del proceso de transporte.</p>
        </div>
    </section>
    <footer>
        <span>
            © 2023, Quick Carry, Inc.
        </span>
    </footer>

    <script defer src="./javascript/scriptIndex.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"
        integrity="sha512-16esztaSRplJROstbIIdwX3N97V1+pZvV33ABoG1H2OyTttBxEGkTsoIVsiP1iaTtM8b3+hu2kB6pQ4Clr5yug=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
</body>

</html>