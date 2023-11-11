<x-layout titulo='Lleva'>
    <h2>Asignar lote {{ $lote->id }}</h2>
</x-layout>

<div>
    <h3>Lote</h3>
    <p>ID: {{ $lote->id }}</p>
    <p>Codigo: {{ $lote->codigo }}</p>
    <p>Fecha creado: {{ \Carbon\Carbon::parse($lote->fecha_creacion)->format('d/m/y H:i') }}</p>
    <p>Fecha pronto: {{ \Carbon\Carbon::parse($lote->fecha_pronto)->format('d/m/y H:i') }}</p>
    <p>Almacen origen: <a target="_blank" href="{{ route('almacenes.show', $origen->ID) }}">{{ $origen->ID }} -
            {{ $origen->nombre }}</a></p>
    <p>Almacen destino: <a target="_blank" href="{{ route('almacenes.show', $destino->ID) }}">{{ $destino->ID }} -
            {{ $destino->nombre }}</a></p>
    <p>Troncal: <a target="_blank" href="{{ route('troncales.show', $troncal->ID) }}">{{ $troncal->ID }} -
            {{ $troncal->nombre }}</a></p>
    <p>Peso: {{ $lote->peso }}</p>
    <p>Cantidad de paquetes: {{ $lote->cantidad }}</p>
</div>
<div>
    <h3>Paquetes en el lote</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Peso</th>
                <th>Almacen final</th>
                <th>Direccion destino</th>
                <th>Fecha_registrado</th>
                <th>Fecha de ingreso al lote</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($paquetes as $paquete)
                <tr>
                    <td>{{ $paquete->ID }}</td>
                    <td>{{ $paquete->peso }}</td>
                    <td><a target="_blank"
                            href="{{ route('almacenes.show', $paquete->ID_pickup) }}">{{ $paquete->ID_pickup }}</a>
                    </td>
                    <td>{{ $paquete->direccion }}</td>
                    <td>{{ Carbon\Carbon::parse($paquete->fecha_registrado)->format('d/m/y H:i') }}</td>
                    <td>{{ Carbon\Carbon::parse($paquete->desde)->format('d/m/y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>

    </table>
</div>
<form action="{{ route('lleva.store',$lote->id) }}" method="POST">
    @csrf
    <h3>Elegir camion</h3>
    <table>
        <thead>
            <tr>
                <th>matricula</th>
                <th>Carga asignada</th>
                <th>Peso maximo</th>
                <th>Troncal asignada</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($camiones as $camion)
                <tr>
                    <td>{{ $camion->matricula }}</td>
                    <td>{{ $camion->carga_asignada }}kg</td>
                    <td>{{ $camion->peso_max }}kg</td>
                    <td>{{ $camion->troncal ? $camion->troncal : '-' }}</td>
                    <td><input type="radio" name="camion"
                            value="{{ $camion->matricula }}"></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <button type="submit">Asignar</button>
</form>
