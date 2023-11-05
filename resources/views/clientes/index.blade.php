<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="#">
    <link rel="stylesheet" href="../css/style.css ">
    <link rel="stylesheet" href="../css/styleClientes.css">
    <script src="https://kit.fontawesome.com/b9577afa32.js" crossorigin="anonymous"></script>
    <title>Piston Logistics</title>
</head>

<body>
    <div class="navDiv">
        <a href="{{ route('camioneros.index') }}" class="button inactive"></a>
        <a href="{{ route('usuarios.index') }}" class="button inactive"></a>
        <a href="{{ route('almacenes.index') }}" class="button inactive"></a>
        <a href="{{ route('troncales.index') }}" class="button inactive"></a>
        <a href="{{ route('vehiculos.index') }}" class="button inactive"></a>
        <a href="{{ route('clientes.index') }}" class="button active"></a>
    </div>
    <div class="addBackdrop disabled" id="addBackdrop"></div>
    <div class="display">
        <h2 class="titleText">Clientes</h2>
        <input type="text" id="searchInput" class="filterText" placeholder="Search" onkeyup="searchFilter()">
        <div class="tableContainer">
            <table class="tableView">
                <thead>
                    <tr>
                        <th style="width: 33%;" onclick="sortTable(0);arrowsTable(0);" id="0">Rut</th>
                        <th style="width: 33%;" onclick="sortTable(0);arrowsTable(1);" id="0">Nombre</th>
                        <th style="width: 33%;" onclick="sortTable(0);arrowsTable(2);" id="0">Baja</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $cliente)
                        <tr>
                            <td><a href="{{ route('clientes.show', $cliente->RUT) }}"> {{ $cliente->RUT }}</a> </td>
                            <td>{{ $cliente->nombre }}</td>
                            <td>
                                <form action="{{ route('clientes.destroy', $cliente->RUT) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="switchBtn">
                                        @if ($cliente->baja)
                                            Dar de Alta
                                        @else
                                            Dar de Baja
                                        @endif
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="editContainer">
            <h2 class="asignadoText">Ingresar cliente</h2>
            <form action="{{ route('clientes.store') }}" method="POST">
                @csrf
                <div>
                    <label for="RUT" class="asignadoText">RUT</label>
                    <input type="number" name="RUT" id="RUT" maxlength="12" minlength="12" required
                        value="{{ old('RUT') }}">
                    @error('RUT')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="nombre" class="asignadoText">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $cliente->nombre) }}">
                    @error('nombre')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="switchBtn" style="margin-top: 1vh">Submit</button>
            </form>
        </div>
    </div>
</body>

</html>

<script src="../javascript/scriptAlmacenes.js"></script>
<script src="../javascript/scriptUsuario.js"></script>
