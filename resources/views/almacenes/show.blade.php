<?php
// $estado = 'fuera de servicio';
// if ($vehiculo->baja) {
//     $estado = 'de baja';
// } elseif ($vehiculo->es_operativo) {
//     $estado = 'operativo';
// }
?>
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
        <a href="{{ route('almacenes.index') }}" class="button active"></a>
        <a href="{{ route('troncales.index') }}" class="button inactive"></a>
        <a href="{{ route('vehiculos.index') }}" class="button inactive"></a>
        <a href="{{ route('clientes.index') }}" class="button inactive"></a>
    </div>
    <div class="display">
        <h2 class="titleText">Almacen {{ $tipo }}</h2>
        <div class="infoBox" style="left: 5vw">
            @if ($tipo == 'propio')
                <p>Paquetes 'sueltos' en el almacen: {{ $paquetesEnAlmacen }}</p>
                <p>Total de paquetes en que pasaron por el almacen: {{ $paquetesRecibidos }}</p>
                <p>Lotes para desarmar en el almacen: {{ $lotesParaDesarmar }}</p>
                <p>Lotes en el almacen prontos para llevar : {{ $lotesProntos }}</p>
                <p>Lotes en preparacion en el almacen: {{ $lotesEnPreparacion }}</p>
                <p>Total de lotes recibidos en el almacen: {{ $lotesRecibidos }}</p>
                <p>Total de lotes creados en el almacen: {{ $lotesCreados }}</p>
            @else
                <p>Paquetes esperando en el almacenen: {{ $paquetesEnCliente }}</p>
                <p>Paquetes encargados por almacen que ya fueron entregados: {{ $paquetesEntregadosCliente }}</p>
                <p>Total de paquetes encargados por el almacen: {{ $paquetesEncargados }}</p>
            @endif
        </div>
        <div class="infoBox" style="left: 51vw; top: 35vh">
            <p>ID: {{ $almacen->ID }}</p>
            <p>Nombre: {{ $almacen->nombre }}</p>
            <p>Direccion: {{ $almacen->direccion }}</p>
            <p>Latitud: {{ $almacen->latitud }}</p>
            <p>Longitud: {{ $almacen->longitud }}</p>
            <form action="{{ route('almacenes.destroy', $almacen->ID) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="modBtn">
                    @if ($almacen->baja)
                        Dar de Alta
                    @else
                        Dar de Baja
                    @endif
                </button>
            </form>
        </div>
        @if ($tipo == 'cliente')
            <p>Cliente: <a href="{{ route('clientes.show', $cliente) }}">{{ $cliente->nombre }}</a>
            <p>
        @endif
        <div class="editTop">
            <h2>Editar Almacen {{ $tipo }}</h2>
            <form action="{{ route('almacenes.update', $almacen) }}" method="POST">
                @csrf
                @method('PATCH')
                <div style="margin-top: 1vh">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" required
                        value="{{ old('nombre', $almacen->nombre) }}">
                    @error('nombre')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div style="margin-top: 1vh">
                    <label for="direccion">Direccion</label>
                    <input type="text" name="direccion" id="direccion" step="0.1"
                        value="{{ old('direccion', $almacen->direccion) }}">
                    @error('direccion')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="modBtn">Submit</button>
            </form>
        </div>
    </div>
</body>

</html>

<script src="../javascript/scriptAlmacenes.js"></script>
<script src="../javascript/scriptUsuario.js"></script>
