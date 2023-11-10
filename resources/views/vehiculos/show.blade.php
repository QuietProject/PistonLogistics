<?php
$estado = 'fuera de servicio';
if ($vehiculo->baja) {
    $estado = 'de baja';
} elseif ($vehiculo->es_operativo) {
    $estado = 'operativo';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="#">
    <link rel="stylesheet" href="../css/style.css ">
    <link rel="stylesheet" href="../css/styleVehiculosShow.css">
    <script src="https://kit.fontawesome.com/b9577afa32.js" crossorigin="anonymous"></script>
    <title>Piston Logistics</title>
</head>

<body>
    <div class="navDiv">
        <a href="{{ route('camioneros.index') }}" class="button inactive"></a>
        <a href="{{ route('usuarios.index') }}" class="button inactive" id="btnRutes"></a>
        <a href="{{ route('almacenes.index') }}" class="button inactive" id="btnWarehouses"></a>
        <a href="{{ route('troncales.index') }}" class="button inactive" id="btnProducts"></a>
        <a href="{{ route('vehiculos.index') }}" class="button active"></a>
        <a href="{{ route('clientes.index') }}" class="button inactive"></a>
    </div>
    <div class="display">
        <h2 class="titleText">{{ $tipo }}</h2>
        @if (count($trae) > 0)
            <h3>Trae paquetes:</h3>
            @foreach ($trae as $paquete)
                <p>ID:{{ $paquete->ID_paquete }}</p>
            @endforeach
        @endif

        @if (count($lleva) > 0)
            <h3>Lleva lotes:</h3>
            @foreach ($lleva as $lote)
                <p>ID:{{ $lote->ID_lote }}</p>
            @endforeach
        @endif

        @if (count($reparte) > 0)
            <h3>Reparte paquetes:</h3>
            @foreach ($reparte as $paquete)
                <p>ID:{{ $paquete->ID_paquete }}</p>
            @endforeach
        @endif
        <h3 class="tableTitle">Historial de conductores</h3>
        <div class="tableContainer">
            @if (count($camioneros) > 0)
                <table class="tableView">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Desde</th>
                            <th>Hasta</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($camioneros as $camionero)
                            <tr>
                                <td><a href="{{ route('camioneros.show', $camionero->CI) }}">
                                        {{ $camionero->nombre }}</a>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($camionero->desde)->format('d/m/y H:i')  }}</td>
                                <td>{{ $camionero->hasta != null ? \Carbon\Carbon::parse($camionero->hasta)->format('d/m/y H:i') : 'Conduciendo' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Este vehiculo no ha sido conducido por ningun conductor/a hasta el momento</p>
            @endif
        </div>

        <div class="editContainer">
            <h2 class="asignadoText">Editar {{ $tipo }}</h2>
            <form action="{{ route('vehiculos.update', $vehiculo) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="inputBox">
                    <label for="peso_max" class="asignadoText">Peso Maximo</label>
                    <input type="number" name="peso_max" id="peso_max" required
                        value="{{ old('peso_max', $vehiculo->peso_max) }}" autocomplete="off" style="font-weight: 500">
                    <span class="asignadoText">kg</span>
                    @error('peso_max')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="modBtn">Submit</button>
            </form>
            <p class="asignadoText" style="margin-top: 15vh">Matricula: {{ $vehiculo->matricula }}</p>
            <p class="asignadoText">Peso Maximo: {{ $vehiculo->peso_max }} kg</p>
            <p class="asignadoText">Conductor:
                @if (isset($camioneros[0]) && $camioneros[0]->hasta == null)
                    <a href="{{ route('camioneros.show', $camioneros[0]->CI) }}">{{ $camioneros[0]->nombre }}</a>
                    <form
                        action="{{ route('conducen.hasta', ['matricula' => $vehiculo->matricula, 'ci' => $camioneros[0]->CI]) }}"
                        method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="modBtn"> Dejar de conducir</button>
                    </form>
                @else
                    no tiene
                    @if ($estado == 'operativo')
                        <a href="{{ route('conducen.vehiculo', ['vehiculo' => $vehiculo->matricula]) }}">Asignar
                            conductor</a>
                    @endif
                @endif
            </p>
            <p class="asignadoText">Estado: {{ $estado }}</p>
            @if (!$vehiculo->baja)
                <form action="{{ route('vehiculos.operativo', $vehiculo->matricula) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="modBtn">
                        @if ($vehiculo->es_operativo)
                            Cambiar a fuera de servicio
                        @else
                            Cambiar a operativo
                        @endif
                    </button>
                </form>
            @endif

            <form action="{{ route('vehiculos.baja', $vehiculo->matricula) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="modBtn">
                    @if ($vehiculo->baja)
                        Dar de Alta
                    @else
                        Dar de Baja
                    @endif
                </button>
            </form>
            <form action="{{ route('vehiculos.destroy', $vehiculo->matricula) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="modBtn">
                    Eliminar
                </button>
            </form>
        </div>
    </div>
</body>

</html>

<script src="../javascript/scriptAdministrador.js"></script>
