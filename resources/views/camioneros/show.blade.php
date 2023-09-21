<x-layout titulo='Camionero'>
    <h2>Camionero</h2>

    <span>{{ $camionero->CI }}</span>
    <span>{{ $camionero->nombre }}</span>
    <span>{{ $camionero->apellido }}</span>
    <span>
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
    </span>

    <a href="{{ route('camioneros.index') }}">Volver</a>


</x-layout>
