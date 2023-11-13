<x-layout menu="1" titulo="Camionero" import1="../css/styleCamioneroShow.css">
    <div class="display">
        <p class="titleText">{{ __('Nombre') }}: {{ $camionero->nombre }}</p>
        <p class="titleText" style="top: 11vh">{{ __('Cedula') }}: {{ $camionero->CI }}</p>
        <p>
        <form action="{{ route('camioneros.destroy', $camionero->CI) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="switchBtn">
                @if ($camionero->baja)
                    {{ __('Dar de Alta') }}
                @else
                    {{ __('Dar de Baja') }}
                @endif
            </button>
        </form>
        </p>
        <h3 class="tableTitle">{{ __('Historial de vehiculos') }}</h3>
        <div class="tableContainer">
            @if (count($vehiculos) > 0)
                <table class="tableView" id="tableTrucks">
                    <thead>
                        <tr>
                            <th style="width: 33%;" onclick="sortTable(0);arrowsTable(0);" id="0">
                                {{ __('Matricula') }}</th>
                            <th style="width: 33%;" onclick="sortTable(1);arrowsTable(1);" id="1">
                                {{ __('Desde') }}</th>
                            <th style="width: 33%;" onclick="sortTable(2);arrowsTable(2);" id="2">
                                {{ __('Hasta') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vehiculos as $vehiculo)
                            <tr>
                                <td><a href="{{ route('vehiculos.show', $vehiculo->matricula) }}">
                                        {{ $vehiculo->matricula }}</a>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($vehiculo->desde)->format('d/m/y H:i') }}</td>
                                <td>{{ $vehiculo->hasta != null ? \Carbon\Carbon::parse($vehiculo->hasta)->format('d/m/y H:i') : __('Conduciendo') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    @else
        <p style="font-weight: 400; color: white; left: 0; position: relative;font-size: 2vh">
            {{ __('Este conductor/a no ha conducido ningun camion hasta el momento') }}</p>
    </div>
    @endif
    <div class="editContainer">
        <p class="asignadoText">{{ __('Vehiculo asignado') }}:
            @if (isset($vehiculos[0]) && $vehiculos[0]->hasta == null)
                <a href="{{ route('vehiculos.show', $vehiculos[0]->matricula) }}">{{ $vehiculos[0]->matricula }}</a>
                <form
                    action="{{ route('conducen.hasta', ['matricula' => $vehiculos[0]->matricula, 'ci' => $camionero->CI]) }}"
                    method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="modBtn">{{ __('Dejar de conducir') }}</button>
                </form>
            @else
                {{ __('No tiene') }}
                @if (!$camionero->baja)
                    <br>
                    <form action="{{ route('conducen.desde') }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="text" value="{{ $camionero->CI }}" name="CI" hidden>
                        <div>
                            <label for="matricula"
                                style="color: white; font-size: 2vh; font-weight: 500">{{ __('Vehiculo') }}:</label>
                            <select name="matricula" id="matricula">
                                @foreach ($vehiculosDisponibles as $disponible)
                                    <option value="{{ $disponible->matricula }}">{{ $disponible->matricula }}
                                        {{ $disponible->tipo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="modBtn">{{ __('Asignar') }}</button>
                    </form>
                @endif
            @endif
        </p>
        <h2 class="asignadoText" style="margin-top: 10vh">{{ __('Editar Camionero') }}</h2>
        <form action="{{ route('camioneros.update', $camionero) }}" method="POST">
            @csrf
            @method('PATCH')
            <div>
                <label for="nombre" style="color: white; font-size: 2vh; font-weight: 500">{{ __('Nombre') }}:
                </label>
                <input type="text" name="nombre" id="nombre" style="height: 2.5vh; font-weight: 500"
                    value="{{ old('nombre', $camionero->nombre) }}">
                @error('nombre')
                    <span style="color: red">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="modBtn">{{ __('Confirmar') }}</button>
        </form>
    </div>
    </div>
</x-layout>

<script src="../javascript/scriptAdministrador.js"></script>
