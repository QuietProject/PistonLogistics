<x-layout titulo='Camionero'>
    <h2>Camionero</h2>

    <p>Cedula: {{ $camionero->CI }}</p>
    <p>Nombre: {{ $camionero->nombre }} {{ $camionero->apellido }}</p>
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
    <p><a href="{{ route('camioneros.edit',$camionero) }}">Editar</a></p>

    <a href="{{ route('camioneros.index') }}">Volver</a>


</x-layout>
