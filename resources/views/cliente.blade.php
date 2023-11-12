<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/styleCliente.css">
    <link rel="stylesheet" href="./css/styleMenu.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Cliente</title>
</head>

<body>
    @if (session('message'))
        <script>
            Swal.fire({
                position: 'top',
                icon: 'success',
                title: '{{ session('message') }}',
                showConfirmButton: false,
                timer: 1000,
                customClass: {
                    container: 'popup'
                }
            })
            setTimeout(() => {
                window.location.href = "{{ route('clear.message') }}";
            }, 800);
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
                <h1>Ingresar paquete</h1>
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
                <p>Carga</p>
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
                <a href="../crearPaquete">Crear Paquete</a>
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
    <script src="./javascript/scriptCliente.js"></script>
    <script defer src="./javascript/scriptMenu.js"></script>
    <script>
        const moverPaquete = document.getElementById("moverPaquete");
        const codigo = document.getElementById("codigo");
        const rutaBase = "{{ route('getPaqueteOrLoteCodigo') }}";
        const paquetesTabla = document.getElementById("paquetesTabla");
        const infoPaquete = document.querySelector(".infoPaquete");
        const btnSubmbit = document.getElementById("btnSubmit");



        const arrayPaquetes = [];
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

                        if (cod.startsWith("P")) {

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

                if (arrayPaquetes.length > 0) {
                    const ruta = "{{ route('cliente.carga', ['paquetes' => 'paquetesArray']) }}";

                    function getRoute(paquetes) {
                        let r = ruta;
                        r = r.replace("paquetesArray", paquetes);
                        return r;
                    }

                    window.location.href = `${getRoute(arrayPaquetes)}`;
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
