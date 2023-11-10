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
        <h2 class="titleText">Editar Troncal</h2>
        <a href="{{ route('ordenes.edit', $troncal) }}" class="addButton">Editar ordenes</a>
        <h3 class="tableTitle">Almacenes</h3>
        <div class="tableContainer">
            <table class="tableView">
                <thead>
                    <tr>
                        <th style="width: 10%;" onclick="sortTable(0);arrowsTable(0);" id="0">ID</th>
                        <th style="width: 30%;" onclick="sortTable(0);arrowsTable(0);" id="0">Almacen</th>
                        <th style="width: 30%;" onclick="sortTable(0);arrowsTable(0);" id="0">Numero</th>
                        <th style="width: 30%;" onclick="sortTable(0);arrowsTable(0);" id="0">Baja</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ordenes as $orden)
                        <tr>
                            <td><a href="{{ route('almacenes.show', $orden->ID_almacen) }}">
                                    {{ $orden->ID_almacen }}</a></td>
                            <td>
                                <p>{{ $orden->nombre }}</p>
                            </td>
                            <td>{{ $orden->orden }}</td>
                            <td>
                                @if (!$orden->almacenBaja)
                                    De alta
                                @else
                                    El almacen esta dado de baja
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="editContainer">
            <p class="asignadoText">ID: {{ $troncal->ID }}</p>
            <p class="asignadoText">Nombre: {{ $troncal->nombre }}</p>
            <form action="{{ route('troncales.destroy', $troncal->ID) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="switchBtn">
                    @if ($troncal->baja)
                        Dar de Alta
                    @else
                        Dar de Baja
                    @endif
                </button>
            </form>
            <form action="{{ route('troncales.update', $troncal) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="asignadoText" style="margin-top: 7.5vh">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" required
                        value="{{ old('nombre', $troncal->nombre) }}">
                    @error('nombre')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="switchBtn">Submit</button>
            </form>
        </div>
    </div>
</body>

</html>

<script src="../javascript/scriptAdministrador.js"></script>
