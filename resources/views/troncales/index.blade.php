<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="#">
    <link rel="stylesheet" href="../css/style.css ">
    <link rel="stylesheet" href="../css/styleTroncales.css">
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
        <h2 class="titleText">Troncales</h2>
        <input type="button" value="Add" class="addButton" id="addTruck">
        <input type="text" id="searchInput" class="filterText" placeholder="Search" onkeyup="searchFilter()">
        <div class="tableContainer">
            <table class="tableView">
                <thead>
                    <tr>
                        <th style="width: 10%;" onclick="sortTable(0);arrowsTable(0);" id="0">ID</th>
                        <th style="width: 30%;" onclick="sortTable(0);arrowsTable(0);" id="0">Nombre</th>
                        <th style="width: 30%;" onclick="sortTable(0);arrowsTable(0);" id="0">Cantidad almacenes</th>
                        <th style="width: 30%;" onclick="sortTable(0);arrowsTable(0);" id="0">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($troncales as $troncal)
                        <tr>
                            <td><a href="{{ route('troncales.show', $troncal) }}"> {{ $troncal->ID }}</a>
                            </td>
                            <td>{{ $troncal->nombre }}</td>
                            <td>{{ count($troncal->ordenes) }}</td>
                            <td>

                                @if ($troncal->baja)
                                    de baja
                                @else
                                    operativo
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="addInterface" id="addTruckInterface" style="display: none">
            <div class="cornerButton" id="closeButtonCornerTrucks"></div>
            <div class="closeButton" id="closeButtonTrucks">
                <div class="xLine" style="rotate: 45deg;"></div>
                <div class="xLine" style="rotate: -45deg;"></div>
            </div>
            <div class="addForm">
                @if ($errors->any())
                    <script>
                        document.getElementById("addBackdrop").style.display = "flex";
                        document.getElementById("addTruckInterface").style.display = "flex";
                    </script>
                @endif
                <h2 class="adderTitle">Ingresar Troncal</h2>
                <form action="{{ route('troncales.store') }}" method="POST">
                    @csrf
                    <div class="inputBox" style="top 20%">
                        <label for="nombre">Nombre</label>
                        <input style="inputBox" type="text" name="nombre" id="nombre" required value="{{ old('nombre') }}">
                        @error('nombre')
                            <span style="color: red">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="submitBtn">Submit</button>

                </form>

            </div>
        </div>
    </div>
</body>

</html>

<script src="../javascript/scriptAdministrador.js"></script>
