<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/styleGeneradorQr.css">
    <link rel="stylesheet" href="./css/styleMenu.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <title>{{ __("Cliente") }}</title>
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
                <div></div>
                <a href="../cliente">{{ __("Carga") }}</a>
                <a href="../crearPaquete">{{ __("Crear Paquete") }}</a>
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
            <h1>{{ __("QR de paquetes") }}</h1>
            <table id="miTabla">
                <thead>
                    <tr>
                        <th class="columna" data-columna="codigo">
                            <div>
                                <p>{{ __("Codigo") }}</p>
                            </div>
                        </th>
                        <th class="columna" data-columna="qr">
                            <div>
                                <p>QR</p>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paquetes as $paquete)
                        <tr class="hoverRow">
                            <td data-columna="codigo">{{ $paquete['codigo'] }}</td>
                            <td class="btnGenerar" id="btnGenerar" data-codigo="{{ $paquete['codigo'] }}">{{ __("Generar") }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </section>



    <script defer src="./javascript/scriptMenu.js"></script>
    <script defer src="./javascript/scriptGeneradorQr.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js" integrity="sha512-CNgIRecGo7nphbeZ04Sc13ka07paqdeTu0WR1IM4kNcpmBAUSHSQX0FslNhTDadL4O5SAGapGt4FodqL8My0mA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>
