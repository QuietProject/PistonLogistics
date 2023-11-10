<x-layout titulo='Lleva'>
    <h2>Asignar lotes a camiones</h2>
    <table tableView" id="tableDriver">
        <thead>
            <tr>
                <th onclick="sortTable(0);arrowsTable(0);" id="0">Lote </th>
                <th onclick="sortTable(1);arrowsTable(1);" id="1">Almacen origen</th>
                <th onclick="sortTable(2);arrowsTable(2);" id="2">Almacen destino</th>
                <th onclick="sortTable(3);arrowsTable(3);" id="3">Troncal</th>
                <th onclick="sortTable(4);arrowsTable(4);" id="4">peso</th>
                <th onclick="sortTable(5);arrowsTable(5);" id="5">cantidad</th>
                <th onclick="sortTable(6);arrowsTable(6);" id="6">Asignar</th>
            </tr>
        </thead>
        <tbody>
            @if (count($lotes) == 0)
                No hay lotes para asignar
            @else
                @foreach ($lotes as $lote)
                    <tr>
                        <td>{{ $lote->id }}</td>
                        <td><a href="{{ route('almacenes.show', $lote->origen) }}"> {{ $lote->origen }}</a></td>
                        <td><a href="{{ route('almacenes.show', $lote->destino) }}"> {{ $lote->destino }}</a></td>
                        <td><a href="{{ route('troncales.show', $lote->troncal) }}"> {{ $lote->troncal }}</a></td>
                        <td>{{ $lote->peso }}kg</td>
                        <td>{{ $lote->cantidad }}</td>
                        <td><a href="{{ route('lleva.show', $lote->id) }}">Asignar</a></td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</x-layout>