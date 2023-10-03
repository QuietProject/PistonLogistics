<?php
// $estado = 'fuera de servicio';
// if ($vehiculo->baja) {
//     $estado = 'de baja';
// } elseif ($vehiculo->es_operativo) {
//     $estado = 'operativo';
// }
?>

<x-layout titulo='Almacen {{ $tipo }}'>
    @include('almacenes.edit')
    <h2>Almacen {{ $tipo }}</h2>
    <p>ID: {{ $almacen->ID }}</p>
    <p>Nombre: {{ $almacen->nombre }}</p>
    <p>Direccion: {{ $almacen->direccion }}</p>
    @if ($tipo=='cliente')
    <p>Cliente: cliente</p>        
    @endif
    <form action="{{ route('almacenes.baja', $almacen->ID) }}" method="POST">
        @csrf
        @method('PATCH')
        <button type="submit">
            @if ($almacen->baja)
                Dar de Alta
            @else
                Dar de Baja
            @endif
        </button>
    </form>

    <form action="{{ route('almacenes.destroy', $almacen->ID) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">
            Eliminar
        </button>
    </form>

    <a href="{{ route('almacenes.index') }}">Volver</a>

    {{-- @if (count($trae) > 0)
        <h3>Trae paquetes:</h3>
        @foreach ($trae as $paquete)
            <p>ID:{{ $paquete->ID_paquete }}</p>
        @endforeach
    @endif

    @if (count($lleva) > 0)
        <h3>Lleva lotes:</h3>
        @foreach ($lleva as $lote)
            <p>ID:{{ $lote->ID_lote }}</p>
        @endforeach
    @endif

    @if (count($reparte) > 0)
        <h3>Reparte paquetes:</h3>
        @foreach ($reparte as $paquete)
            <p>ID:{{ $paquete->ID_paquete }}</p>
        @endforeach
    @endif

    <h3>Historial de conductores</h3>
    @if (count($camioneros) > 0)
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Desde</th>
                    <th>Hasta</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($camioneros as $camionero)
                    <tr>
                        <td><a href="{{ route('camioneros.show', $camionero->CI) }}"> {{ $camionero->nombre }}
                                {{ $camionero->apellido }}</a></td>
                        <td>{{ $camionero->desde }}</td>
                        <td>{{ $camionero->hasta != null ? $camionero->hasta : 'Conduciendo' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Este vehiculo no ha sido conducido por ningun conductor/a hasta el momento</p>
    @endif --}}
</x-layout>
