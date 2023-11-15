<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/styleMenu.css">
    <link rel="stylesheet" href="./css/styleTrae.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <link rel="stylesheet" href="./css/leaflet-gps.css">

    <script defer src="./javascript/leaflet-gps.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script defer src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Camioneros</title>
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
                <div>
                    <a class="cambioIdioma" href="{{ route('locale', app()->getLocale() == 'es' ? 'en' : 'es') }}">
                        <h2>{{ app()->getLocale() == 'es' ? 'en' : 'es' }}</h2>
                    </a>
                </div>
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
    
    <script defer src="./javascript/scriptTrae.js"></script>


    <script>
        let destino = {!! json_encode($destino) !!};
        let waypointDestino = destino['lat'] + ", " + destino['lng'];
        var almacen = destino['direccion'];
    
        document.addEventListener('DOMContentLoaded', () => {
    
            // Obtener ubicación actual del GPS
            navigator.geolocation.getCurrentPosition((position) => {
                let latlng = L.latLng(position.coords.latitude, position.coords.longitude);
    
                // Crear un mapa y centrarlo en la ubicación actual del GPS
                var map = L.map('mapaPlaceholder').setView(latlng, 20);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);
    
                var routingControl = L.Routing.control({
                    waypoints: [latlng, L.latLng(destino['lat'], destino['lng'])], // Ubicación actual del GPS y destino
                    addWaypoints: false,
                    collapsed: true
                });
    
                var gps = new L.Control.Gps({
                    autoCenter: true
                });
    
                gps.on('gps:located', function(e) {
                    console.log(e.latlng, map.getCenter())
                }).on('gps:disabled', function(e) {
                    e.marker.closePopup()
                });
    
                gps.addTo(map);
    
                const verMapa = document.getElementById('verMapa');
                verMapa.addEventListener("click", () => {
                    map.whenReady(function() {
                        map.invalidateSize(true);
                    });
    
                    map.addControl(routingControl);
                });
            });
        });
    </script>
    
    
    
</body>

</html>
