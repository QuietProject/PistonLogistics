<x-layout titulo='Lleva' menu='7'>
    <div class="display">
        <h2 class="titleText">{{ __("Asignar Paquete") }} {{ $paquete->ID_paquete }}</h2>
        <input type="text" id="searchInput" class="filterText" placeholder="Search" onkeyup="searchFilter()">
        <div class="infoBox">
            <div class="infoContainer">
                <p>ID: </p>
                <p>{{ $paquete->ID_paquete }}</p>
            </div>
            <div class="infoContainer">
                <p>{{ __("Codigo") }}: </p>
                <p>{{ $paquete->codigo }}</p>
            </div>
            <div class="infoContainer">
                <p>{{ __("Fecha registrado") }}: </p>
                <p>{{ \Carbon\Carbon::parse($paquete->fecha_registrado)->format('d/m/y H:i') }}</p>
            </div>
            <div class="infoContainer">
                <p>{{ __("En Almacen") }}: </p>
                <p><a target="_blank"
                        href="{{ route('almacenes.show', $paquete->ID_almacen) }}">{{ $paquete->ID_almacen }} -
                        {{ $paquete->nombre }}</a></p>
            </div>
            <div class="infoContainer">
                <p>{{ __("Cliente") }}: </p>
                <p><a target="_blank" href="{{ route('clientes.show', $paquete->RUT) }}">{{ $paquete->cliente }}</a></p>
            </div>
        </div>
        <form action="{{ route('trae.store', $paquete->ID_paquete) }}" method="POST">
            @csrf
            <h3 class="tableTitle">{{ __("Elegir vehiculo") }}</h3>
            <div class="tableContainer">
                <table id="tableDrivers" class="tableView">
                    <thead>
                        <tr>
                            <th style="width: 20%">{{ __("Matricula") }}</th>
                            <th style="width: 20%">{{ __("Paquetes asignados") }}</th>
                            <th style="width: 20%">{{ __("Peso maximo") }}</th>
                            <th style="width: 20%">{{ __("Tipo") }}</th>
                            <th style="width: 2S0%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vehiculos as $vehiculo)
                            <tr>
                                <td>{{ $vehiculo->matricula }}</td>
                                <td>{{ $vehiculo->paquetes_asignados }}</td>
                                <td>{{ $vehiculo->peso_max }}kg</td>
                                <td>{{ $vehiculo->tipo == 1 ? 'camioneta' : 'camion' }}</td>
                                <td><input type="radio" name="vehiculo" value="{{ $vehiculo->matricula }}"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <button type="submit" class="switchBtn">{{ __("Asignar") }}</button>
        </form>
    </div>
</x-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap');

    :root {
        --font: 'Roboto Mono', monospace;
        --base: #3c3c3c;
        --baseLight: #646464;
        --baseLighter: #969696;
        --color: #ffaf64;
        --colorDark: #ffaf64e3;
        --highlight: #ff9500;
        --baseDark: #2c2c2c;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        scroll-behavior: smooth;
        font-family: var(--font);
        -ms-overflow-style: none;
        scrollbar-width: none;
        border: 0;
        margin: 0;
        padding: 0;
    }

    *::-webkit-scrollbar {
        display: none;
    }

    body {
        display: flex;
        height: 100%;
        width: 100%;
        overflow-y: hidden;
        overflow-x: hidden;
    }

    .navDiv {
        position: absolute;
        height: 100%;
        width: 3vw;
        background-color: var(--base);
        display: flex;
        flex-direction: column;
    }

    .button {
        height: 2.5vw;
        width: 2.5vw;
        margin-top: 0.5vw;
        margin-left: 0.25vw;
        display: flex;
        align-items: center;
        justify-content: center;
        color: black;
        text-shadow: none;
        font-size: 1.25vw;
        position: relative;
        text-decoration: none;
    }

    .button:hover {
        cursor: pointer;
    }

    .buttonEnd {
        height: 2.5vw;
        width: 2.5vw;
        margin-bottom: 0.5vw;
        margin-left: 0.25vw;
        display: flex;
        align-items: center;
        justify-content: center;
        color: black;
        text-shadow: none;
        font-size: 1.25vw;
        position: absolute;
        background-color: var(--baseLighter);
        border-radius: 50%;
        text-decoration: none;
    }

    .buttonEnd:hover {
        cursor: pointer;
    }

    .button:active {
        transform: scale(95%);
    }

    .disabled {
        display: none;
    }

    .inactive {
        border-radius: 50%;
        background-color: var(--color);
    }

    .active {
        border-radius: 50%;
        background-color: var(--highlight);
    }

    .display {
        position: absolute;
        right: 0;
        height: 100vh;
        width: 97vw;
        background-color: var(--baseLight);
    }

    .titleText {
        position: absolute;
        font-size: 5vh;
        top: 5vh;
        left: 10vh;
        color: white;
        text-shadow: 0 0 10px var(--base);
        text-align: center;
    }

    .filterText {
        position: absolute;
        height: 5vh;
        width: 20vw;
        top: 15vh;
        left: 7.5vw;
        border-radius: 2vh;
        text-indent: 5%;
        background-color: rgb(200, 200, 200);
        box-shadow: 0 0 10px 0 var(--base);
    }

    .filterText:focus {
        outline: none;
        background-color: white;
    }

    input,
    label,
    option,
    select {
        font-weight: 500;
        font-size: 1.5vh;
    }

    input {
        height: 3vh;
        width: 12.5vw;
        text-align: center;
        border-radius: 10px;
    }

    select {
        height: 3vh;
        width: 12.5vw;
        border-radius: 10px;
        text-align: center;
    }

    .addButton {
        position: absolute;
        height: 7.5vh;
        width: 7.5vw;
        top: 10vh;
        right: 15vh;
        background-color: var(--highlight);
        border-radius: 2vh;
        font-size: 3vh;
    }

    .addButton:hover {
        cursor: pointer;
    }

    .tableContainer {
        position: absolute;
        top: 30vh;
        left: 5vw;
        max-height: 55vh;
        width: 55vw;
        border-radius: 10px;
        overflow-y: scroll;
    }

    .tableView {
        width: 55vw;
        background-color: rgb(140, 140, 140);
        border-collapse: collapse;
    }

    .tableTitle {
        position: absolute;
        top: 25vh;
        left: 24vw;
        color: rgb(225, 225, 225);
        font-size: 3vh;
        font-weight: bold;
        text-shadow: 0 0 5px var(--base);
        user-select: none;
    }

    a {
        text-decoration: none;
        color: var(--highlight);
        text-shadow: 0 0 5px var(--base);
    }

    tr {
        height: 4.5vh;
    }

    th {
        background-color: var(--base);
        color: white;
        position: sticky;
        top: 0;
        text-align: center;
        font-size: large;
        user-select: none;
    }

    td {
        text-align: center;
        font-size: medium
    }

    tr:nth-child(even) {
        background-color: rgb(165, 165, 165);
    }

    .textNegative {
        font-weight: 500;
        text-align: center;
        color: white;
        font-size: 5vh;
        margin-top: 50vh;
    }

    .switchBtn {
        background-color: var(--highlight);
        height: 7.5vh;
        width: 12.5vw;
        border-radius: 15px;
        font-weight: 500;
        font-size: 2.5vh;
        position: absolute;
        top: 87.5vh;
        left: 25vw;
    }

    .switchBtn:hover {
        cursor: pointer;
    }

    .infoBox {
        position: absolute;
        text-align: center;
        height: 40vh;
        width: 25vw;
        top: 40vh;
        left: 65vw;
        color: white;
        font-weight: 400;
        font-size: 2.5vh;
    }

    .infoContainer {
        display: flex;
        justify-content: space-between;
        color: white;
        font-size: 2.5vh;
    }
</style>
<script>
    function sortTable(n) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("tableDriver");
        switching = true;
        dir = "asc";
        while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount++;
            } else {
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }


    function searchFilter() {
        var input, filter, table, tr, td, i, o, show, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("tableDrivers");
        tr = table.getElementsByTagName("tr");
        table2 = document.getElementById("tableDrivers2");
        tr2 = table2.getElementsByTagName("tr");

        for (i = 1; i < tr.length; i++) {
            var rowLenght = tr[i].getElementsByTagName("td");
            var show = 0;
            for (o = 0; o < rowLenght.length; o++) {
                td = tr[i].getElementsByTagName("td")[o];
                console.log(o);
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        show++;
                    }
                }
            }

            if (show == 0) {
                tr[i].style.display = "none";
            } else {
                tr[i].style.display = "";
            }
        }

        for (i = 1; i < tr2.length; i++) {
            var rowLenght = tr2[i].getElementsByTagName("td");
            var show = 0;
            for (o = 0; o < rowLenght.length; o++) {
                td = tr2[i].getElementsByTagName("td")[o];
                console.log(o);
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        show++;
                    }
                }
            }

            if (show == 0) {
                tr2[i].style.display = "none";
            } else {
                tr2[i].style.display = "";
            }
        }

    }
</script>
