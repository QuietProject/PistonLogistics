<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="#">
    <link rel="stylesheet" href="../css/style.css ">
    <link rel="stylesheet" href="../css/styleCamioneroShow.css">
    <script src="https://kit.fontawesome.com/b9577afa32.js" crossorigin="anonymous"></script>
    <title>Piston Logistics</title>
</head>

<body>
    <div class="navDiv">
        <a href="{{ route('camioneros.index') }}" class="button active"></a>
        <a href="{{ route('usuarios.index') }}" class="button inactive" id="btnRutes"></a>
        <a href="{{ route('almacenes.index') }}" class="button inactive" id="btnWarehouses"></a>
        <a href="{{ route('troncales.index') }}" class="button inactive" id="btnProducts"></a>
        <a href="{{ route('vehiculos.index') }}" class="button inactive"></a>
        <a href="{{ route('clientes.index') }}" class="button inactive"></a>
    </div>
    <div class="display">
        <p class="titleText">Nombre: {{ $camionero->nombre }}</p>
        <p class="titleText" style="top: 11vh">Cedula: {{ $camionero->CI }}</p>
        <p>
        <form action="{{ route('camioneros.destroy', $camionero->CI) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="switchBtn">
                @if ($camionero->baja)
                    Dar de Alta
                @else
                    Dar de Baja
                @endif
            </button>
        </form>
        </p>
        {{-- <a href="{{ route('camioneros.index') }}">Volver</a> --}}
        <h3 class="tableTitle">Historial de vehiculos</h3>
        @if (count($vehiculos) > 0)
            <div class="tableContainer">
                <table class="tableView">
                    <thead>
                        <tr>
                            <th>Matricula</th>
                            <th>Desde</th>
                            <th>Hasta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vehiculos as $vehiculo)
                            <tr>
                                <td><a href="{{ route('vehiculos.show', $vehiculo->matricula) }}">
                                        {{ $vehiculo->matricula }}</a>
                                </td>
                                <td>{{\Carbon\Carbon::parse( $vehiculo->desde)->format('d/m/y H:i') }}</td>
                                <td>{{ $vehiculo->hasta != null ? \Carbon\Carbon::parse($vehiculo->hasta)->format('d/m/y H:i') : 'Conduciendo' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>Este conductor/a no ha conducido ningun camion hasta el momento</p>
        @endif
        <div class="editContainer">
            <p class="asignadoText">Vehiculo asignado:
                @if (isset($vehiculos[0]) && $vehiculos[0]->hasta == null)
                    <a
                        href="{{ route('vehiculos.show', $vehiculos[0]->matricula) }}">{{ $vehiculos[0]->matricula }}</a>
                    <form
                        action="{{ route('conducen.hasta', ['matricula' => $vehiculos[0]->matricula, 'ci' => $camionero->CI]) }}"
                        method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="assignVehicleBtn"> Dejar de conducir</button>
                    </form>
                @else
                    no tiene
                    @if (!$camionero->baja)
                        <a href="{{ route('conducen.camionero', ['camionero' => $camionero->CI]) }}">Asignar
                            vehiculo</a>
                    @endif
                @endif
            </p>
            @if ($errors->any())
                abre el formulario
            @endif
            <h2 class="asignadoText" style="margin-top: 10vh">Editar Camionero</h2>
            <form action="{{ route('camioneros.update', $camionero) }}" method="POST">
                @csrf
                @method('PATCH')
                <div>
                    <label for="nombre" style="color: white">Nombre: </label>
                    <input type="text" name="nombre" id="nombre"
                        value="{{ old('nombre', $camionero->nombre) }}">
                    @error('nombre')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="modBtn">Submit</button>
            </form>
        </div>
    </div>
</body>

</html>

<script src="../javascript/scriptAdministrador.js"></script>
