<x-layout titulo='Troncales'>
    @include('troncales.create')
    <h2>Troncales</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Cantidad almacenes</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($troncales as $troncal)
                <tr>
                    <td><a href="{{ route('troncales.show', $troncal) }}"> {{ $troncal->ID }}</a>
                    </td>
                    <td>{{ $troncal->nombre }}</td>
                    <td>{{ count($troncal->ordenes) }}</td>
                    <td>

                        @if ($troncal->baja)
                            de baja
                        @else
                            operativo
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>`

</x-layout>
