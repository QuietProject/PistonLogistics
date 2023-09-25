<?php
$estado = 'fuera de servicio';
if ($vehiculo->baja) {
    $estado = 'de baja';
} elseif ($vehiculo->es_operativo) {
    $estado = 'operativo';
}
?>
<x-layout titulo='{{ $tipo }}'>

    <h2>{{ $tipo }}</h2>
    <p>Matricula: {{ $vehiculo->matricula }}</p>
    <p>Peso Maximo: {{ $vehiculo->peso_max }}kg</p>
    <p>Volumen Maximo: {{ $vehiculo->vol_max }}m3</p>
    <p>Conductor:
        @if (isset($camioneros[0]) && $camioneros[0]->hasta == null)
            <a href="{{ route('camioneros.show', $camioneros[0]->CI) }}">{{ $camioneros[0]->nombre }}
                {{ $camioneros[0]->apellido }}</a>
            <form
                action="{{ route('conducen.hasta', ['matricula' => $vehiculo->matricula, 'ci' => $camioneros[0]->CI]) }}"
                method="POST">
                @csrf
                @method('PATCH')
                <button type="submit"> Dejar de conducir</button>
            </form>
        @else
            no tiene
            @if ($estado == 'operativo')
            <a href="{{ route('conducen.vehiculo', ['vehiculo' => $vehiculo->matricula]) }}">Asignar conductor</a>
            @endif
        @endif
    </p>
    <p>Estado: {{ $estado }}</p>
    @if (!$vehiculo->baja)
        <form action="{{ route('vehiculos.operativo', $vehiculo->matricula) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit">
                @if ($vehiculo->es_operativo)
                    Cambiar a fuera de servicio
                @else
                    Cambiar a operativo
                @endif
            </button>
        </form>
    @endif

    <form action="{{ route('vehiculos.baja', $vehiculo->matricula) }}" method="POST">
        @csrf
        @method('PATCH')
        <button type="submit">
            @if ($vehiculo->baja)
                Dar de Alta
            @else
                Dar de Baja
            @endif
        </button>
    </form>
    <form action="{{ route('vehiculos.destroy', $vehiculo->matricula) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">
            Eliminar
        </button>
    </form>

    <p><a href="{{ route('vehiculos.edit', $vehiculo) }}">Editar</a></p>

    <a href="{{ route('vehiculos.index') }}">Volver</a>

    @if (count($trae) > 0)
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
    @endif
</x-layout>
