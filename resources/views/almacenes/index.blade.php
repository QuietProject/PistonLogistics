@php
    $a='a';
@endphp
<x-layout titulo='Almacenes'>
    @include('almacenes.create')
    <h2>Almacenes propios</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Direccion</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($propios as $propio)
                @php $almacen = $propio->almacen; @endphp
                <tr>
                    <td><a href="{{ route('almacenes.show', $almacen->ID) }}"> {{ $almacen->ID }}</a>
                    </td>
                    <td>{{ $almacen->nombre }}</td>
                    <td>{{ $almacen->direccion }}</td>
                    <td>
                        @if ($almacen->baja)
                            de baja
                        @else
                            operativo
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Almacenes de clientes</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Direccion</th>
                <th>Cliente</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clientes as $cliente)
                @php $almacen = $cliente->almacen; @endphp
                <tr>
                    <td><a href="{{ route('almacenes.show', $almacen->ID) }}"> {{ $almacen->ID }}</a>
                    </td>
                    <td>{{ $almacen->nombre }}</td>
                    <td>{{ $almacen->direccion }}</td>
                    <td><a href="{{ route('clientes.show', $cliente->RUT) }}"> {{ $cliente->cliente->nombre }}</a></td>
                    <td>
                        @if ($almacen->baja)
                            de baja
                        @else
                            operativo
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</x-layout>
