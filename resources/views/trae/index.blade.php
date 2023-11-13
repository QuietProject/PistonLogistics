<x-layout titulo='Reparte' menu='7' import1="../css/styleLlevaReparteTrae.css">
    <div class="display">

        <h2 class="titleText">{{ __("Asignar paquetes a camiones para traer") }}</h2>
        <input type="text" id="searchInput" class="filterText" placeholder={{ __("Buscar") }} onkeyup="searchFilter()">
        @if (count($paquetes) == 0)
            <p class="textNegative">{{ __("No hay paquetes para asignar") }}</p>
        @else
        <div class="tableContainer">
            <table tableView" id="tableDriver" class="tableView">
                <thead>
                    <tr>
                        <th onclick="sortTable(0);arrowsTable(0);" id="0" style="width: 10%">{{ __("Paquete") }}</th>
                        <th onclick="sortTable(1);arrowsTable(1);" id="1" style="width: 10%">{{ __("Codigo") }}</th>
                        <th onclick="sortTable(2);arrowsTable(2);" id="2" style="width: 15%">{{ __("Almacen") }}</th>
                        <th onclick="sortTable(3);arrowsTable(3);" id="3" style="width: 15%">{{ __("Cliente") }}</th>
                        <th onclick="sortTable(4);arrowsTable(4);" id="4" style="width: 20%">{{ __("Fecha de Ingreso al Almacen") }}</th>
                        <th onclick="sortTable(5);arrowsTable(5);" id="5" style="width: 15%">{{ __("Asignar") }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paquetes as $paquete)
                        <tr>
                            <td>{{ $paquete->ID_paquete }}</td>
                            <td>{{ $paquete->codigo }}</td>
                            <td><a href="{{ route('almacenes.show', $paquete->ID_almacen) }}">
                                    {{ $paquete->ID_almacen }} - {{ $paquete->nombre }}</a></td>
                            <td><a href="{{ route('clientes.show', $paquete->RUT) }}"> {{ $paquete->cliente }}</a></td>
                            <td>{{ \Carbon\Carbon::parse($paquete->fecha_registrado)->format('d/m/y H:i') }}</td>
                            <td><a href="{{ route('trae.show', $paquete->ID_paquete) }}">{{ __("Asignar") }}</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</x-layout>


