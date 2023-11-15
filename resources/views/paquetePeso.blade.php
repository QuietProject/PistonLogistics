<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/stylePaquetePeso.css">
    <link rel="stylesheet" href="./css/styleMenu.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>{{ __("Almacen") }}</title>
</head>

<body>
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
                <a href="../verPaquetes">{{ __("Paquetes") }}</a>
                <a href="../crearLote">{{ __("Crear Lote") }}</a>
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

            if (message != '{{ __("Peso actualizado exitosamente") }}') {
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

    <form method="POST" action=" {{ route('paquetePeso.asignar') }} " id="form">
        @csrf
        <div>
            <h1>{{ __("Asignar Peso") }}</h1>
            <i class='bx bx-package'></i>
        </div>
        <div>
            <div>
                <h3>{{ __("Paquete") }}</h3>
                <input type="number" name="paquete" id="paquete" min="1"  placeholder="{{ __("Ej: 14") }}" required>
            </div>
            <div>
                <h3>{{ __("Peso") }}</h3>
                <div>
                    <input type="number" name="peso" id="peso" min="0" step="0.01" placeholder="{{ __("Ej: 10") }}" required>
                    <span>Kg</span>
                </div>

            </div>
        </div>
        <div>
            <div>
                <input type="submit" value="Asignar" id="btnSubmit">
            </div>
        </div>

    </form>








    <script defer src="./javascript/scriptMenu.js"></script>
    <script defer src="./javascript/scriptPaquetePeso.js"></script>
</body>

</html>
