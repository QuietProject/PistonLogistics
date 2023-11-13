<x-layout titulo='Lleva' menu='7' import1="../css/styleLlevaReparteTrae.css">
    <div class="display">
        <h2 class="titleText">Asignar lotes a camiones</h2>
        <input type="text" id="searchInput" class="filterText" placeholder="Search" onkeyup="searchFilter()">
        @if (count($lotes) != 0)
            <div class="tableContainer">
                <table id="tableDriver" class="tableView">
                    <thead>
                        <tr>
                            <th onclick="sortTable(0);arrowsTable(0);" id="0" style="width:10%">Lote </th>
                            <th onclick="sortTable(1);arrowsTable(1);" id="1" style="width:10%">Codigo</th>
                            <th onclick="sortTable(2);arrowsTable(2);" id="2" style="width:15%">Pronto desde
                            </th>
                            <th onclick="sortTable(3);arrowsTable(3);" id="3" style="width:12.5%">Almacen origen
                            </th>
                            <th onclick="sortTable(4);arrowsTable(4);" id="4" style="width:12.5%">Almacen
                                destino</th>
                            <th onclick="sortTable(5);arrowsTable(5);" id="5" style="width:10%">Troncal</th>
                            <th onclick="sortTable(6);arrowsTable(6);" id="6" style="width:10%">Peso</th>
                            <th onclick="sortTable(7);arrowsTable(7);" id="7" style="width:10%">Cantidad</th>
                            <th onclick="sortTable(8);arrowsTable(8);" id="8" style="width:10%">Asignar</th>
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
                                <td><a href="{{ route('lleva.show', $lote->id) }}">Asignar</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                </table>
            </div>
        @else
            <p class="textNegative">No hay lotes para asignar</p>
        @endif
    </div>
</x-layout>
<script src="../javascript/scriptCamionero.js"></script>
