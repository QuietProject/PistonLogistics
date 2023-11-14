<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/styleMenu.css">
    <link rel="stylesheet" href="./css/styleCamionero.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('mapaPlaceholder'), {
                center: {
                    lat: -34.397,
                    lng: 150.644
                },
                zoom: 8
            });

            // var directionsService = new google.maps.DirectionsService();
            // var directionsRenderer = new google.maps.DirectionsRenderer();

            // directionsRenderer.setMap(map);

            // // var waypoints = [{
            // //     location: 'Tacuarembó, Uruguay',
            // //     stopover: true
            // // }, ];

            // var request = {
            //     origin: 'Juan Carlos Gomez 1314, Montevideo, Uruguay',
            //     // waypoints: waypoints,
            //     destination: 'Artigas, Uruguay',
            //     travelMode: 'DRIVING'
            // };

            // directionsService.route(request, function(response, status) {
            //     if (status == 'OK') {
            //         directionsRenderer.setDirections(response);
            //     }
            // });
        }
    </script>

    <title>App para camioneros</title>
</head>

<body>
    <header>
        <div id="logoDiv">
            <img src="./source/logo_invertido.svg" alt="logo" class="" id="logo">
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

    <script defer src="./javascript/scriptMenu.js"></script>
    <script defer src="./javascript/scriptCamionero.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCEVxRt4C_8fqQ7_m80lbPthFaECX-MvJ8&callback=initMap"></script>
    <script defer>
        var lotes = [{
                codigo: '001',
                peso: '10 kg'
            },
            {
                codigo: '002',
                peso: '15 kg'
            },
            {
                codigo: '003',
                peso: '12 kg'
            }, {
                codigo: '001',
                peso: '10 kg'
            },
            {
                codigo: '002',
                peso: '15 kg'
            },
            {
                codigo: '003',
                peso: '12 kg'
            }, {
                codigo: '001',
                peso: '10 kg'
            },
            {
                codigo: '002',
                peso: '15 kg'
            },
            {
                codigo: '003',
                peso: '12 kg'
            }, {
                codigo: '001',
                peso: '10 kg'
            },
            {
                codigo: '002',
                peso: '15 kg'
            },
            {
                codigo: '003',
                peso: '12 kg'
            }, {
                codigo: '001',
                peso: '10 kg'
            },
            {
                codigo: '002',
                peso: '15 kg'
            },
            {
                codigo: '003',
                peso: '12 kg'
            }, {
                codigo: '001',
                peso: '10 kg'
            },
            {
                codigo: '002',
                peso: '15 kg'
            },
            {
                codigo: '003',
                peso: '12 kg'
            },
        ];
    </script>
</body>

</html>
