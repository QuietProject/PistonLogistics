

<x-layout titulo='{{ $tipo }}'>

    <h2>{{ $tipo }}</h2>
    <p>Matricula: {{ $vehiculo->matricula }}</p>
    <p>Peso Maximo: {{ $vehiculo->peso_max/1000 }}kg</p>
    <p>Volumen Maximo: {{ $vehiculo->vol_max/1000 }}m3</p>
    <p>Estado:
        @if ($vehiculo->es_operativo)
            operativo
        @else
            fuera de servicio
        @endif
    </p>
    <p>
    <form action="{{ route('vehiculos.destroy', $vehiculo->matricula) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">
            @if ($vehiculo->baja)
                Dar de Alta
            @else
                Dar de Baja
            @endif
        </button>
    </form>
    </p>
    <p><a href="{{ route('vehiculos.edit', $vehiculo) }}">Editar</a></p>

    <a href="{{ route('vehiculos.index') }}">Volver</a>


</x-layout>
