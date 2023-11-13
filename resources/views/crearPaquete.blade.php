<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/styleCrearPaquete.css">
    <link rel="stylesheet" href="./css/styleMenu.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Cliente</title>
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
                },

            };

            if (!message.startsWith('Paquete creado exitosamente con codigo: ')) {
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

    <form method="POST" action=" {{ route('crearPaquete.store') }} " id="form">
        @csrf
        <div>
            <h1>Crear Paquete</h1>
            <i class='bx bx-package'></i>
        </div>
        <div>
            <div>
                <h3>Cedula</h3>
                <input type="number" name="cedula" id="cedula" placeholder="xxxxxxxx" min="10000000" max="99999999"
                    required>
            </div>
            <div>
                <h3>Mail</h3>
                <input type="email" name="mail" id="mail" placeholder="ejemplo@gmail.com" required>
            </div>

            <div>
                <h3>Ciudad</h3>
                <input type="text" name="ciudad" id="ciudad" placeholder="Ej: Montevideo" required>
            </div>

            <div>
                <h3>Direccion</h3>
                <input type="text" name="direccion" id="direccion" placeholder="Ej: Av. Italia 1405" required>
            </div>

            <div>
                <h3>Tipo de envio</h3>
                <select name="tipo" id="tipo" class="tipo">
                    <option value="" selected disabled></option>
                    <option value="1">Domicilio</option>
                    <option value="0">Pickup</option>
                </select>
            </div>
        </div>
        <div>
            <div>
                <input type="submit" value="Crear" id="btnSubmit">
            </div>
        </div>

    </form>

    <div class="menuIcon" id="menuIcon">
        <div>
            <i class='bx bx-menu' id="menu"></i>
        </div>
    </div>

    <div class="sideMenu" id="sideMenu">
        <div>
            <div>
                <div></div>
                <a href="../cliente">Cargar Paquete</a>
            </div>

            <div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Cerrar sesión</button>
                </form>
            </div>
        </div>
    </div>
    <script src="/javascript/scriptCrearPaquete.js"></script>
    <script defer src="./javascript/scriptMenu.js"></script>
</body>

</html>
