<x-layout menu="6" titulo="Clientes" import1="../css/styleClientesShow.css">
    <div class="display">
        <h2 class="titleText">Clientes</h2>
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
</x-layout>

<script src="../javascript/scriptAdministrador.js"></script>
