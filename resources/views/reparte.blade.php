<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/styleMenu.css">
    <link rel="stylesheet" href="./css/styleReparte.css">
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

    <script defer src="./javascript/scriptReparte.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            var lotes = [];
            let puntos = {!! json_encode($puntos) !!}
            let waypoints = [];
            var center;

            // Crear un mapa y establecer el nivel de zoom
            var map = L.map('mapaPlaceholder');
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            var gps = new L.Control.Gps({
                autoCenter: true
            });

            gps.on('gps:located', function(e) {
                center = e.latlng;
                map.setView(center, 20);
                console.log(e.latlng, map.getCenter())
            }).on('gps:disabled', function(e) {
                e.marker.closePopup()
            });

            gps.addTo(map);

            puntos.forEach(punto => {
                let codigo = punto['codigo'];
                let peso = punto['peso'];
                let lat = punto['coordenadas']['lat'];
                let lng = punto['coordenadas']['lng'];
                let markerCoordinates = [lat, lng];
                waypoints.push(L.latLng(markerCoordinates));
                let direccion = punto['direccion'];
                let partes = direccion.split(', ');
                if (partes.length > 2) {
                    direccion = partes.slice(0, 2).join(', ');
                }
                let puntos = document.createElement('div');
                puntos.innerHTML = `<p>${direccion}</p>`;
                rutas.appendChild(puntos);

                lotes.push({
                    codigo: codigo,
                    peso: peso
                });
            });

            var routingControl = L.Routing.control({
                waypoints: waypoints,
                addWaypoints: false,
                collapsed: true
            });

            const verMapa = document.getElementById('verMapa');
            verMapa.addEventListener("click", () => {
                map.whenReady(function() {
                    map.invalidateSize(true);
                });

                map.addControl(routingControl);
            });

            const carga = document.getElementById('carga');
            carga.innerHTML += `<div id='btnVolverCarga'><i class='bx bx-left-arrow-alt'></i></div><h1>Load</h1><table id="miTabla">
                <thead>
                    <tr>
                        <th class="columna" data-columna="codigo">
                            <div>
                                <p>{{ __("Codigo") }}</p>
                            </div>
                        </th>
                        <th class="columna" data-columna="peso">
                            <div>
                                <p>{{ __("Peso") }}</p>
                            </div>
                        </th>
                    </tr> 
                </thead>
                <tbody>
                ${lotes
                    .map(
                        (lote) =>
                            `<tr class="hoverRow">
                            <td data-columna="codigo">${lote["codigo"]}</td>
                            <td data-columna="peso">${lote["peso"]}</td>
                        </tr>`
                    )
                    .join("")}
                    
                </tbody>
            </table>`;
            const btnVolverCarga = document.getElementById('btnVolverCarga');
            btnVolverCarga.addEventListener("click", () => {
                const envio = document.getElementById('envio');
                envio.style.display = "flex";
                carga.style.display = "none";
            });

        });
    </script>

</body>

</html>
