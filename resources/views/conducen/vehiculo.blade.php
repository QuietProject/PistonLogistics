<x-layout titulo='Asignar camionero a vehiculo'>

    <h2>Asignar camionero a vehiculo</h2>

    <h3>Camion</h3>
    <p>Matricula: {{ $vehiculo->matricula }}</p>
    <p>Peso maximo: {{ $vehiculo->peso_max }}kg</p>
    <p>Volumen maximo: {{ $vehiculo->vol_max }}m3</p>

    <h3>Conductor</h3>
    <form action=""></form>
    <form action="{{ route('conducen.desde') }}" method="POST">
        @csrf
        @method('PATCH')
        <input type="text" value="{{ $vehiculo->matricula }}" name="matricula" hidden>
        <div>
            <label for="CI">Camionero:</label>
            <select name="CI" id="CI">
                @foreach ($camioneros as $camionero)
                    <option value="{{ $camionero->CI }}">{{ $camionero->nombre }}, {{ $camionero->CI }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit"> Asignar</button>
    </form>

    <a href="{{ route('vehiculos.show', ['vehiculo' => $vehiculo->matricula]) }}">Volver</a>



</x-layout>
