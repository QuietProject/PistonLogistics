<x-layout titulo='Camionero'>
    <h2>Camionero</h2>

    <p>Cedula: {{ $camionero->CI }}</p>
    <p>Nombre: {{ $camionero->nombre }} {{ $camionero->apellido }}</p>
    <p>Vehiculo asignado:
        @if (isset($vehiculos[0]) && $vehiculos[0]->hasta == null)
            <a href="{{ route('vehiculos.show', $vehiculos[0]->matricula) }}">{{ $vehiculos[0]->matricula }}</a>
            <form action="{{ route('conducen.hasta', [ 'matricula' =>$vehiculos[0]->matricula, 'ci'=>$camionero->CI]) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit"> Dejar de conducir</button>
            </form>
        @else
            no tiene
        @endif

    </p>
    <p>
    <form action="{{ route('camioneros.destroy', $camionero->CI) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">
            @if ($camionero->baja)
                Dar de Alta
            @else
                Dar de Baja
            @endif
        </button>
    </form>
    </p>
    <p><a href="{{ route('camioneros.edit', $camionero) }}">Editar</a></p>

    <a href="{{ route('camioneros.index') }}">Volver</a>

    <h3>Historial de vehiculos</h3>
    @if (count($vehiculos) > 0)
        <table>
            <thead>
                <tr>
                    <th>Matricula</th>
                    <th>Desde</th>
                    <th>Hasta</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($vehiculos as $vehiculo)
                    <tr>
                        <td><a href="{{ route('vehiculos.show', $vehiculo->matricula) }}"> {{ $vehiculo->matricula }}</a>
                        </td>
                        <td>{{ $vehiculo->desde }}</td>
                        <td>{{ $vehiculo->hasta != null ? $vehiculo->hasta : 'Conduciendo'  }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p>Este conductor/a no ha conducido ningun camion hasta el momento</p>
        @endif

</x-layout>
