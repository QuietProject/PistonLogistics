<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/styleAlmacen.css">
    <link rel="stylesheet" href="./css/styleMenu.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>{{ __("Almacen") }}</title>
</head>

<body>
    @if (session('message'))
        <script>
            let message = '{{ __(session('message')) }}';

            let options = {
                icon: 'success',
                allowEnterKey: true,
                customClass: {
                    container: 'popup'
                },

            };

            if (message == {{ __("El almacen no se encuentra en ninguna troncal") }}) {
                options.title = message;
                options.icon = 'error';
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
                <div></div>
                <a href="../almacenCarga">{{ __("Carga") }}</a>
                <a href="../almacenDescarga">{{ __("Descarga") }}</a>
                <a href="../verPaquetes">{{ __("Paquetes") }}</a>
                <a href="../verLotes">{{ __("Lotes") }}</a>
                <a href="../crearLote">{{ __("Crear Lote") }}</a>
                <a href="../paquetePeso">{{ __("Asignar Peso") }}</a>
                <a href="../entregarPaquete">{{ __("Entregar Paquete") }}</a>
            </div>

            <div>
                <form method="POST" action=" {{ route('logout') }} ">
                    @csrf
                    <button type="submit">{{ __("Cerrar sesión") }}</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Container -->
    <div class="scanContainer">
        <h1><i class='bx bxs-truck'></i>{{ __("Almacen") }}<i class='bx bxs-truck'></i></h1>
        <img src="../source/logoNegro.svg" alt="Logo" class="containerLogo">
        <a href="../almacenCarga" class="accessButton">{{ __("Carga") }}</a>
        <a href="../almacenDescarga" class="accessButton">{{ __("Descarga") }}</a>
    </div>

    <script defer src="./javascript/scriptAlmacen.js"></script>
    <script defer src="./javascript/scriptMenu.js"></script>
</body>

</html>
