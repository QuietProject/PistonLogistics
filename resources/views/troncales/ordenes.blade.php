<x-layout titulo='Ordenes'>
    <h2>Troncal</h2>
    <p>ID: {{ $troncal->ID }}</p>
    <p>Nombre: {{ $troncal->nombre }}</p>

    <form action="{{ route('ordenes.update', $troncal->ID) }}" method="POST">
        @csrf
        @method('PATCH')
        <input type="text" name="ordenes">
        <button type="submit"></button>
    </form>
    <h3>Ordenes</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>almacen</th>
                <th>Posicion</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ordenes as $orden)
                <tr>
                    <td><a href="{{ route('almacenes.show', $orden->ID_almacen) }}" target="blank">{{ $orden->ID_almacen }}</a></td>
                    <td>{{ $orden->nombre }}</td>
                    <td>{{ $loop->iteration }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Almacenes</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>almacen</th>
                <th>direccion</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($almacenes as $almacen)
                <tr>
                    <td><a href="{{ route('almacenes.show', $almacen->ID) }}" target="blank"> {{ $almacen->ID }}</td>
                    <td>{{ $almacen->nombre }}
                    <td>
                    <td>{{ $almacen->direccion }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>`
    <a href="{{ route('troncales.index') }}">Volver</a>

</x-layout>
