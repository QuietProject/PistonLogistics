<x-layout titulo='Clientes'>
    <h2>Clientes</h2>
    <a href="{{ route('clientes.create') }}">Insertar cliente</a>
    <table>
        <thead>
            <tr>
                <th>Rut</th>
                <th>Nombre</th>
                <th>Baja</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clientes as $cliente)
                <tr>
                    <td><a href="{{ route('clientes.show', $cliente->RUT) }}"> {{ $cliente->RUT }}</a> </td>
                    <td>{{ $cliente->nombre }}</td>
                    <td>
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
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</x-layout>
