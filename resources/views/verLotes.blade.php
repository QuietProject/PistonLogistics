<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/styleVerLotes.css">
    <link rel="stylesheet" href="./css/styleMenu.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <title>{{ __("Almacen") }}</title>
    <script>
        const ruta = "{{ route('quitarPaquete', ['idLote' => 'valorLote', 'idPaquete' => 'valorPaquete']) }}";

        function getRoute(idLote, idPaquete) {
            let r = ruta;
            r = r.replace("valorPaquete", idPaquete);
            r = r.replace("valorLote", idLote);
            return r;
        }
    </script>
</head>

<body>

    @if (session('message'))
        <script>
            let message = '{{ __(session('message')) }}';

            let options = {
                icon: 'success',
                allowEnterKey: true,
                customClass: {
                    container: 'popup',
                    confirmButton: 'confirmButton'
                }
            };

            if (message === '{{ __("Lote listo para enviar") }}') {
                options.title = message;
            } else if (message === '{{ __("Paquete quitado del lote") }}') {
                options.title = message;
            } else {
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
            <h1>{{ __("Lotes en el almacen") }}</h1>
            <table id="miTabla">
                <thead>
                    <tr>
                        <th class="columna" data-columna="ID_lote">
                            <div>
                                <p>{{ __("ID Lote") }}</p>
                            </div>
                        </th>
                        <th class="columna" data-columna="codigo">
                            <div>
                                <p>{{ __("Codigo") }}</p><i class='bx bx-chevron-down'></i>
                            </div>
                        </th>
                        <th class="columna" data-columna="ID_troncal">
                            <div>
                                <p>{{ __("ID Troncal") }}</p><i class='bx bx-chevron-down'></i>
                            </div>
                        </th>
                        <th class="columna" data-columna="fecha_creacion">
                            <div>
                                <p>{{ __("Fecha de Creación") }}</p><i class='bx bx-chevron-down'></i>
                            </div>
                        </th>
                        <th class="columna" data-columna="fecha_pronto">
                            <div>
                                <p>{{ __("Fecha Pronto") }}</p> <i class='bx bx-chevron-down'></i>
                            </div>
                        </th>
                        <th class="columna" data-columna="tipo">
                            <div>
                                <p>{{ __("Tipo") }}</p> <i class='bx bx-chevron-down'></i>
                            </div>
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($lotes as $lote)
                        <tr class="hoverRow">
                            <td data-columna="ID_lote">{{ $lote['ID'] }}</td>
                            <td data-columna="codigo">{{ $lote['codigo'] }}</td>
                            <td data-columna="ID_troncal">{{ $lote['ID_troncal'] }}</td>
                            <td data-columna="fecha_creacion">{{ $lote['fecha_creacion'] }}</td>
                            @if ($lote['fecha_pronto'] === null)
                                <td class='btnPronto'
                                    data-route="{{ route('lotePronto', ['idLote' => $lote['ID']]) }}">
                                    {{ __("Aprontar") }}</td>
                            @else
                                <td data-columna="fecha_pronto">{{ $lote['fecha_pronto'] }}</td>
                            @endif
                            <td data-columna="tipo">{{ $lote['tipo'] ? 'pickup' : 'comun' }}</td>
                            <td class="btnVerPaquetesEnLote" data-route="{{ route('getPaquetesLote') }}" data-idlote="{{ $lote['ID'] }}">{{ __("Ver paquetes") }}</td>
                            <td class="btnGenerar" id="btnGenerar" data-codigo="{{ $lote['codigo'] }}">QR</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>

        </div>
        <div id="paquetes">

        </div>
    </section>

    <script defer src="./javascript/scriptMenu.js"></script>
    <script defer type="module" src="./javascript/scriptVerLotes.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js" integrity="sha512-CNgIRecGo7nphbeZ04Sc13ka07paqdeTu0WR1IM4kNcpmBAUSHSQX0FslNhTDadL4O5SAGapGt4FodqL8My0mA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>
