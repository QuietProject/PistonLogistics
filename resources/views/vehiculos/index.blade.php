<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="#">
    <link rel="stylesheet" href="../css/style.css ">
    <link rel="stylesheet" href="../css/styleAdministrador.css">
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
        <input type="text" id="" class="filterText" placeholder="Search">
        <!-- Tables Container -->
        <div class="tableContainer">
            <!-- Truck Table -->
            <table class="tableView" id="tableTrucks">
                <thead>
                    <tr>
                        <th style="width: 7.5%;" onclick="sortTable(0)">ID</th>
                        <th style="width: 30%;" onclick="sortTable(1)">Name</th>
                        <th style="width: 30%;" onclick="sortTable(2)">Surname</th>
                        <th style="width: 20%;" onclick="sortTable(3)">Rol</th>
                        <th style="width: 12.5%;" onclick="sortTable(4)"></th>
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
        <div class="tableContainer" style="left: 50vw; top: -45vh;">
            <table class="tableView" id="tableCamionetas">
                <thead>
                    <tr>
                        <th style="width: 7.5%;" onclick="sortTableAlternate(0)">ID</th>
                        <th style="width: 30%;" onclick="sortTableAlternate(1)">Name</th>
                        <th style="width: 30%;" onclick="sortTableAlternate(2)">Surname</th>
                        <th style="width: 20%;" onclick="sortTableAlternate(3)">Rol</th>
                        <th style="width: 12.5%;" onclick="sortTableAlternate(4)"></th>
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
            <div class="cornerButton">
                <div class="closeButton" id="closeButtonTrucks">
                    <div class="xLine" style="rotate: 45deg;"></div>
                    <div class="xLine" style="rotate: -45deg;"></div>
                </div>
            </div>
            <!-- Add Vehicle -->
            <div class="addForm">
                @if ($errors->any())
                    abre el formulario
                @endif
                <h2>Ingresar Vehiculo</h2>
                <form action="{{ route('vehiculos.store') }}" method="POST">
                    @csrf
                    <div>
                        <label for="tipo">Tipo</label>
                        <select name="tipo" id="tipo">
                            <option value="camion">Camion</option>
                            <option value="camioneta">Camioneta</option>
                        </select>
                    </div>
                    <div>
                        <label for="matricula">Matricula</label>
                        <input type="text" name="matricula" id="matricula" maxlength="7" minlength="7" required
                            value="{{ old('matricula') }}">
                        @error('matricula')
                            <span style="color: red">{{ $message }}</span>
                        @enderror
                    </div>
                    @include('vehiculos.form-fields')
                </form>
            </div>
        </div>
    </div>
</body>

</html>

<script src="../javascript/scriptAdministrador.js"></script>
