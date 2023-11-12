<x-layout titulo='Reparte' menu='7'>
    <h2>Asignar paquetes a camiones para repartir</h2>
    @if (count($paquetes) == 0)
        <tr><td>No hay paquetes para asignar</td></tr>
    @else
    <table tableView" id="tableDriver">
        <thead>
            <tr>
                <th onclick="sortTable(0);arrowsTable(0);" id="0">Paquete </th>
                <th onclick="sortTable(0);arrowsTable(0);" id="1">Codigo </th>
                <th onclick="sortTable(1);arrowsTable(1);" id="2">Almacen</th>
                <th onclick="sortTable(4);arrowsTable(4);" id="4">cliente</th>
                <th onclick="sortTable(5);arrowsTable(5);" id="5">fecha de ingreso al almacen</th>
                <th onclick="sortTable(6);arrowsTable(6);" id="6">Asignar</th>
            </tr>
        </thead>
        <tbody>
                @foreach ($paquetes as $paquete)
                    <tr>
                        <td>{{ $paquete->ID_paquete }}</td>
                        <td>{{ $paquete->codigo }}</td>
                        <td><a href="{{ route('almacenes.show', $paquete->ID_almacen) }}"> {{ $paquete->ID_almacen }} - {{ $paquete->nombre }}</a></td>
                        <td><a href="{{ route('clientes.show', $paquete->RUT) }}"> {{ $paquete->cliente }}</a></td>
                        <td>{{ \Carbon\Carbon::parse($paquete->fecha_registrado )->format('d/m/y H:i')}}</td>
                        <td><a href="{{ route('trae.show', $paquete->ID_paquete) }}">Asignar</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
</x-layout>
