<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/styleVerPaquetes.css">
    <link rel="stylesheet" href="./css/styleMenu.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>{{ __("Almacen") }}</title>
    <script>
        const ruta = "{{ route('verPaquetes.asignar', ['idPaquete', 'idLote']) }}";
        const idAlmacen = {{ explode('.', session('nombre'))[1] }};

        async function getStatus() {
            try {
                const response = await fetch(`{{ route('getLotes') }}?idAlmacen=${idAlmacen}`);
                const data = await response.json();
                return data;
            } catch (error) {
                console.error('Error al obtener datos:', error);
                return [];
            }
        }

        function getRoute(idPaquete, idLote) {
            let r = ruta;
            r = r.replace("idPaquete", idPaquete);
            r = r.replace("idLote", idLote);
            return r;
        }
    </script>

</head>

<body>
    @if (session('message'))
        <script>
            let message = '{{ __(session("message")) }}';

            let options = {
                icon: 'success',
                allowEnterKey: true,
                customClass: {
                    container: 'popup'
                }
            };

            if (message != '{{ __("Paquete agregado a lote") }}') {
                options.title = message;
                options.icon = 'error';
            } else {
                options.title = message;
            }

            Swal.fire(options).then(() => {
                Swal.fire({
                    title: '{{ __("Cargando...") }}',
                    icon: 'info',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading();
                    }
                });
                window.location.href = "{{ route('clear.message') }}";
            });
        </script>
    @endif


    <!-- Ham Menu -->
    <div class="menuIcon" id="menuIcon">
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
                <a href="../almacenCarga">{{ __("Carga") }}</a>
                <a href="../almacenDescarga">{{ __("Descarga") }}</a>
                <a href="../verLotes">{{ __("Lotes") }}</a>
                <a href="../crearLote">{{ __("Crear Lote") }}</a>
                <a href="../paquetePeso">{{ __("Asignar Peso") }}</a>
                <a href="../entregarPaquete">{{ __("Entregar Paquete") }}</a>
            </div>

            <div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">{{ __("Cerrar sesión") }}</button>
                </form>
            </div>
        </div>
    </div>

    <section>
        <div id="all">
            <h1>{{ __("Paquetes en el almacen") }}</h1>
            <table id="miTabla">
                <thead>
                    <tr>
                        <th class="columna" data-columna="ID_paquete">
                            <div>
                                <p>{{ __("ID Paquete") }}</p>
                            </div>
                        </th>
                        <th class="columna" data-columna="codigo">
                            <div>
                                <p>{{ __("Codigo") }}</p> <i class='bx bx-chevron-down'></i>
                            </div>
                        </th>
                        <th class="columna" data-columna="ID_almacen_cliente">
                            <div>
                                <p>{{ __("ID Almacen Cliente") }}</p><i class='bx bx-chevron-down'></i>
                            </div>
                        </th>
                        <th class="columna" data-columna="fecha_registrado">
                            <div>
                                <p>{{ __("Fecha Registrado") }}</p> <i class='bx bx-chevron-down'></i>
                            </div>
                        </th>
                        <th class="columna" data-columna="ID_pickup">
                            <div>
                                <p>{{ __("ID Pickup") }}</p><i class='bx bx-chevron-down'></i>
                            </div>
                        </th>
                        <th class="columna" data-columna="direccion">
                            <div>
                                <p>{{ __("Dirección") }}</p> <i class='bx bx-chevron-down'></i>
                            </div>
                        </th>
                        <th class="columna" data-columna="peso">
                            <div>
                                <p>{{ __("Peso") }}</p> <i class='bx bx-chevron-down'></i>
                            </div>
                        </th>
                        <th class="columna" data-columna="cedula">
                            <div>
                                <p>{{ __("Cedula") }}</p> <i class='bx bx-chevron-down'></i>
                            </div>
                        </th>
                        <th class="columna" data-columna="mail">
                            <div>
                                <p>{{ __("Email") }}</p> <i class='bx bx-chevron-down'></i>
                            </div>
                        </th>
                        <th class="columna" data-columna="estado">
                            <div>
                                <p>{{ __("Estado") }}</p> <i class='bx bx-chevron-down'></i>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paquetes as $paquete)
                        @if ($paquete['fecha_entregado'] == null)
                            <tr class="hoverRow">
                                <td data-columna="ID">{{ $paquete['ID'] }}</td>
                                <td data-columna="codigo">{{ $paquete['codigo'] }}</td>
                                <td data-columna="ID_almacen_cliente">{{ $paquete['ID_almacen'] }}</td>
                                <td data-columna="fecha_registrado">{{ $paquete['fecha_registrado'] }}</td>
                                <td data-columna="ID_pickup">{{ $paquete['ID_pickup'] }}</td>
                                <td data-columna="direccion">{{ $paquete['direccion'] }}</td>
                                <td data-columna="peso">{{ $paquete['peso'] }}</td>
                                <td data-columna="cedula">{{ $paquete['cedula'] }}</td>
                                <td data-columna="mail">{{ $paquete['mail'] }}</td>
                                <td data-columna="estado">{{ $paquete['estado'] }}</td>
                                <td class="btnAsignar" id="btnAsignar">{{ __("Asignar") }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>

        </div>
        <div id="lotes">

        </div>
    </section>



    <script defer src="./javascript/scriptMenu.js"></script>
    <script defer src="./javascript/scriptVerPaquetes.js"></script>
</body>

</html>
