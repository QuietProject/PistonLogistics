<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="#">
    <link rel="stylesheet" href="../css/style.css ">
    <link rel="stylesheet" href="../css/styleVehiculos.css">
    <script src="https://kit.fontawesome.com/b9577afa32.js" crossorigin="anonymous"></script>
    <title>Piston Logistics</title>
</head>

<body>
    <div class="navDiv">
        <a href="{{ route('camioneros.index') }}" class="button inactive" id="btnUsers"></a>
        <a href="{{ route('vehiculos.index') }}" class="button active" id="btnTrucks"></a>
        <a href="" class="button inactive" id="btnRutes"></a>
        <a href="" class="button inactive" id="btnWarehouses"></a>
        <a href="" class="button inactive" id="btnProducts"></a>
        <a href="{{ route('clientes.index') }}" class="button inactive" id="btnClients"></a>
    </div>
    <!-- Backdrop Blur -->
    <div class="addBackdrop disabled" id="addBackdrop">
    </div>
    <!-- Trucks Screen -->
    <div class="display" id="displayTrucks">
        <!-- Title -->
        <h1 class="titleText">Vehicles</h1>
        <!-- Add Button -->
        <input type="button" value="Add" class="addButton" id="addTruck">
        <!-- SearchBar -->
        <input type="text" id="searchInput" class="filterText" placeholder="Search" onkeyup="searchFilter()">
        <!-- Trucks Title -->
        <p class="tableTitle">Trucks</p>
        <!-- Camionetas Title -->
        <p class="tableTitle" style="left: 63vw">Pickup Trucks</p>
        <!-- Tables Container -->
        <div class="tableContainer">
            <!-- Truck Table -->
            <table class="tableView" id="tableTrucks">
                <thead>
                    <tr>
                        <th style="width: 15%;" onclick="sortTable(0);arrowsTable(0);" id="0">Matricula </th>
                        <th style="width: 30%;" onclick="sortTable(1);arrowsTable(1);" id="1">Peso Maximo </th>
                        <th style="width: 30%;" onclick="sortTable(2);arrowsTable(2);" id="2">Volumen Maximo </th>
                        <th style="width: 25%;" onclick="sortTable(3);arrowsTable(3);" id="3">Estado </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($camiones as $camion)
                        <tr>
                            <td><a href="{{ route('vehiculos.show', $camion->matricula) }}">
                                    {{ $camion->matricula }}</a>
                            </td>
                            <td>{{ $camion->peso_max }}kg</td>
                            <td>{{ $camion->vol_max }}m3</td>
                            <td>
                                @if ($camion->baja)
                                    De Baja
                                @else
                                    @if ($camion->es_operativo)
                                        Operativo
                                    @else
                                        Fuera De Servicio
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tableContainer" style="left: 50vw;">
            <table class="tableView" id="tableCamionetas">
                <thead>
                    <tr>
                        <th style="width: 15%;" onclick="sortTableAlternate(0);arrowsTable(4);"" id="4">Matricula</th>
                        <th style="width: 30%;" onclick="sortTableAlternate(1);arrowsTable(5);"" id="5">Peso Maximo</th>
                        <th style="width: 30%;" onclick="sortTableAlternate(2);arrowsTable(6);"" id="6">Volumen Maximo</th>
                        <th style="width: 25%;" onclick="sortTableAlternate(3);arrowsTable(7);"" id="7">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($camionetas as $camioneta)
                        <tr>
                            <td><a style="linkVehicle" href="{{ route('vehiculos.show', $camioneta->matricula) }}">
                                    {{ $camioneta->matricula }}</a>
                            </td>
                            <td>{{ $camioneta->peso_max }}kg</td>
                            <td>{{ $camioneta->vol_max }}m3</td>
                            <td>
                                @if ($camioneta->baja)
                                    De Baja
                                @else
                                    @if ($camioneta->es_operativo)
                                        Operativo
                                    @else
                                        Fuera De Servicio
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Add Trucks -->
        <div class="addInterface" id="addTruckInterface" style="display: none">
            <!-- Close Button -->
            <div class="cornerButton" id="closeButtonCornerTrucks"></div>
            <div class="closeButton" id="closeButtonTrucks">
                <div class="xLine" style="rotate: 45deg;"></div>
                <div class="xLine" style="rotate: -45deg;"></div>
            </div>
            <!-- Add Vehicle -->
            <div class="addForm">
                @if ($errors->any())
                <script>
                    document.getElementById("addBackdrop").style.display = "flex";
                    document.getElementById("addTruckInterface").style.display = "flex";
                </script>
                @endif
                <h2 class="adderTitle">Ingresar Vehiculo</h2>
                <form action="{{ route('vehiculos.store') }}" method="POST">
                    @csrf
                    <div class="inputBox">
                        <label for="tipo">Tipo</label>
                        <select name="tipo" id="tipo">
                            <option value="camion">Camion</option>
                            <option value="camioneta">Camioneta</option>
                        </select>
                    </div>
                    <div class="inputBox">
                        <label for="matricula">Matricula</label>
                        <input type="text" name="matricula" id="matricula" maxlength="7" minlength="7" 
                        requiredvalue="{{ old('matricula') }}" pattern="[A-Za-z]{3}[0-9]{4}" autocomplete="off">
                        @error('matricula')
                            <span style="color: red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="inputBox">
                        <label for="peso_max">Peso Maximo</label>
                        <input type="number" name="peso_max" id="peso_max" required
                        value="{{ old('peso_max',$vehiculo->peso_max) }}" autocomplete="off">
                        <span>kg</span>
                        @error('peso_max')
                            <span style="color: red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="inputBox">
                        <label for="vol_max">Volumen Maximo</label>
                        <input type="number" name="vol_max" id="vol_max" step="0.1" required
                        value="{{ old('vol_max',$vehiculo->vol_max) }}" autocomplete="off">
                        <span>m3</span>
                        @error('vol_max')
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
