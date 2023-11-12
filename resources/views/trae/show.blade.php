<x-layout titulo='Lleva' menu='7'>

    <h2>Asignar Paquete {{ $paquete->ID_paquete }}</h2>
    <div>
        <h3>Paquete:</h3>
        <p>ID: {{ $paquete->ID_paquete }}</p>
        <p>ID: {{ $paquete->codigo }}</p>
        <p>Fecha registrado: {{ \Carbon\Carbon::parse($paquete->fecha_registrado)->format('d/m/y H:i') }}</p>
        <p>En Almacen: <a target="_blank"
                href="{{ route('almacenes.show', $paquete->ID_almacen) }}">{{ $paquete->ID_almacen }} -
                {{ $paquete->nombre }}</a></p>
        <p>En Almacen: <a target="_blank" href="{{ route('clientes.show', $paquete->RUT) }}">{{ $paquete->cliente }} -
                {{ $paquete->nombre }}</a></p>
    </div>
    <form action="{{ route('trae.store', $paquete->ID_paquete) }}" method="POST">
        @csrf
        <h3>Elegir vehiculo</h3>
        <table>
            <thead>
                <tr>
                    <th>Matricula</th>
                    <th>Paquetes asignados</th>
                    <th>Peso maximo</th>
                    <th>Tipo</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vehiculos as $vehiculo)
                    <tr>
                        <td>{{ $vehiculo->matricula }}</td>
                        <td>{{ $vehiculo->paquetes_asignados }}</td>
                        <td>{{ $vehiculo->peso_max }}kg</td>
                        <td>{{ $vehiculo->tipo == 1 ? 'camioneta' : 'camion' }}</td>
                        <td><input type="radio" name="vehiculo" value="{{ $vehiculo->matricula }}"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit">Asignar</button>
    </form>

</x-layout>
