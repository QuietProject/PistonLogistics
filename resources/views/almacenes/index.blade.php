<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="#">
    <link rel="stylesheet" href="../css/style.css ">
    <link rel="stylesheet" href="../css/styleAlmacenes.css">
    <script src="https://kit.fontawesome.com/b9577afa32.js" crossorigin="anonymous"></script>
    <title>Piston Logistics</title>
</head>

<body>
    <div class="navDiv">
        <a href="{{ route('camioneros.index') }}" class="button inactive"></a>
        <a href="{{ route('usuarios.index') }}" class="button inactive"></a>
        <a href="{{ route('almacenes.index') }}" class="button active"></a>
        <a href="{{ route('troncales.index') }}" class="button inactive"></a>
        <a href="{{ route('vehiculos.index') }}" class="button inactive"></a>
        <a href="{{ route('clientes.index') }}" class="button inactive"></a>
    </div>
    <div class="addBackdrop disabled" id="addBackdrop"></div>
    <div class="display">
        <input type="button" value="Add" class="addButton" id="addTruck">
        <input type="text" id="searchInput" class="filterText" placeholder="Search" onkeyup="searchFilter()">
        <h2 class="titleText">Almacenes</h2>
        <h2 class="tableTitle">Almacenes propios</h2>
        <div class="tableContainer">
            <table class="tableView" id="tablePropios">
                <thead>
                    <tr>
                        <th style="width: 10%;" onclick="sortTable(0);arrowsTable(0);" id="0">ID</th>
                        <th style="width: 30%;" onclick="sortTable(1);arrowsTable(1);" id="1">Nombre</th>
                        <th style="width: 30%;" onclick="sortTable(2);arrowsTable(2);" id="2">Direccion</th>
                        <th style="width: 30%;" onclick="sortTable(3);arrowsTable(3);" id="3">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($propios as $propio)
                        @php $almacen = $propio->almacen; @endphp
                        <tr>
                            <td><a href="{{ route('almacenes.show', $almacen->ID) }}"> {{ $almacen->ID }}</a>
                            </td>
                            <td>{{ $almacen->nombre }}</td>
                            <td>{{ $almacen->direccion }}</td>
                            <td>
                                @if ($almacen->baja)
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
        <h2 class="tableTitle" style="left: 57vw; top: 20vh;">Almacenes de clientes</h2>
        <div class="tableContainer" style="left: 50vw;">
            <table class="tableView" id="tableClientes">
                <thead>
                    <tr>
                        <th style="width: 10%;" onclick="sortTableAlternate(0);arrowsTable(4);"" id="4">ID</th>
                        <th style="width: 25%;" onclick="sortTableAlternate(1);arrowsTable(5);"" id="5">Nombre</th>
                        <th style="width: 25%;" onclick="sortTableAlternate(2);arrowsTable(6);"" id="6">Direccion</th>
                        <th style="width: 20%;" onclick="sortTableAlternate(3);arrowsTable(7);"" id="7">Cliente</th>
                        <th style="width: 20%;" onclick="sortTableAlternate(4);arrowsTable(8);"" id="7">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $cliente)
                        @php $almacen = $cliente->almacen; @endphp
                        <tr>
                            <td><a href="{{ route('almacenes.show', $almacen->ID) }}"> {{ $almacen->ID }}</a>
                            </td>
                            <td>{{ $almacen->nombre }}</td>
                            <td>{{ $almacen->direccion }}</td>
                            <td><a href="{{ route('clientes.show', $cliente->RUT) }}">
                                    {{ $cliente->cliente->nombre }}</a>
                            </td>
                            <td>
                                @if ($almacen->baja)
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
                <h2 class="adderTitle">Ingresar Almacen</h2>
                <form action="{{ route('almacenes.store') }}" method="POST">
                    @csrf
                    <div class="inputBox">
                        <label for="tipo">Tipo</label>
                        <select name="tipo" id="tipo">
                            <option value="propio">Propio</option>
                            <option value="cliente" {{ old('tipo') == 'cliente' ? 'selected' : '' }}>Cliente</option>
                        </select>
                    </div>
                    <div class="inputBox">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" required
                            value="{{ old('nombre', $almacen->nombre) }}">
                        @error('nombre')
                            <span style="color: red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="inputBox">
                        <label for="direccion">Direccion</label>
                        <input type="text" name="direccion" id="direccion" step="0.1"
                            value="{{ old('direccion', $almacen->direccion) }}">
                        @error('direccion')
                            <span style="color: red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="inputBox">
                        <label for="RUT">Cliente</label>
                        <select name="RUT" id="RUT">
                            @foreach ($empresas as $cliente)
                                @if ($cliente->baja == 0)
                                    <option value="{{ $cliente->RUT }}">{{ $cliente->nombre }} - {{ $cliente->RUT }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        @error('RUT')
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

<script src="../javascript/scriptAlmacenes.js"></script>
<script src="../javascript/scriptUsuario.js"></script>
