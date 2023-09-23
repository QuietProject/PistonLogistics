<x-layout titulo='Vehiculos'>
    <a href="{{ route('vehiculos.create') }}">Insertar Vehiculo</a>
    <h2>Camiones</h2>
    <table>
        <thead>
            <tr>
                <th>matricula</th>
                <th>Volumen maximo</th>
                <th>Peso maximo</th>
                <th>Estado</th>
                <th>Baja</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($camiones as $camion)
                <tr>
                    <td><a href="{{ route('vehiculos.show', $camion->matricula) }}"> {{ $camion->matricula }}</a>
                    </td>
                    <td>{{ $camion->peso_max/1000 }}kg</td>
                    <td>{{ $camion->vol_max }}</td>
                    <td>
                        @if ($camion->es_operativo)
                            operativo
                        @else
                            fuera de servicio
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('vehiculos.destroy', $camion->matricula) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">
                                @if ($camion->baja)
                                    Dar de Alta
                                @else
                                    Dar de Baja
                                @endif
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Camionetas</h2>
    <table>
        <thead>
            <tr>
                <th>matricula</th>
                <th>Volumen maximo</th>
                <th>Peso maximo</th>
                <th>Estado</th>
                <th>Baja</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($camionetas as $camioneta)
                <tr>
                    <td><a href="{{ route('vehiculos.show', $camioneta->matricula) }}"> {{ $camioneta->matricula }}</a>
                    </td>
                    <td>{{ $camioneta->peso_max/1000 }}kg</td>
                    <td>{{ $camioneta->vol_max/1000 }}m3</td>
                    <td>
                        @if ($camioneta->es_operativo)
                            operativo
                        @else
                            fuera de servicio
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('vehiculos.destroy', $camioneta->matricula) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">
                                @if ($camioneta->baja)
                                    Dar de Alta
                                @else
                                    Dar de Baja
                                @endif
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</x-layout>
