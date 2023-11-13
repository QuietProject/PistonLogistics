<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/styleEntregarPaquete.css">
    <link rel="stylesheet" href="./css/styleMenu.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Almacen</title>
    <script>
        // const ruta = "{{ route('entregarPaquete.entregar', ['idPaquete']) }}";
        // const idAlmacen = {{ explode('.', session('nombre'))[1] }};

        // function getRoute(idPaquete, idLote) {
        //     let r = ruta;
        //     r = r.replace("idPaquete", idPaquete);
        //     r = r.replace("idLote", idLote);
        //     return r;
        // }
    </script>

</head>

<body>
    @if (session('message'))
        <script>
            let message = '{{ session('message') }}';

            let options = {
                icon: 'success',
                allowEnterKey: true,
                customClass: {
                    container: 'popup'
                }
            };

            if (message != 'Paquete entregado exitosamente') {
                options.title = message;
                options.icon = 'error';
            } else {
                options.title = message;
            }

            Swal.fire(options).then(() => {
                Swal.fire({
                    title: 'Cargando...',
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
                <div></div>
                <a href="../almacenCarga">Carga</a>
                <a href="../almacenDescarga">Descarga</a>
                <a href="../verLotes">Lotes</a>
                <a href="../verPaquetes">Paquetes</a>
                <a href="../crearLote">Crear Lote</a>
                <a href="../paquetePeso">Asignar Peso</a>
            </div>

            <div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Cerrar sesión</button>
                </form>
            </div>
        </div>
    </div>

    <section>
        <div id="all">
            <table id="miTabla">
                <thead>
                    <tr>
                        <th class="columna" data-columna="cedula">
                            <div>
                                <p>Cedula</p>
                            </div>
                        </th>
                        <th class="columna" data-columna="codigo">
                            <div>
                                <p>Codigo</p> <i class='bx bx-chevron-down'></i>
                            </div>
                        </th>
                        <th class="columna" data-columna="ID_almacen_cliente">
                            <div>
                                <p>ID Almacen Cliente</p><i class='bx bx-chevron-down'></i>
                            </div>
                        </th>
                        <th class="columna" data-columna="fecha_registrado">
                            <div>
                                <p>Fecha Registrado</p> <i class='bx bx-chevron-down'></i>
                            </div>
                        </th>
                        <th class="columna" data-columna="ID_pickup">
                            <div>
                                <p>ID Pickup</p><i class='bx bx-chevron-down'></i>
                            </div>
                        </th>
                        <th class="columna" data-columna="direccion">
                            <div>
                                <p>Dirección</p> <i class='bx bx-chevron-down'></i>
                            </div>
                        </th>
                        <th class="columna" data-columna="peso">
                            <div>
                                <p>Peso</p> <i class='bx bx-chevron-down'></i>
                            </div>
                        </th>
                        <th class="columna" data-columna="mail">
                            <div>
                                <p>Mail</p> <i class='bx bx-chevron-down'></i>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paquetes as $paquete)
                        @if ($paquete['estado'] == 9)
                            <tr class="hoverRow">
                                <td data-columna="cedula">{{ $paquete['cedula'] }}</td>
                                <td data-columna="codigo">{{ $paquete['codigo'] }}</td>
                                <td data-columna="ID_almacen_cliente">{{ $paquete['ID_almacen'] }}</td>
                                <td data-columna="fecha_registrado">{{ $paquete['fecha_registrado'] }}</td>
                                <td data-columna="ID_pickup">{{ $paquete['ID_pickup'] }}</td>
                                <td data-columna="direccion">{{ $paquete['direccion'] }}</td>
                                <td data-columna="peso">{{ $paquete['peso'] }}</td>
                                <td data-columna="mail">{{ $paquete['mail'] }}</td>
                                <td class="btnEntregar" id="btnEntregar" data-route="{{ route('entregarPaquete.entregar', ['id' => $paquete['ID']]) }}">Entregar</td>
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
    <script defer src="./javascript/scriptEntregarPaquete.js"></script>
</body>

</html>
