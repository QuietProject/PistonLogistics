<x-layout menu="6" titulo="Clientes" import1="../css/styleClientesShow.css">
    <div class="display">
        <h2 class="titleText">{{ __("Clientes") }}</h2>
        <div class="infoBox" style="left: 51vw">
            <p>RUT: {{ $cliente->RUT }}</p>
            <p>{{ __("Nombre") }}: {{ $cliente->nombre }}</p>
            <form action="{{ route('clientes.destroy', $cliente->RUT) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="modBtn">
                    @if ($cliente->baja)
                        {{ __("Dar de Alta") }}
                    @else
                        {{ __("Dar de Baja") }}
                    @endif
                </button>
            </form>
            </p>
        </div>
        <h3 class="tableTitle">{{ __("Almacenes") }}</h3>
        <div class="tableContainer">
            @if (count($cliente->almacenes) > 0)
                <table class="tableView">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>{{ __("Nombre") }}</th>
                            <th>{{ __("Direccion") }}</th>
                            <th>{{ __("Estado") }}</th>
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
                <p>{{ __("Este cliente no tiene ningun almacen todavia") }}</p>
            @endif
        </div>
    </div>
</x-layout>

<script src="../javascript/scriptAdministrador.js"></script>
