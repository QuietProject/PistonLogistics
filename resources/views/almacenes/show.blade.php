<x-layout menu="3" titulo="Almacen" import1="../css/styleAlmacenesShow.css">
    <div class="display">
        <h2 class="titleText">Almacen {{ $tipo }}</h2>
        <div class="infoBox" style="left: 7.5vw">
            @if ($tipo == 'propio')
                <div style="margin-top: 1vh; display: flex; justify-content: space-between">
                    <p>Paquetes 'sueltos' en el almacen: </p>
                    <p>{{ $paquetesEnAlmacen }}</p>
                </div>
                <div style="margin-top: 1vh; display: flex; justify-content: space-between">
                    <p>Total de paquetes en que pasaron por el almacen: </p>
                    <p>{{ $paquetesRecibidos }}</p>
                </div>
                <div style="margin-top: 1vh; display: flex; justify-content: space-between">
                    <p>Lotes para desarmar en el almacen: </p>
                    <p>{{ $lotesParaDesarmar }}</p>
                </div>
                <div style="margin-top: 1vh; display: flex; justify-content: space-between">
                    <p>Lotes en el almacen prontos para llevar : </p>
                    <p>{{ $lotesProntos }}</p>
                </div>
                <div style="margin-top: 1vh; display: flex; justify-content: space-between">
                    <p>Lotes en preparacion en el almacen: </p>
                    <p>{{ $lotesEnPreparacion }}</p>
                </div>
                <div style="margin-top: 1vh; display: flex; justify-content: space-between">
                    <p>Total de lotes recibidos en el almacen: </p>
                    <p>{{ $lotesRecibidos }}</p>
                </div>
                <div style="margin-top: 1vh; display: flex; justify-content: space-between">
                    <p>Total de lotes creados en el almacen: </p>
                    <p>{{ $lotesCreados }}</p>
                </div>

                @if (count($troncales) == 0)
                    <p style="margin-top:10vh; font-size: 3vh; font-weight: 500">El almacen no se encuentra en ninguna troncal</p>
                @else
                    <div class="tableContainer">
                        <table class="tableView">
                            <thead>
                                <tr>
                                    <th style="width: 50%">ID</th>
                                    <th style="width: 50%">Nombre</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($troncales as $troncal)
                                    <tr>
                                        <td><a
                                                href="{{ route('troncales.show', $troncal->ID) }}">{{ $troncal->ID }}</a>
                                        </td>
                                        <td>{{ $troncal->nombre }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            @else
                <div class="inputAlgo">
                    <p>Paquetes esperando en el almacenen: </p>
                    <p>{{ $paquetesEnCliente }}</p>
                </div>
                <div class="inputAlgo">
                    <p>Paquetes encargados al comprador de este almacen: </p>
                    <p>{{ $paquetesEntregadosCliente }}</p>
                </div>
                <div style="margin-top: 1vh; display: flex; justify-content: space-between">
                    <p>Total de paquetes encargados por el almacen: </p>
                    <p>{{ $paquetesEncargados }}</p>
                </div>
            @endif
        </div>
        <div class="infoBox" style="left: 62.5vw; width: 20vw; top: 35vh">
            <div style="margin-top: 1vh; display: flex; justify-content: space-between">
                <p style="font-weight: 500">ID: </p>
                <p>{{ $almacen->ID }}</p>
            </div>
            <div style="margin-top: 1vh; display: flex; justify-content: space-between">
                <p style="font-weight: 500">Nombre: </p>
                <p>{{ $almacen->nombre }}</p>
            </div>
            <div style="margin-top: 1vh; display: flex; justify-content: space-between">
                <p style="font-weight: 500">Direccion: </p>
                <p style="text-align: right">{{ $almacen->direccion }}</p>
            </div>
            <div style="margin-top: 1vh; display: flex; justify-content: space-between">
                <p style="font-weight: 500">Latitud: </p>
                <p>{{ $almacen->latitud }}</p>
            </div>
            <div style="margin-top: 1vh; display: flex; justify-content: space-between">
                <p style="font-weight: 500">Longitud: </p>
                <p>{{ $almacen->longitud }}</p>
            </div>
            @if ($tipo == 'cliente')
                <div style="margin-top: 1vh; display: flex; justify-content: space-between">
                    <p style="font-weight: 500">Cliente: </p>
                    <p><a href="{{ route('clientes.show', $cliente) }}">{{ $cliente->nombre }}</a></p>
                </div>
            @endif
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
        <div class="editTop">
            <h2>Editar Almacen {{ $tipo }}</h2>
            <form action="{{ route('almacenes.update', $almacen) }}" method="POST">
                @csrf
                @method('PATCH')
                <div style="margin-top: 1vh; margin-top: 1vh; display: flex; justify-content: space-between">
                    <label for="nombre" style="font-size: 2vh">Nombre</label>
                    <input type="text" name="nombre" id="nombre" required
                        value="{{ old('nombre', $almacen->nombre) }}">
                    @error('nombre')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div style="margin-top: 1vh; margin-top: 1vh; display: flex; justify-content: space-between">
                    <label for="direccion" style="font-size: 2vh">Direccion</label>
                    <input type="text" name="direccion" id="direccion" step="0.1"
                        value="{{ old('direccion', $almacen->direccion) }}">
                    @error('direccion')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="modBtn">Confirmar</button>
            </form>
        </div>
    </div>
</x-layout>
<script src="../javascript/scriptAlmacenes.js"></script>
<script src="../javascript/scriptUsuario.js"></script>
