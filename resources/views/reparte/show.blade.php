<x-layout titulo='Lleva' menu='7'>
    <h2>Asignar Paquete {{ $paquete->ID_paquete }}</h2>

<div>
    <h3>Lote</h3>
    <p>ID: {{ $paquete->ID_paquete }}</p>
    <p>ID: {{ $paquete->codigo }}</p>
    <p>Fecha registrado: {{ \Carbon\Carbon::parse($paquete->fecha_registrado)->format('d/m/y H:i') }}</p>
    <p>En Almacen: <a target="_blank" href="{{ route('almacenes.show', $paquete->ID_almacen) }}">{{ $paquete->ID_almacen }} - {{ $paquete->nombre }}</a></p>
    <p>Desde: {{ \Carbon\Carbon::parse($paquete->desde)->format('d/m/y H:i') }}</p>
    <p>Peso: {{ $paquete->peso }}kg</p>
</div>
<form action="{{ route('reparte.store', $paquete->ID_paquete) }}" method="POST">
    @csrf
    <h3>Elegir camioneta</h3>
    <table>
        <thead>
            <tr>
                <th>matricula</th>
                <th>Carga asignada</th>
                <th>Peso maximo</th>
                <th>Almacen asignado</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($camionetas as $camioneta)
                <tr>
                    <td>{{ $camioneta->matricula }}</td>
                    <td>{{ $camioneta->carga_asignada }}kg</td>
                    <td>{{ $camioneta->peso_max }}kg</td>
                    <td>{{ $camioneta->almacen ? $camioneta->almacen : '-' }}</td>
                    <td><input type="radio" name="camioneta" value="{{ $camioneta->matricula }}"></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <button type="submit">Asignar</button>
</form>
</x-layout>
