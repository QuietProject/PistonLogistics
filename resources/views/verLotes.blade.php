<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/styleVerLotes.css">
    <link rel="stylesheet" href="./css/styleMenu.css">
    <title>Lotes</title>
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
                <a href="../almacenCarga">Carga</a>
                <a href="../almacenDescarga">Descarga</a>
                <a href="../verPaquetes">Paquetes</a>
                <a href="../crearLote">Crear Lote</a>
            </div>

            <div>
                <a href="">Log Out</a>
            </div>
        </div>
    </div>

    <section>
        <div id="all">
            <table id="miTabla">
                <thead>
                    <tr>
                        <th class="columna" data-columna="ID_lote">
                            <div>
                                <p>ID Lote</p>
                            </div>
                        </th>
                        <th class="columna" data-columna="ID_troncal">
                            <div>
                                <p>ID Troncal</p><i class='bx bx-chevron-down'></i>
                            </div>
                        </th>
                        <th class="columna" data-columna="ID_almacen">
                            <div>
                                <p>ID Almacén</p> <i class='bx bx-chevron-down'></i>
                            </div>
                        </th>
                        <th class="columna" data-columna="fecha_creacion">
                            <div>
                                <p>Fecha de Creación</p><i class='bx bx-chevron-down'></i>
                            </div>
                        </th>
                        <th class="columna" data-columna="fecha_pronto">
                            <div>
                                <p>Fecha Pronto</p> <i class='bx bx-chevron-down'></i>
                            </div>
                        </th>
                        <th class="columna" data-columna="fecha_cerrado">
                            <div>
                                <p>Fecha Cerrado</p> <i class='bx bx-chevron-down'></i>
                            </div>
                        </th>
                        <th class="columna" data-columna="tipo">
                            <div>
                                <p>Tipo</p> <i class='bx bx-chevron-down'></i>
                            </div>
                        </th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($lotes as $lote)
                        <tr class="hoverRow">
                            <td data-columna="ID_lote">{{ $lote['ID'] }}</td>
                            <td data-columna="ID_troncal">{{ $lote['ID_troncal'] }}</td>
                            <td data-columna="ID_almacen">{{ $lote['ID_almacen'] }}</td>
                            <td data-columna="fecha_creacion">{{ $lote['fecha_creacion'] }}</td>
                            <td data-columna="fecha_pronto">{{ $lote['fecha_pronto'] }}</td>
                            <td data-columna="fecha_cerrado">{{ $lote['fecha_cerrado'] }}</td>
                            <td data-columna="tipo">{{ $lote['tipo'] ? 'pickup' : 'comun' }}</td>
                            <td class="btnVerPaquetesEnLote" data-route="{{ route('getPaquetesLote') }}" data-idlote="{{ $lote['ID'] }}">Ver paquetes</td>

                        </tr>
                    @endforeach

                </tbody>
            </table>

        </div>
        <div id="paquetes">

        </div>
    </section>

    <script defer src="./javascript/scriptMenu.js"></script>
    <script defer src="./javascript/scriptVerLotes.js"></script>
</body>

</html>
