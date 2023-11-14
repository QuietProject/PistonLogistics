<x-layout titulo='Reparte' menu='7' import1="../css/styleLlevaReparteTrae.css">
    <div class="display">
        <h2 class="titleText">{{ __('Paquetes asignados en reparte') }}</h2>
        @if (count($paquetes) == 0)
            <p class="textNegative">{{ __('No hay paquetes asignados') }}</p>
        @else
            <div class="tableContainer">
                <table tableView" id="tableDriver" class="tableView">
                    <thead>
                        <tr>
                            <th onclick="sortTable(0);arrowsTable(0);" id="0">{{ __('Paquete') }} </th>
                            <th onclick="sortTable(0);arrowsTable(0);" id="1">{{ __('Codigo') }}</th>
                            <th onclick="sortTable(1);arrowsTable(1);" id="2">{{ __('Almacen') }}</th>
                            <th onclick="sortTable(2);arrowsTable(2);" id="3">{{ __('Direccion destino') }}</th>
                            <th onclick="sortTable(4);arrowsTable(4);" id="4">{{ __('Peso') }}</th>
                            <th onclick="sortTable(5);arrowsTable(5);" id="5">
                                {{ __('Fecha de ingreso al almacen') }}</th>
                            <th onclick="sortTable(5);arrowsTable(5);" id="5">{{ __('Fecha asignado') }}</th>
                            <th onclick="sortTable(5);arrowsTable(5);" id="5">{{ __('Camioneta') }}</th>
                            <th onclick="sortTable(6);arrowsTable(6);" id="6">{{ __('Desasignar') }}</th>
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
                                <td>{{ \Carbon\Carbon::parse($paquete->fecha_asignado)->format('d/m/y H:i') }}</td>
                                <td><a
                                        href="{{ route('vehiculos.show', $paquete->matricula) }}">{{ $paquete->matricula }}</a>
                                </td>

                                <td>
                                    <form action="{{ route('reparte.destroy', $paquete->ID_paquete) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="switchBtn">
                                            {{ __('Desasignar') }}
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
