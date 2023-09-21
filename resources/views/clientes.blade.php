<x-layout 
    titulo='Clientes'
>
    <h2>Clientes</h2>

    <table>
        <thead>
            <tr>
                <th>RUT</th>
                <th>Nombre</th>
                <th>Eliminar</th>
                </tr>
        </thead>
        <tbody>
            @foreach ( $clientes as $cliente )
            <tr>
                <td>{{ $cliente->RUT}}</td>
                <td>{{ $cliente->nombre }}</td>
                <td>
                    <form action="{{ route('clientes.destroy', $cliente->RUT) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-layout>
