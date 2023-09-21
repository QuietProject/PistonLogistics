<x-layout
    titulo='Camioneros'
>

    <h2>Camioneros</h2>
    <a href="{{ route('camioneros.create') }}">Insertar camionero</a>
    <table>
        <thead>
            <tr>
                <th>CI</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($camioneros as $camionero)

                <tr>
                    <td><a href="{{ route('camioneros.show', $camionero->CI) }}"> {{ $camionero->CI }}</a> </td>
                    <td>{{ $camionero->nombre }}</td>
                    <td>{{ $camionero->apellido }}</td>
                    <td>
                        <form action="{{ route('camioneros.destroy', $camionero->CI) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">
                                @if($camionero->baja)
                                Dar de Alta
                                @else
                                Dar de Baja
                                @endif</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

   </x-layout>
