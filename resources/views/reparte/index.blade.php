<x-layout titulo='Reparte' menu='7' import1="../css/styleLlevaReparteTrae.css">
    <div class="display">
        <h2 class="titleText">{{ __("Asignar paquetes a camiones para repartir") }}</h2>
        <input type="text" id="searchInput" class="filterText" placeholder={{ __("Buscar") }} onkeyup="searchFilter()">
        @if (count($paquetes) == 0)
            <p class="textNegative">{{ __("No hay paquetes para asignar") }}</p>
        @else
            <div class="tableContainer">
                <table tableView" id="tableDriver" class="tableView">
                    <thead>
                        <tr>
                            <th onclick="sortTable(0);arrowsTable(0);" id="0">{{ __("Paquete") }}</th>
                            <th onclick="sortTable(0);arrowsTable(0);" id="1">{{ __("Codigo") }}</th>
                            <th onclick="sortTable(1);arrowsTable(1);" id="2">{{ __("Almacen") }}</th>
                            <th onclick="sortTable(2);arrowsTable(2);" id="3">{{ __("Direccion destino") }}</th>
                            <th onclick="sortTable(4);arrowsTable(4);" id="4">{{ __("Peso") }}</th>
                            <th onclick="sortTable(5);arrowsTable(5);" id="5">{{ __("Fecha de ingreso al almacen") }}</th>
                            <th onclick="sortTable(6);arrowsTable(6);" id="6">{{ __("Asignar") }}</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($paquetes as $paquete)
                            <tr>
                                <td>{{ $paquete->ID_paquete }}</td>
                                <td>{{ $paquete->codigo }}</td>
                                <td><a href="{{ route('almacenes.show', $paquete->ID_almacen) }}">
                                        {{ $paquete->ID_almacen }} - {{ $paquete->nombre }}</a></td>
                                <td>{{ $paquete->direccion }}</td>
                                <td>{{ $paquete->peso }}kg</td>
                                <td>{{ \Carbon\Carbon::parse($paquete->desde)->format('d/m/y H:i') }}</td>
                                <td><a href="{{ route('reparte.show', $paquete->ID_paquete) }}">{{ __("Asignar") }}</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-layout>
<script src="../javascript/scriptCamionero.js"></script>
