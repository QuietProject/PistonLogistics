<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="#">
    <link rel="stylesheet" href="../css/style.css ">
    <link rel="stylesheet" href="../css/styleAlmacenesShow.css">
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
    <div class="display">
        <h2 class="titleText">Clientes</h2>
        <div class="editTop">
            <h2>Editar Cliente</h2>
            <form action="{{ route('clientes.update', $cliente) }}" method="POST">
                @csrf
                @method('PATCH')
                <div>
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $cliente->nombre) }}">
                    @error('nombre')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="modBtn">Submit</button>

            </form>
        </div>
        <div class="infoBox" style="left: 51vw">
            <p>Rut: {{ $cliente->RUT }}</p>
            <p>Nombre: {{ $cliente->nombre }}</p>
            <form action="{{ route('clientes.destroy', $cliente->RUT) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="modBtn">
                    @if ($cliente->baja)
                        Dar de Alta
                    @else
                        Dar de Baja
                    @endif
                </button>
            </form>
            </p>
        </div>
        <h3 class="tableTitle">Almacenes</h3>
        <div class="tableContainer">
            @if (count($cliente->almacenes) > 0)
                <table class="tableView">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Direccion</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cliente->almacenes as $almacen)
                            <tr>
                                <td><a href="{{ route('almacenes.show', $almacen) }}">{{ $almacen->ID }}</a></td>
                                <td>{{ $almacen->nombre }}</td>
                                <td>{{ $almacen->direccion }}</td>
                                <td>{{ $almacen->baja ? 'baja' : 'alta' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Este cliente no tiene ningun almacen todavia</p>
            @endif
        </div>
    </div>
</body>

</html>

<script src="../javascript/scriptAdministrador.js"></script>
