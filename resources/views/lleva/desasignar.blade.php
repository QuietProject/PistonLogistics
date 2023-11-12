<x-layout titulo='Lleva' menu='7'>
    <h2>Asignar lotes a camiones</h2>
    <table tableView" id="tableDriver">
        <thead>
            <tr>
                <th onclick="sortTable(0);arrowsTable(0);" id="0">Lote </th>
                <th onclick="sortTable(1);arrowsTable(1);" id="1">Codigo</th>
                <th onclick="sortTable(1);arrowsTable(1);" id="2">Pronto desde</th>
                <th onclick="sortTable(1);arrowsTable(1);" id="3">Almacen origen</th>
                <th onclick="sortTable(2);arrowsTable(2);" id="4">Almacen destino</th>
                <th onclick="sortTable(3);arrowsTable(3);" id="5">Troncal</th>
                <th onclick="sortTable(4);arrowsTable(4);" id="6">peso</th>
                <th onclick="sortTable(5);arrowsTable(5);" id="7">cantidad</th>
                <th onclick="sortTable(1);arrowsTable(1);" id="8">Fecha asignado</th>
                <th onclick="sortTable(1);arrowsTable(1);" id="9">Camion</th>
                <th onclick="sortTable(6);arrowsTable(6);" id="10">Desasignar</th>
            </tr>
        </thead>
        <tbody>
            @if (count($lotes) == 0)
                No hay lotes para asignar
            @else
                @foreach ($lotes as $lote)
                    <tr>
                        <td>{{ $lote->id }}</td>
                        <td>{{ $lote->codigo }}</td>
                        <td>{{ \Carbon\Carbon::parse($lote->pronto)->format('d/m/y H:i')}}</td>
                        <td><a href="{{ route('almacenes.show', $lote->origen) }}"> {{ $lote->origen }}</a></td>
                        <td><a href="{{ route('almacenes.show', $lote->destino) }}"> {{ $lote->destino }}</a></td>
                        <td><a href="{{ route('troncales.show', $lote->troncal) }}"> {{ $lote->troncal }}</a></td>
                        <td>{{ $lote->peso }}kg</td>
                        <td>{{ $lote->cantidad }}</td>
                        <td>{{ \Carbon\Carbon::parse($lote->fecha_asignado)->format('d/m/y H:i')}}</td>
                        <td><a href="{{ route('vehiculos.show', $lote->matricula) }}"> {{ $lote->matricula }}</a></td>
                        <td>
                            <form action="{{ route('lleva.destroy', $lote->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="switchBtn">
                                    Desasignar
                                </button>
                                </form>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</x-layout>
