<x-layout titulo='Clientes'>
    <h2>Clientes</h2>

    <p>Rut: {{ $cliente->RUT }}</p>
    <p>Nombre: {{ $cliente->nombre }}
    <p>
    <p>
    <form action="{{ route('clientes.destroy', $cliente->RUT) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">
            @if ($cliente->baja)
                Dar de Alta
            @else
                Dar de Baja
            @endif
        </button>
    </form>
    </p>
    <p><a href="{{ route('clientes.edit', $cliente) }}">Editar</a></p>

    <a href="{{ route('camioneros.index') }}">Volver</a>

    <h3>Almacenes</h3>
    @if (count($almacenes) > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Direccion</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($almacenes as $almacen)
                    @php
                        $almacen = $almacen->almacen()->first();
                    @endphp
                    <tr>
                        <td><a href="#">{{ $almacen->ID }}</a></td>
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

</x-layout>
