<x-layout titulo='Clientes'>
    <h2>Clientes</h2>

    <p>Rut: {{ $cliente->RUT }}</p>
    <p>Nombre: {{ $cliente->nombre }}<p>
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
{{-- 
    <h3>Almacenes</h3>
    @if (count($almacenes) > 0)
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
                        <td><a href="{{ route('vehiculos.show', $vehiculo->matricula) }}">
                                {{ $vehiculo->matricula }}</a>
                        </td>
                        <td>{{ $vehiculo->desde }}</td>
                        <td>{{ $vehiculo->hasta != null ? $vehiculo->hasta : 'Conduciendo' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Este conductor/a no ha conducido ningun camion hasta el momento</p>
    @endif --}}

</x-layout>
