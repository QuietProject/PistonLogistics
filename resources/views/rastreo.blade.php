<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/styleRastreo.css">
    <link rel="stylesheet" href="./css/styleMenu.css">
    <link rel="stylesheet" href="./css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Quick Carry</title>
</head>
<body>
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
                <div></div>
                <a href="#home" id="homeLink">{{ __("Inicio") }}</a>
                <a href="#aboutUs" id="aboutUsLink">{{ __("Sobre Nosotros") }}</a>
                <a href="#preguntas" id="preguntasLink">{{ __("Preguntas Frecuentes") }}</a>
            </div>
        </div>
    </div>


    <section>
        <div>
            <h1>{{ __("Detalles del paquete") }}</h1>
            <div>
                <p>{{ __("Codigo") }}: </p>
                <p>
                    {{ session("codigoPaquete") }}
                </p>
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
                    <input type="submit" value="{{ __("Enviar") }}">
                </div>

            </form>
        </div>

        <div>
            <p>© 2023, Quick Carry, Inc.</p>
            <p>{{ __("Todos los derechos reservados") }}.</p>
        </div>

        <div>

        </div>
    </footer>

    <script>

    </script>
    <script defer src="./javascript/scriptMenu.js"></script>
    <script defer src="./javascript/scriptRastreo.js"></script>
</body>
</html>
