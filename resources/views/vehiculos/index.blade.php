<x-layout titulo='Vehiculos'>
    @include('vehiculos.create')
    <h2>Camiones</h2>
    <table>
        <thead>
            <tr>
                <th>matricula</th>
                <th>Volumen maximo</th>
                <th>Peso maximo</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($camiones as $camion)
                <tr>
                    <td><a href="{{ route('vehiculos.show', $camion->matricula) }}"> {{ $camion->matricula }}</a>
                    </td>
                    <td>{{ $camion->peso_max }}kg</td>
                    <td>{{ $camion->vol_max }}m3</td>
                    <td>
                        @if ($camion->baja)
                            de baja
                        @else
                            @if ($camion->es_operativo)
                                operativo
                            @else
                                fuera de servicio
                            @endif
                        @endif
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
            </tr>
        </thead>
        <tbody>
            @foreach ($camionetas as $camioneta)
                <tr>
                    <td><a href="{{ route('vehiculos.show', $camioneta->matricula) }}"> {{ $camioneta->matricula }}</a>
                    </td>
                    <td>{{ $camioneta->peso_max }}kg</td>
                    <td>{{ $camioneta->vol_max }}m3</td>
                    <td>
                        @if ($camioneta->baja)
                            de baja
                        @else
                            @if ($camioneta->es_operativo)
                                operativo
                            @else
                                fuera de servicio
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</x-layout>
