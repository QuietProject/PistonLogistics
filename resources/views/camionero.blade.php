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
    <script defer>
        let almacen = {!! json_encode($almacen) !!};

        var almacenOrigen = almacen[0];
        var almacenDestino = almacen[1];

        let cargar = {!! json_encode($cargar) !!};
        let descargar = {!! json_encode($descargar) !!};

        let lotesCarga = cargar.map(function(lote) {
            lote.operacion = '{{ __('Cargar') }}';
            return lote;
        });

        let lotesDescarga = descargar.map(function(lote) {
            lote.operacion = '{{ __('Descargar') }}';
            return lote;
        });

        var lotes = lotesCarga.concat(lotesDescarga);

    </script>
    <script defer src="./javascript/scriptCamionero.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let coordenadas = {!! json_encode($coordenadas) !!};

            var marker1Coordinates = [coordenadas[0]['lat'], coordenadas[0]['lng']];
            var marker2Coordinates = [coordenadas[1]['lat'], coordenadas[1]['lng']];
            var center = marker1Coordinates;


            // Crear un mapa y establecer el nivel de zoom
            var map = L.map('mapaPlaceholder').setView(center, 20);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);
            // var locate = L.control.locate().addTo(map);

            var routingControl = L.Routing.control({
                waypoints: [
                    L.latLng(marker1Coordinates),
                    L.latLng(marker2Coordinates)
                ],
                addWaypoints: false,
                collapsed: true
            })
            var gps = new L.Control.Gps({
                //autoActive:true,
                autoCenter: true
            }); //inizialize control

            gps.on('gps:located', function(e) {
                    //	e.marker.bindPopup(e.latlng.toString()).openPopup()
                    console.log(e.latlng, map.getCenter())
                })
                .on('gps:disabled', function(e) {
                    e.marker.closePopup()
                });

            gps.addTo(map);

            const verMapa = document.getElementById('verMapa');
            verMapa.addEventListener("click", () => {
                map.whenReady(function() {
                    map.invalidateSize(
                        true
                    );
                });

                map.addControl(routingControl);
            });
        });
    </script>
</body>

</html>
