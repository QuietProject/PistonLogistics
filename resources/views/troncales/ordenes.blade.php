<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="#">
    <link rel="stylesheet" href="../css/style.css ">
    <link rel="stylesheet" href="../css/styleTroncalesShow.css">
    <script src="https://kit.fontawesome.com/b9577afa32.js" crossorigin="anonymous"></script>
    <title>Piston Logistics</title>
</head>


<body>
    <div class="navDiv">
        <a href="{{ route('camioneros.index') }}" class="button inactive"></a>
        <a href="{{ route('usuarios.index') }}" class="button inactive"></a>
        <a href="{{ route('almacenes.index') }}" class="button inactive"></a>
        <a href="{{ route('troncales.index') }}" class="button active"></a>
        <a href="{{ route('vehiculos.index') }}" class="button inactive"></a>
        <a href="{{ route('clientes.index') }}" class="button inactive"></a>
    </div>
    <div class="addBackdrop disabled" id="addBackdrop"></div>
    <div class="display">
        <h2>Troncal</h2>
        <p>ID: {{ $troncal->ID }}</p>
        <p>Nombre: {{ $troncal->nombre }}</p>

        <form action="{{ route('ordenes.update', $troncal->ID) }}" method="POST">
            @csrf
            @method('PATCH')
            <input type="text" name="ordenes">
            <button type="submit"></button>
        </form>
        <h3>Ordenes</h3>
        <div class="tableContainer">
            <table class="tableView" id="t_draggable1">
                <thead>
                    <tr>
                        <th style="width: 20%">ID</th>
                        <th style="width: 40%">almacen</th>
                        <th style="width: 40%">Posicion</th>
                    </tr>
                </thead>
                <tbody class="t_sortable">
                    @foreach ($ordenes as $orden)
                        <tr>
                            <td><a href="{{ route('almacenes.show', $orden->ID_almacen) }}"
                                    target="blank">{{ $orden->ID_almacen }}</a></td>
                            <td>{{ $orden->nombre }}</td>
                            <td>{{ $loop->iteration }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <h3>Almacenes</h3>
        <div class="tableContainer" style="left: 50vw">
            <table class="tableView" id="t_draggable2">
                <thead>
                    <tr>
                        <th style="width: 20%">ID</th>
                        <th style="width: 40%">almacen</th>
                        <th style="width: 40%">direccion</th>
                    </tr>
                </thead>
                <tbody class="t_sortable">
                    @foreach ($almacenes as $almacen)
                        <tr>
                            <td><a href="{{ route('almacenes.show', $almacen->ID) }}" target="blank">
                                    {{ $almacen->ID }}
                            </td>
                            <td>{{ $almacen->nombre }}</td>
                            <td>{{ $almacen->direccion }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>

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
    }

    * {
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

    input {
        border-radius: 10px;
        text-align: center;
    }

    textarea:focus,
    input:focus {
        outline: none;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }

    .titleText {
        position: absolute;
        font-size: 5vh;
        top: 10vh;
        left: 17.5vh;
        color: white;
        text-shadow: 0 0 10px var(--base);
        user-select: none;
    }

    .addButton {
        display: flex;
        position: absolute;
        height: 7.5vh;
        width: 12.5vw;
        top: 10vh;
        right: 15vh;
        background-color: var(--highlight);
        border-radius: 2vh;
        font-size: 2.5vh;
        color: black;
        text-shadow: none;
        justify-content: center;
        align-items: center;
    }

    .addButton:hover {
        cursor: pointer;
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
    }

    .button:hover {
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

    .modBtn {
        background-color: var(--highlight);
        margin-top: 2vh;
        height: 4vh;
        width: 10vw;
        border-radius: 15px;
        font-weight: 500;
        font-size: 1.5vh;
    }

    .modBtn:hover {
        cursor: pointer;
    }

    .switchBtn {
        background-color: var(--highlight);
        height: 2.5vh;
        width: 5vw;
        border-radius: 15px;
        font-weight: 500;
        font-size: 1.5vh;
    }

    .switchBtn:hover {
        cursor: pointer;
    }

    input,
    label,
    option,
    select {
        font-weight: 500;
    }

    .editContainer {
        position: relative;
        height: 50vh;
        width: 35vw;
        left: 57.5vw;
        top: 35vh;
        text-align: center;
    }

    .filterText {
        position: absolute;
        height: 5vh;
        width: 20vw;
        top: 22.5vh;
        left: 10vw;
        border-radius: 2vh;
        text-indent: 5%;
        background-color: rgb(200, 200, 200);
        box-shadow: 0 0 10px 0 var(--base);
    }

    .filterText:focus {
        outline: none;
        background-color: white;
    }

    .tableTitle {
        position: absolute;
        top: 27.5vh;
        left: 22.5vw;
        color: rgb(225, 225, 225);
        font-size: 5vh;
        font-weight: bold;
        text-shadow: 0 0 5px var(--base);
        user-select: none;
    }

    .tableContainer {
        position: absolute;
        top: 35vh;
        left: 5vw;
        max-height: 65vh;
        width: 40vw;
        border-radius: 10px;
        text-align: center;
        overflow-y: scroll;
    }

    .tableView {
        width: 40vw;
        background-color: rgb(140, 140, 140);
        border-collapse: collapse;
    }

    .switchBtn {
        background-color: var(--highlight);
        height: 2.5vh;
        width: 7.5vw;
        border-radius: 15px;
        font-weight: 500;
        font-size: 1.5vh;
    }

    .switchBtn:hover {
        cursor: pointer;
    }

    .asignadoText {
        font-weight: 500;
        font-size: 2.5vh;
        color: white;
    }


    .dragging .ui-state-hover a {
        color: green !important;
        font-weight: bold;
    }

    .t_sortable tr,
    .ui-sortable-helper {
        cursor: move;
    }
</style>

<script>
    $(document).ready(function() {
        var $tabs = $('#t_draggable2')
        $("tbody.t_sortable").sortable({
            connectWith: ".t_sortable",
            items: "> tr:not(:first)",
            appendTo: $tabs,
            helper: "clone",
            zIndex: 999990
        }).disableSelection();

        var $tab_items = $(".nav-tabs > li", $tabs).droppable({
            accept: ".t_sortable tr",
            hoverClass: "ui-state-hover",
            drop: function(event, ui) {
                return false;
            }
        });
    });
</script>
