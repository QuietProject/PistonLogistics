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
    <p>Latitud: {{ $almacen->latitud }}</p>
    <p>Longitud: {{ $almacen->longitud }}</p>
    @if ($tipo == 'cliente')
        <p>Cliente: <a href="{{ route('clientes.show',$cliente) }}">{{ $cliente->nombre }}</a><p>
    @endif
    <form action="{{ route('almacenes.destroy', $almacen->ID) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">
            @if ($almacen->baja)
                Dar de Alta
            @else
                Dar de Baja
            @endif
        </button>
    </form>

    <a href="{{ route('almacenes.index') }}">Volver</a>

    @if ($tipo == 'propio')

    <p>Paquetes 'sueltos' en el almacen: {{ $paquetesEnAlmacen }}</p>
    <p>Total de paquetes en que pasaron por el almacen: {{ $paquetesRecibidos }}</p>
    <p>Lotes para desarmar en el almacen: {{ $lotesParaDesarmar }}</p>
    <p>Lotes en el almacen prontos para llevar : {{ $lotesProntos }}</p>
    <p>Lotes en preparacion en el almacen: {{ $lotesEnPreparacion }}</p>
    <p>Total de lotes recibidos en el almacen: {{ $lotesRecibidos }}</p>
    <p>Total de lotes creados en el almacen: {{ $lotesCreados }}</p>
    @else
    <p>Paquetes esperando en el almacenen: {{ $paquetesEnCliente }}</p>
    <p>Paquetes encargados por almacen que ya fueron entregados: {{ $paquetesEntregadosCliente }}</p>
    <p>Total de paquetes encargados por el almacen: {{ $paquetesEncargados }}</p>
    @endif

</x-layout>
