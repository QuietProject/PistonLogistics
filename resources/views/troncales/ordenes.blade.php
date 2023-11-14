<x-layout menu="4" titulo="Editar Ordenes">
    <div class="addBackdrop disabled" id="addBackdrop"></div>
    <div class="display">
        <p class="titleText">{{ __("Nombre") }}: {{ $troncal->nombre }}</p>
        <p class="titleText" style="top: 12.5vh">ID: {{ $troncal->ID }}</p>
        <form action="{{ route('ordenes.update', $troncal->ID) }}" method="POST">
            @csrf
            @method('PATCH')
            <input type="text" name="ordenes" hidden id="ordenes">
            <button type="submit" class="addButton">{{ __("Confirmar") }}</button>
        </form>
        <h3 class="tableTitle">{{ __("Almacenes") }}</h3>
        <div class="tableContainer">
            <table class="tableView" id="table_left">
                <thead>
                    <tr>
                        <th style="width: 15%">ID</th>
                        <th style="width: 32.5%">{{ __("Almacen") }}</th>
                        <th style="width: 32.5%">{{ __("Dirección") }}</th>
                        <th style="width: 10%"></th>
                    </tr>
                </thead>
                <tbody id="tbodyLeft">
                    @foreach ($almacenes as $almacen)
                        <tr>
                            <td><a href="{{ route('almacenes.show', $almacen->ID) }}" target="blank">{{ $almacen->ID }}
                            </td>
                            <td>{{ $almacen->nombre }}</td>
                            <td>{{ $almacen->direccion }}</td>
                            <td>
                                <div class="changeBtnArrow"><i class="fa-solid fa-arrow-right"></i></div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <h3 class="tableTitle" style="left: 64vw">{{ __("Ordenes") }}</h3>
        <div class="tableContainer" style="left: 50vw">
            <table class="tableView" id="table_right">
                <thead>
                    <tr>
                        <th style="width: 5%"></th>
                        <th style="width: 15%">ID</th>
                        <th style="width: 20%">{{ __("Almacen") }}</th>
                        <th style="width: 20%">{{ __("Dirección") }}</th>
                        <th style="width: 20%">{{ __("Posicion") }}</th>
                        <th style="width: 5%"></th>
                        <th style="width: 5%"></th>
                    </tr>
                </thead>
                <tbody id="tbodyRight">
                    @foreach ($ordenes as $orden)
                        <tr>
                            <td>
                                <div class="changeBtnArrow" style="margin-left: 15%"><i
                                        class="fa-solid fa-arrow-left"></i></div>
                            <td><a href="{{ route('almacenes.show', $orden->ID_almacen) }}"
                                    target="blank">{{ $orden->ID_almacen }}</a></td>
                            <td>{{ $orden->nombre }}</td>
                            <td>{{ $orden->direccion }}</td>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="changeBtnArrowUp"><i class="fa-solid fa-arrow-up"></i></div>
                            </td>
                            <td>
                                <div class="changeBtnArrowDown"><i class="fa-solid fa-arrow-down"></i></div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layout>

<script defer>
    function getOrder() {
        var orderWarehouses = ""
        var tableOrder = document.getElementById("tbodyRight").querySelectorAll("tr")
        for (let i = 0; i < tableOrder.length; i++) {
            var tds = tableOrder[i].querySelectorAll("td")
            var actualWarehouse = tds[1].innerText
            console.log(actualWarehouse);
            orderWarehouses = orderWarehouses.concat(actualWarehouse, ",")
        }
        orderWarehouses = orderWarehouses.slice(0, -1)
        console.log(orderWarehouses);
        document.getElementById("ordenes").value = orderWarehouses
    }

    $(".changeBtnArrowUp,.changeBtnArrowDown").off("click")
    $(".changeBtnArrowUp,.changeBtnArrowDown").click(function() {
        var row = $(this).parents("tr:first")
        if ($(this).is(".changeBtnArrowUp")) {
            row.insertBefore(row.prev())
        } else {
            row.insertAfter(row.next())
        }
        var tablaLargoNums = document.getElementById("table_right").querySelectorAll("tr")
        for (let i = 1; i < tablaLargoNums.length; i++) {
            var selectedRow = tablaLargoNums[i]
            var selectedCell = selectedRow.querySelectorAll("td")
            selectedCell[4].innerText = i
        }
        getOrder()
    })

    function ordenesLeft() {
        var table_left = document.getElementById("table_left")
        var rows_left = table_left.rows
        var btnLeftList = table_left.getElementsByClassName("changeBtnArrow")
        rows_left[btnLeftList.length].setAttribute("id", "rowLeft" + (btnLeftList.length))
        for (let i = 0; i < btnLeftList.length; i++) {
            btnLeftList[i].setAttribute("id", "btnSwitchLeft" + (i + 1))
            rows_left[i].setAttribute("id", "rowLeft" + (i))
            btnLeftList[i].addEventListener("click", function() {
                let idNum = this.id
                let num = idNum.replace(/\D/g, "")
                var row = document.createElement('tr')
                var col = document.createElement('td')
                var col2 = document.createElement('td')
                var col3 = document.createElement('td')
                var col4 = document.createElement('td')
                var col5 = document.createElement('td')
                var col6 = document.createElement('td')
                var col7 = document.createElement('td')
                row.appendChild(col)
                row.appendChild(col2)
                row.appendChild(col3)
                row.appendChild(col4)
                row.appendChild(col5)
                row.appendChild(col6)
                row.appendChild(col7)
                var elements = document.getElementById("rowLeft" + num).querySelectorAll("td")
                // 1
                var coc = elements[0].childNodes
                var cont = coc[0].innerText
                col.innerHTML =
                    '<div class="changeBtnArrow" id="' + cont +
                    '" style="margin-left: 15%"><i class="fa-solid fa-arrow-left"></i></div>'
                // 2
                var cont2 = elements[0].childNodes
                col2.appendChild(cont2[0])
                // 3
                var cont3 = elements[1].innerText
                col3.innerText = cont3
                // 4
                var cont4 = elements[2].innerText
                col4.innerText = cont4
                // 5
                var l = document.getElementById("tbodyRight").querySelectorAll("tr").length
                col5.innerText = l + 1
                // 6
                col6.innerHTML =
                    '<td><div class="changeBtnArrowUp"><i class="fa-solid fa-arrow-up"></i></div></td>'
                // 7
                col7.innerHTML =
                    '<td><div class="changeBtnArrowDown"><i class="fa-solid fa-arrow-down"></i></div></td>'
                var table = document.getElementById("tbodyRight")
                table.appendChild(row)
                document.getElementById("rowLeft" + num).remove()
                ordenesRight()
                $(".changeBtnArrowUp,.changeBtnArrowDown").off("click")
                $(".changeBtnArrowUp,.changeBtnArrowDown").click(function() {
                    var row = $(this).parents("tr:first")
                    if ($(this).is(".changeBtnArrowUp")) {
                        row.insertBefore(row.prev())
                    } else {
                        row.insertAfter(row.next())
                    }
                    var tablaLargoNums = document.getElementById("table_right").querySelectorAll("tr")
                    for (let i = 1; i < tablaLargoNums.length; i++) {
                        var selectedRow = tablaLargoNums[i]
                        var selectedCell = selectedRow.querySelectorAll("td")
                        selectedCell[4].innerText = i
                    }
                })
                getOrder()
            })
        }
    }

    function ordenesRight() {
        var table_right = document.getElementById("table_right")
        var rows_right = table_right.rows
        var btnRightList = table_right.getElementsByClassName("changeBtnArrow")
        rows_right[btnRightList.length].setAttribute("id", "rowRight" + (btnRightList.length))
        for (let i = 0; i < btnRightList.length; i++) {
            btnRightList[i].setAttribute("id", "btnSwitchRight" + (i + 1))
            rows_right[i].setAttribute("id", "rowRight" + (i))
            btnRightList[i].addEventListener("click", function() {
                let idNum = this.id
                let num = idNum.replace(/\D/g, "")
                var row = document.createElement('tr')
                var col = document.createElement('td')
                var col2 = document.createElement('td')
                var col3 = document.createElement('td')
                var col4 = document.createElement('td')
                row.appendChild(col)
                row.appendChild(col2)
                row.appendChild(col3)
                row.appendChild(col4)
                var elements = document.getElementById("rowRight" + num).querySelectorAll("td")
                console.log(elements);
                // 1
                var cont = elements[1].childNodes
                console.log(elements);
                console.log(cont)
                col.appendChild(cont[0])
                // 2
                var cont2 = elements[2].innerText
                col2.innerText = cont2
                // 3
                var cont3 = elements[3].innerText
                col3.innerText = cont3
                // 4
                col4.innerHTML =
                    '<td><div class="changeBtnArrow"><i class="fa-solid fa-arrow-right"></i></div></td>'
                var table = document.getElementById("tbodyLeft")
                table.appendChild(row)
                document.getElementById("rowRight" + num).remove()
                ordenesLeft()
                getOrder()
            })
        }
    }
    ordenesLeft()
    ordenesRight()
</script>

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
        top: 5vh;
        left: 10vh;
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
        display: flex;
        align-items: center;
        justify-content: center;
        color: black;
        text-shadow: none;
        font-size: 1.25vw
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
        left: 18vw;
        color: rgb(225, 225, 225);
        font-size: 5vh;
        font-weight: bold;
        text-shadow: 0 0 5px var(--base);
    }

    .tableContainer {
        position: absolute;
        top: 35vh;
        left: 5vw;
        max-height: 56vh;
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

    .changeBtnArrow {
        height: 3.5vh;
        aspect-ratio: 1/1;
        border-radius: 50%;
        background-color: var(--highlight);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .changeBtnArrow:hover {
        cursor: pointer;
    }

    .changeBtnArrowDown {
        height: 3.5vh;
        aspect-ratio: 1/1;
        border-radius: 50%;
        background-color: var(--highlight);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .changeBtnArrowDown:hover {
        cursor: pointer;
    }

    .changeBtnArrowUp {
        height: 3.5vh;
        aspect-ratio: 1/1;
        border-radius: 50%;
        background-color: var(--highlight);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .changeBtnArrowUp:hover {
        cursor: pointer;
    }

    .addButton {
        position: absolute;
        height: 7.5vh;
        width: 10vw;
        top: 10vh;
        right: 10vw;
        background-color: var(--highlight);
        border-radius: 2vh;
        font-size: 3vh;
    }

    .addButton:hover {
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
    }

    .buttonEnd:hover {
        cursor: pointer;
    }
</style>
