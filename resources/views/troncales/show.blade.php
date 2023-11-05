<x-layout titulo='Troncal'>
    @include('troncales.edit')
    <h2>Troncal</h2>
    <p>ID: {{ $troncal->ID }}</p>
    <p>Nombre: {{ $troncal->nombre }}</p>
    <form action="{{ route('troncales.destroy', $troncal->ID) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">
            @if ($troncal->baja)
                Dar de Alta
            @else
                Dar de Baja
            @endif
        </button>
    </form>
    <a href="{{ route('ordenes.edit',$troncal) }}">Editar ordenes</a>

    <h3>Ordenes</h3>
    <table>
        <thead>
            <tr>
                <th>almacen</th>
                <th>Numero</th>
                <th>Baja</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ordenes as $orden)
                <tr>
                    <td><a href="{{ route('almacenes.show', $orden->ID_almacen) }}"> {{ $orden->ID_almacen }} -
                            {{ $orden->nombre }}</a></td>
                    <td>{{ $orden->orden }}</td>
                    <td>
                        @if (!$orden->almacenBaja)
                            De alta
                        @else
                            El almacen esta dado de baja
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('troncales.index') }}">Volver</a>

</x-layout>
