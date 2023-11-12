<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/styleAlmacenDescarga.css">
    <link rel="stylesheet" href="./css/styleMenu.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Almacen</title>
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

            if (message != 'Paquete(s) descargado(s) exitosamente - Lote(s) descargado(s) y paquete(s) asignado(s) exitosamente') {
                options.title = message;
                options.icon = 'error';
            } else if(message != 'Paquete(s) descargado(s) exitosamente'){
                options.title = message;
                options.icon = 'error';
            }else if(message != 'Lote(s) descargado(s) y paquete(s) asignado(s) exitosamente'){
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

    <div class="change" id="btnChange">
        Ingresar codigo a mano
    </div>
    <div class="change" id="btnChangeQR" style="display: none">
        Ingresar codigo con QR
    </div>



    <div class="container">

        <div class="qr" id="qr">
            <img src="./source/qr.svg" alt="QR" id="qrSvg" xmlns="http://www.w3.org/2000/svg">
        </div>
        <div class="codigoContainer" style="display: none">

            <div>
                <h1>Ingresar paquete/lote</h1>
                <div>
                    <div>
                        <h3>Codigo</h3>
                        <input type="text" id="codigo">
                    </div>
                    <div>
                        <i class='bx bxs-chevron-right' id="moverPaquete"></i>
                    </div>
                </div>
            </div>

        </div>


        <div class="infoContainer">
            <div class="titulo">
                <p>Descarga</p>
            </div>
            <div class="infoLotePaquete">
                <div class="infoPaquete" style="display:none">
                    <h1>Paquetes</h1>
                    <table id="miTabla">
                        <thead>
                            <tr>
                                <th class="columna" data-columna="ID_paquete">
                                    <div>
                                        <p>ID Paquete</p>
                                    </div>
                                </th>
                                <th class="columna" data-columna="codigo">
                                    <div>
                                        <p>Codigo</p><i class='bx bx-chevron-down'></i>
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
                                <th class="columna" data-columna="cedula">
                                    <div>
                                        <p>Cedula</p> <i class='bx bx-chevron-down'></i>
                                    </div>
                                </th>
                                <th class="columna" data-columna="mail">
                                    <div>
                                        <p>Mail</p> <i class='bx bx-chevron-down'></i>
                                    </div>
                                </th>
                                <th class="columna" data-columna="estado">
                                    <div>
                                        <p>Estado</p> <i class='bx bx-chevron-down'></i>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="paquetesTabla">
                        </tbody>
                    </table>
                </div>

                <div class="infoLote" style="display:none">
                    <h1>Lotes</h1>
                    <table id="miTabla">
                        <thead>
                            <tr>
                                <th class="columna" data-columna="ID_lote">
                                    <div>
                                        <p>ID Lote</p>
                                    </div>
                                </th>
                                <th class="columna" data-columna="codigo">
                                    <div>
                                        <p>Codigo</p><i class='bx bx-chevron-down'></i>
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

                            </tr>
                        </thead>
                        <tbody id="lotesTabla">
                        </tbody>
                    </table>
                </div>
            </div>



            <div class="send">
                @csrf
                <input type="submit" value="Confirmar" id="btnSubmit">
            </div>
        </div>
    </div>



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
                <a href="../verPaquetes">Paquetes</a>
                <a href="../verLotes">Lotes</a>
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

    <script src="./javascript/instascan.min.js"></script>
    <script src="./javascript/scriptAlmacenDescarga.js"></script>
    <script defer src="./javascript/scriptMenu.js"></script>
    <script>
        const moverPaquete = document.getElementById("moverPaquete");
        const codigo = document.getElementById("codigo");
        const rutaBase = "{{ route('getPaqueteOrLoteCodigo') }}";
        const paquetesTabla = document.getElementById("paquetesTabla");
        const lotesTabla = document.getElementById("lotesTabla");
        const infoPaquete = document.querySelector(".infoPaquete");
        const infoLote = document.querySelector(".infoLote");
        const btnSubmbit = document.getElementById("btnSubmit");



        const arrayPaquetes = [];
        const arrayLotes = [];
        const arrayCodigos = [];
        let miString = "";


        moverPaquete.addEventListener("click", () => {
            keyPressed();

        });
        codigo.addEventListener("keydown", (event) => {
            if (event.keyCode === 13) {
                keyPressed();
            }
        });

        function keyPressed() {

            let cod = codigo.value;

            const ruta = `${rutaBase}?codigo=${cod}`;

            fetch(ruta, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {

                    if (arrayCodigos.includes(cod)) {
                        data.data = null;
                    } else {
                        arrayCodigos.push(cod);
                        console.log(arrayCodigos);
                    }

                    const tr = document.createElement('tr');

                    if (data.data) {
                        const valoresData = Object.values(data.data);

                        if (cod.startsWith("L")) {

                            let id = valoresData[0];
                            let codigo = valoresData[1];
                            let idTroncal = valoresData[2];
                            let idAlmacen = valoresData[3];
                            let fecha_creacion = valoresData[4];
                            fecha_creacion = traducirFecha(fecha_creacion);
                            let fecha_pronto = valoresData[5];
                            fecha_pronto = traducirFecha(fecha_pronto);

                            let lote = id;

                            arrayLotes.push(lote);
                            if (arrayLotes == '') {
                                infoLote.style.display = 'none';
                            } else {
                                infoLote.style.display = '';
                            }

                            const tdId = document.createElement('td');
                            const tdCodigo = document.createElement('td');
                            const tdIdTroncal = document.createElement('td');
                            const tdIdAlmacen = document.createElement('td');
                            const tdFechaCreacion = document.createElement('td');
                            const tdFechaPronto = document.createElement('td');
                            const tdFechaCerrado = document.createElement('td');
                            const tdTipo = document.createElement('td');
                            const btnQuitar = document.createElement('td');

                            tdId.textContent = id;
                            tdCodigo.textContent = codigo;
                            tdIdTroncal.textContent = idTroncal;
                            tdIdAlmacen.textContent = idAlmacen;
                            tdFechaCreacion.textContent = fecha_creacion;
                            tdFechaPronto.textContent = fecha_pronto;
                            btnQuitar.textContent = "Quitar";

                            btnQuitar.className = "btnQuitar";
                            btnQuitar.addEventListener("click", () => {
                                const rowIndex = btnQuitar.parentElement.rowIndex;

                                arrayLotes.splice(rowIndex - 1, 1);
                                arrayCodigos.splice(arrayCodigos.indexOf(cod), 1);

                                btnQuitar.parentElement.remove();
                                if (arrayLotes == '') {
                                    infoLote.style.display = 'none';
                                } else {
                                    infoLote.style.display = '';
                                }
                            });

                            tr.appendChild(tdId);
                            tr.appendChild(tdCodigo);
                            tr.appendChild(tdIdTroncal);
                            tr.appendChild(tdIdAlmacen);
                            tr.appendChild(tdFechaCreacion);
                            tr.appendChild(tdFechaPronto);
                            tr.appendChild(btnQuitar);

                            lotesTabla.appendChild(tr);

                        } else if (cod.startsWith("P")) {

                            let id = valoresData[0];
                            let codigo = valoresData[1];
                            let idAlmacenCliente = valoresData[2];
                            let fecha_registrado = valoresData[3];
                            fecha_registrado = traducirFecha(fecha_registrado);
                            let idPickup = valoresData[4];
                            let dir = valoresData[5];
                            let peso = valoresData[6];
                            let cedula = valoresData[7];
                            let mail = valoresData[9];
                            let estado = valoresData[10];

                            let paquete = id;
                            arrayPaquetes.push(paquete);
                            if (arrayPaquetes == '') {
                                infoPaquete.style.display = 'none';
                            } else {
                                infoPaquete.style.display = '';
                            }

                            const tdId = document.createElement('td');
                            const tdCodigo = document.createElement('td');
                            const tdIdAlmacenCliente = document.createElement('td');
                            const tdFechaRegistrado = document.createElement('td');
                            const tdIdPickup = document.createElement('td');
                            const tdDir = document.createElement('td');
                            const tdPeso = document.createElement('td');
                            const tdCedula = document.createElement('td');
                            const tdMail = document.createElement('td');
                            const tdEstado = document.createElement('td');
                            const btnQuitar = document.createElement('td');

                            tdId.textContent = id;
                            tdCodigo.textContent = codigo;
                            tdIdAlmacenCliente.textContent = idAlmacenCliente;
                            tdFechaRegistrado.textContent = fecha_registrado;
                            tdIdPickup.textContent = idPickup;
                            tdDir.textContent = dir;
                            tdPeso.textContent = peso;
                            tdCedula.textContent = cedula;
                            tdMail.textContent = mail;
                            tdEstado.textContent = estado;
                            btnQuitar.textContent = "Quitar";

                            btnQuitar.className = "btnQuitar";
                            btnQuitar.addEventListener("click", () => {
                                const rowIndex = btnQuitar.parentElement.rowIndex;

                                arrayPaquetes.splice(rowIndex - 1, 1);
                                arrayCodigos.splice(arrayCodigos.indexOf(cod), 1);

                                btnQuitar.parentElement.remove();
                                if (arrayPaquetes == '') {
                                    infoPaquete.style.display = 'none';
                                } else {
                                    infoPaquete.style.display = '';
                                }
                            });

                            tr.appendChild(tdId);
                            tr.appendChild(tdCodigo);
                            tr.appendChild(tdIdAlmacenCliente);
                            tr.appendChild(tdFechaRegistrado);
                            tr.appendChild(tdIdPickup);
                            tr.appendChild(tdDir);
                            tr.appendChild(tdPeso);
                            tr.appendChild(tdCedula);
                            tr.appendChild(tdMail);
                            tr.appendChild(tdEstado);
                            tr.appendChild(btnQuitar);

                            paquetesTabla.appendChild(tr);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });

            btnSubmit.addEventListener('click', () => {

                if (arrayLotes.length === 0 && arrayPaquetes.length > 0) {
                    const ruta =
                        "{{ route('almacenDescarga.descarga', ['paquetes' => 'paquetesArray', 'lotes' => 'lotesArray']) }}";

                    function getRoute(paquetes, lotes) {
                        let r = ruta;
                        r = r.replace("paquetesArray", paquetes);
                        r = r.replace("lotesArray", "null");
                        return r;
                    }

                    window.location.href = `${getRoute(arrayPaquetes,arrayLotes)}`;
                } else if (arrayLotes.length > 0 && arrayPaquetes.length === 0) {
                    const ruta =
                        "{{ route('almacenDescarga.descarga', ['paquetes' => 'paquetesArray', 'lotes' => 'lotesArray']) }}";

                    function getRoute(paquetes, lotes) {
                        let r = ruta;
                        r = r.replace("paquetesArray", "null");
                        r = r.replace("lotesArray", lotes);
                        return r;
                    }

                    window.location.href = `${getRoute(arrayPaquetes,arrayLotes)}`;
                } else if (arrayLotes.length > 0 && arrayPaquetes.length > 0) {
                    const ruta =
                        "{{ route('almacenDescarga.descarga', ['paquetes' => 'paquetesArray', 'lotes' => 'lotesArray']) }}";

                    function getRoute(paquetes, lotes) {
                        let r = ruta;
                        r = r.replace("paquetesArray", paquetes);
                        r = r.replace("lotesArray", lotes);
                        return r;
                    }
                    window.location.href = `${getRoute(arrayPaquetes,arrayLotes)}`;
                }

            });

            function traducirFecha(fechaString) {
                let fecha = new Date(fechaString);

                let dia = fecha.getDate();
                let mes = fecha.getMonth() + 1;
                let anio = fecha.getFullYear();
                let horas = fecha.getHours();
                let minutos = fecha.getMinutes();

                let diaFormateado = dia < 10 ? '0' + dia : dia;
                let mesFormateado = mes < 10 ? '0' + mes : mes;
                let anioFormateado = anio % 100;
                let horasFormateadas = horas < 10 ? '0' + horas : horas;
                let minutosFormateados = minutos < 10 ? '0' + minutos : minutos;

                let fechaFormateada = diaFormateado + '/' + mesFormateado + '/' + anioFormateado + ' ' + horasFormateadas +
                    ':' + minutosFormateados;

                return fechaFormateada;
            }

        }
    </script>
</body>

</html>
