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
    @if ($tipo == 'cliente')
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

    @if ($tipo == 'propio')
        aaaa
    @else
    <p>Paquetes esperando en el almacenen: {{ $paquetesEnCliente }}</p>
    <p>Paquetes encargados por almacen que ya fueron entregados: {{ $paquetesEntregadosCliente }}</p>
    <p>Total de paquetes encargados por el almacen: {{ $paquetesEncargados }}</p>
    @endif

</x-layout>
