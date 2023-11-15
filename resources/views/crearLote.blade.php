<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/styleCrearLote.css">
    <link rel="stylesheet" href="./css/styleMenu.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>{{ __("Almacen") }}</title>



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
                },

            };

            if (message != '{{ __("Lote creado exitosamente") }}') {
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
                <a href="../verPaquetes">{{ __("Paquetes") }}</a>
                <a href="../verLotes">{{ __("Lotes") }}</a>
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

    <form class="formulario" method="POST" action=" {{ route("crearLote.store") }} " id="form">
        @csrf
        <h1>{{ __("Crear Lote") }}</h1>
        <div>
            <h2>{{ __("ID Almacen") }}</h2>
            <input type="text" id="almacenOrigen" value="" disabled>
            <h2>{{ __("Tipo") }}</h2>
            <select name="tipo" id="tipo" required>
                <option value="" disabled selected></option>
                <option value="0">{{ __("Comun") }}</option>
                <option value="1">{{ __("Pickup") }}</option>
            </select>

            <h2 id="almacenDestinoTitulo">{{ __("Almacen Destino") }}</h2>
            <select name="orden" id="orden" required>
                <option value="" selected disabled></option>
                @foreach ($ordenes as $orden)
                    <option value=" {{ $orden['ID_almacen'] }},{{ $orden['ID_troncal'] }} ">{{ $orden['nombre_almacen'] }} - {{ $orden['nombre_troncal'] }}</option>
                @endforeach
            </select>

            <h2 id="linea"></h2>
        </div>
        <div>
            <input type="submit" id="btnSubmit" value="{{ __("Crear") }}">
        </div>

    </form>



    <script defer src="./javascript/scriptMenu.js"></script>
    <script defer src="./javascript/scriptCrearLote.js"></script>
    <script>
        const idAlmacen = {{ explode('.', session('nombre'))[1] }};
        document.getElementById('almacenOrigen').value = idAlmacen;
    </script>

</body>

</html>
