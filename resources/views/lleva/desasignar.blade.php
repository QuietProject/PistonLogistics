<x-layout titulo='Lleva' menu='7' import1="../css/styleLlevaReparteTrae.css">
    <div class="display">
        <h2 class="titleText">{{ __("Lotes asignados a camiones") }}</h2>
        <input type="text" id="searchInput" class="filterText" placeholder={{ __('Buscar') }}
        onkeyup="searchFilter()">
        @if (count($lotes) == 0)
            <p class="textNegative">{{ __("No hay lotes para asignar") }}</p>
        @else
            <div class="tableContainer">
                <table tableView id="tableDriver" class="tableView">
                    <thead>
                        <tr>
                            <th onclick="sortTable(0);arrowsTable(0);" id="0">{{ __("Lote") }}</th>
                            <th onclick="sortTable(1);arrowsTable(1);" id="1">{{ __("Codigo") }}</th>
                            <th onclick="sortTable(2);arrowsTable(2);" id="2">{{ __("Pronto desde") }}</th>
                            <th onclick="sortTable(3);arrowsTable(3);" id="3">{{ __("Almacen origen") }}</th>
                            <th onclick="sortTable(4);arrowsTable(4);" id="4">{{ __("Almacen destino") }}</th>
                            <th onclick="sortTable(5);arrowsTable(5);" id="5">{{ __("Troncal") }}</th>
                            <th onclick="sortTable(6);arrowsTable(6);" id="6">{{ __("Peso") }}</th>
                            <th onclick="sortTable(7);arrowsTable(7);" id="7">{{ __("Cantidad") }}</th>
                            <th onclick="sortTable(8);arrowsTable(8);" id="8">{{ __("Fecha asignado") }}</th>
                            <th onclick="sortTable(9);arrowsTable(9);" id="9">{{ __("Camion") }}</th>
                            <th onclick="sortTable(10);arrowsTable(10);" id="10">{{ __("Desasignar") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lotes as $lote)
                            <tr>
                                <td>{{ $lote->id }}</td>
                                <td>{{ $lote->codigo }}</td>
                                <td>{{ \Carbon\Carbon::parse($lote->pronto)->format('d/m/y H:i') }}</td>
                                <td><a href="{{ route('almacenes.show', $lote->origen) }}"> {{ $lote->origen }}</a></td>
                                <td><a href="{{ route('almacenes.show', $lote->destino) }}"> {{ $lote->destino }}</a>
                                </td>
                                <td><a href="{{ route('troncales.show', $lote->troncal) }}"> {{ $lote->troncal }}</a>
                                </td>
                                <td>{{ $lote->peso }}kg</td>
                                <td>{{ $lote->cantidad }}</td>
                                <td>{{ \Carbon\Carbon::parse($lote->fecha_asignado)->format('d/m/y H:i') }}</td>
                                <td><a href="{{ route('vehiculos.show', $lote->matricula) }}">
                                        {{ $lote->matricula }}</a>
                                </td>
                                <td>
                                    <form action="{{ route('lleva.destroy', $lote->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="switchBtn">
                                            {{ __("Desasignar") }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-layout>
<script src="../javascript/scriptConductor.js"></script>