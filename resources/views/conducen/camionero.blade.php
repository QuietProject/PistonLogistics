{{-- <x-layout titulo='Asignar vehiculo a camionero'>

    <h2>Asignar vehiculo a camionero</h2>

    <h3>Camionero</h3>
    <p>Ci: {{ $camionero->CI }}</p>
    <p>Nombre {{ $camionero->nombre }}</p>

    <h3>Vehiculo</h3>
    <form action="{{ route('conducen.desde') }}" method="POST">
        @csrf
        @method('PATCH')
        <input type="text" value="{{ $camionero->CI }}" name="CI" hidden>
        <div>
            <label for="matricula">Vehiculo:</label>
            <select name="matricula" id="matricula">
                @foreach ($vehiculos as $vehiculo)
                    <option value="{{ $vehiculo->matricula }}">{{ $vehiculo->matricula }} {{ $vehiculo->tipo }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit"> Asignar</button>
    </form>

    <a href="{{ route('camioneros.show', ['camionero' => $camionero->CI]) }}">Volver</a>



</x-layout> --}}
