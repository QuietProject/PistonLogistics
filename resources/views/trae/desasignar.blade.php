<x-layout titulo='Reparte' menu='7' import1="../css/styleLlevaReparteTrae.css">
    <div class="display">
        <h2 class="titleText">Paquetes asignados en trae</h2>
        @if (count($paquetes) == 0)
    <p class="textNegative">No hay paquetes asignados</p>
        @else
            <div class="tableContainer">
                <table tableView" id="tableDriver" class="tableView">
                    <thead>
                        <tr>
                            <th onclick="sortTable(0);arrowsTable(0);" id="0">Paquete </th>
                            <th onclick="sortTable(0);arrowsTable(0);" id="1">Codigo </th>
                            <th onclick="sortTable(1);arrowsTable(1);" id="2">Almacen</th>
                            <th onclick="sortTable(4);arrowsTable(4);" id="4">Cliente</th>
                            <th onclick="sortTable(5);arrowsTable(5);" id="5">Fecha de registrado</th>
                            <th onclick="sortTable(5);arrowsTable(5);" id="5">Fecha asignado</th>
                            <th onclick="sortTable(5);arrowsTable(5);" id="5">matricula</th>
                            <th onclick="sortTable(6);arrowsTable(6);" id="6">Desasignar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($paquetes as $paquete)
                            <tr>
                                <td>{{ $paquete->ID_paquete }}</td>
                                <td>{{ $paquete->codigo }}</td>
                                <td><a href="{{ route('almacenes.show', $paquete->ID_almacen) }}">
                                        {{ $paquete->ID_almacen }} -
                                        {{ $paquete->nombre }}</a></td>
                                <td><a href="{{ route('clientes.show', $paquete->RUT) }}"> {{ $paquete->cliente }}</a>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($paquete->fecha_registrado)->format('d/m/y H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($paquete->fecha_asignado)->format('d/m/y H:i') }}</td>
                                <td>{{ $paquete->matricula }}</td>
                                <td>
                                    <form action="{{ route('trae.destroy', $paquete->ID_paquete) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="switchBtn">
                                            Desasignar
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
