<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Surno">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/styleIndex.css">
    <link rel="stylesheet" href="./css/styleMenu.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Quick Carry</title>
</head>

<body>
    <div class="all" id="all">
        <header>
            <div>
                <img src="./source/logoNegro.svg" alt="logo" class="" id="logo">
            </div>
            <div class="">
                <h1>Quick Carry</h1>
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
                    <div>
                        <a class="cambioIdioma" href="{{ route('locale', app()->getLocale() == 'es' ? 'en' : 'es') }}">
                            <h2>{{ app()->getLocale() == 'es' ? 'en' : 'es' }}</h2>
                        </a>
                    </div>
                    <a href="#home" id="homeLink">{{ __("Inicio") }}</a>
                    <a href="#aboutUs" id="aboutUsLink">{{ __("Sobre Nosotros") }}</a>
                    <a href="#preguntas" id="preguntasLink">{{ __("Preguntas Frecuentes") }}</a>
                </div>
                <div>
                    <form action="{{ route('login') }}">
                        @csrf
                        <button type="submit">{{ __("Iniciar Sesion") }}</button>
                    </form>
                </div>
            </div>
        </div>
        <section id="home" class="home">
            <div class="menuRastreo">
                <form class="rastreo" method="POST" action="{{ route('rastreo') }}">
                    @csrf
                    <div>
                        <i class='bx bxs-truck'></i>
                        <h2>{{ __("¡Rastrea tu paquete!") }}</h2>
                        <i class='bx bxs-truck'></i>
                    </div>
                    <div>
                        <label for="codPaquete">{{ __("Codigo del paquete") }}</label>
                        <input id="codPaquete" type="text" maxlength="8" minlength="8" name="codigoPaquete" required>
                    </div>
                    <input type="submit" value="{{ __("Rastrear") }}">
                </form>
            </div>
        </section>
        <section id="aboutUs" class="aboutUs">
            <h3 class="animar sobreNosotros">{{ __("Sobre Nosotros") }}</h3>
            <div class="textoAbout">
                <p class="animar">{{ __("En Quick Carry, nos dedicamos al transporte de paquetería en distribución nacional. Somos una empresa líder en el sector logístico, con una amplia red de plataformas estratégicamente ubicadas en la proximidad de las principales ciudades y centros poblados en la casi totalidad de los departamentos.") }}
                </p>
                <br>
                <p class="animar">{{ __("Contamos con un equipo altamente capacitado de profesionales en logística y transporte que se dedican a garantizar la entrega oportuna y segura de cada paquete. Nuestros conductores administradores y personal de atención al cliente están comprometidos con la excelencia en el servicio, brindando una experiencia excepcional a nuestros clientes en cada etapa del proceso de transporte.") }}</p>
            </div>
            <div style="width: 100%;display: flex; justify-content:center; align-items:end; height:20vh" id="preguntas">
                <h3 class="animar preguntas">{{ __("Preguntas Frecuentes") }}</h3>
            </div>
            <div class="textoPreguntas">
                <div class="animar">
                    <h3>{{ __("¿Cuál es el alcance geográfico de sus servicios de logística y transporte?") }}</h3>
                    <p>{{ __("Ofrecemos servicios de logística y transporte en todo Uruguay, cubriendo todo el país de manera
                        eficiente.") }}</p>
                </div>
                <div class="animar">
                    <h3>{{ __("¿Cuáles son sus tiempos de entrega estándar?") }}</h3>
                    <p>{{ __("Nuestros tiempos de entrega están diseñados para ser rápidos, de acuerdo a nuestra filosofía de
                        servicio.") }}</p>
                </div>
                <div class="animar">
                    <h3>{{ __("¿Ofrecen servicios de seguimiento en tiempo real para los envíos?") }}</h3>
                    <p>{{ __("Ofrecemos servicios de seguimiento en tiempo real para que los clientes puedan rastrear sus
                        envíos desde el punto de recogida hasta su destino final.") }}</p>
                </div>
                <div class="animar">
                    <h3>{{ __("¿Cómo manejan situaciones de pérdida o daño de mercancía durante el transporte?") }}</h3>
                    <p>{{ __("En caso de pérdida o daño de mercancía, tenemos políticas claras de indemnización y trabajamos
                        para resolver cualquier problema de manera rápida y justa.") }}</p>
                </div>
                <div class="animar">
                    <h3>{{ __("¿Cuáles son sus políticas de facturación y tarifas?") }}</h3>
                    <p>{{ __("Nuestras políticas de facturación son transparentes y nuestras tarifas son competitivas,
                        adaptadas a las necesidades de cada cliente.") }}</p>
                </div>
                <div class="animar">
                    <h3>{{ __("¿Qué medidas de seguridad implementan para proteger los envíos?") }}</h3>
                    <p>{{ __("Implementamos estrictas medidas de seguridad para proteger los envíos, desde el manejo seguro de
                        la mercancía hasta la seguridad en nuestras instalaciones y durante el transporte.") }}</p>
                </div>
            </div>
        </section>
        <footer id="footer">
            <div>
                <form action="">
                    <h1>{{ __("¡Contáctenos!") }}</h1>
                    <input type="text" placeholder="{{ __("Nombre") }}">
                    <input type="email" name="" id="" placeholder="{{ __("Correo Electrónico") }}">
                    <textarea name="" id="" cols="30" rows="10" placeholder="{{ __("Mensaje") }}"></textarea>
                    <div>
                        <input type="submit" value="Enviar">
                    </div>

                </form>
            </div>

            <div>
                <p>© 2023, Quick Carry, Inc.</p>
                <p>{{ __("Todos los derechos reservados.") }}</p>
            </div>

            <div>

            </div>
        </footer>
    </div>

    <div class="animacionInicio" id="animacionInicio">
        <div class="divInicio" id="divInicio">
            <h1>{{ __("¡Quick Carry!") }}</h1>
            <img src="./source/logoNegro.svg" alt="logo" class="" id="logo">
            <h1>{{ __("Tu Solución de Transporte") }}</h1>
        </div>
    </div>

    <script defer src="./javascript/scriptIndex.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script defer src="./javascript/scriptMenu.js"></script>
</body>

</html>
