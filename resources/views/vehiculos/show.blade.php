<?php
$estado = __("fuera de servicio");
if ($vehiculo->baja) {
    $estado = __('de baja');
} elseif ($vehiculo->es_operativo) {
    $estado = __('operativo');
}
?>
<x-layout menu="5" titulo="Vehiculo" import1="../css/styleVehiculosShow.css">
    <div class="display">
        <h2 class="titleText">{{ __($tipo) }}</h2>
        @if (count($trae) > 0)
            <h3>{{ __("Trae paquetes") }}:</h3>
            @foreach ($trae as $paquete)
                <p>ID:{{ $paquete->ID_paquete }}</p>
            @endforeach
        @endif
        @if (count($lleva) > 0)
            <h3>{{ __("Lleva lotes") }}:</h3>
            @foreach ($lleva as $lote)
                <p>ID:{{ $lote->ID_lote }}</p>
            @endforeach
        @endif

        @if (count($reparte) > 0)
            <h3>{{ __("Reparte paquetes") }}:</h3>
            @foreach ($reparte as $paquete)
                <p>ID:{{ $paquete->ID_paquete }}</p>
            @endforeach
        @endif
        <h3 class="tableTitle">{{ __("Historial de camioneros") }}</h3>
        <div class="tableContainer">
            @if (count($camioneros) > 0)
                <table class="tableView">
                    <thead>
                        <tr>
                            <th>{{ __("Nombre") }}</th>
                            <th>{{ __("Desde") }}</th>
                            <th>{{ __("Hasta") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($camioneros as $camionero)
                            <tr>
                                <td><a href="{{ route('camioneros.show', $camionero->CI) }}">
                                        {{ $camionero->nombre }}</a>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($camionero->desde)->format('d/m/y H:i') }}</td>
                                <td>{{ $camionero->hasta != null ? \Carbon\Carbon::parse($camionero->hasta)->format('d/m/y H:i') : __('Conduciendo') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>{{ __("Este vehiculo no ha sido conducido por ningun conductor/a hasta el momento") }}</p>
            @endif
        </div>
        <div class="textTopRight">
            <div style="display: flex; justify-content: space-between;">
                <p>{{ __("Matricula") }}: </p>
                <p>{{ $vehiculo->matricula }}</p>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <p>{{ __("Peso Maximo") }}: </p>
                <p>{{ $vehiculo->peso_max }} KG</p>
            </div>
        </div>
        <div class="editContainer">
            <div class="">
                <h2 class="asignadoText">{{ __("Editar") }} {{ __($tipo) }}</h2>
                <form action="{{ route('vehiculos.update', $vehiculo) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="editBottom">
                        <label for="peso_max" class="asignadoText">{{ __("Peso Maximo") }}</label>
                        <div>
                            <input type="number" name="peso_max" id="peso_max" required
                                value="{{ old('peso_max', $vehiculo->peso_max) }}" autocomplete="off"
                                style="font-weight: 500">
                            <span class="asignadoText">kg</span>
                        </div>
                        @error('peso_max')
                            <span style="color: red">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="modBtn">{{ __("Confirmar") }}</button>
                </form>
            </div>
            <div class="">
                <p class="asignadoText" style="margin-top: 10vh">{{ __("Conductor") }}:
                    @if (isset($camioneros[0]) && $camioneros[0]->hasta == null)
                        <a href="{{ route('camioneros.show', $camioneros[0]->CI) }}">{{ $camioneros[0]->nombre }}</a>
                        <form
                            action="{{ route('conducen.hasta', ['matricula' => $vehiculo->matricula, 'ci' => $camioneros[0]->CI]) }}"
                            method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="modBtn">{{ __("Dejar de conducir") }}</button>
                        </form>
                    @else
                        @if ($vehiculo->es_operativo && !$vehiculo->baja)
                            {{ __("No tiene") }}
                            <form action="{{ route('conducen.desde') }}" method="POST" style="width: 100%">
                                @if (count($camionerosDisponibles) == 0)
                                    {{ __("No hay camioneros disponibles") }}
                                @else
                                    @csrf
                                    @method('PATCH')
                                    <input type="text" value="{{ $vehiculo->matricula }}" name="matricula" hidden>
                                    <div style="display: flex; justify-content: space-between">
                                        <label for="CI" class="asignadoTextS">{{ __("Camionero") }}:</label>
                                        <select name="CI" id="CI">
                                            @foreach ($camionerosDisponibles as $disponible)
                                                <option value="{{ $disponible->CI }}">{{ $disponible->nombre }},
                                                    {{ $disponible->CI }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <button type="submit" class="modBtn">{{ __("Asignar") }}</button>
                                    </div>
                                @endif
                            @else
                                {{ __("No tiene") }}
                        @endif
                    @endif
                </p>
            </div>
            <div class="">
                <p class="asignadoText" style="margin-top: 10vh">{{ __("Estado") }}: {{ $estado }}</p>
                @if (!$vehiculo->baja)
                    <form action="{{ route('vehiculos.operativo', $vehiculo->matricula) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="modBtn">
                            @if ($vehiculo->es_operativo)
                                {{ __("Cambiar a fuera de servicio") }}
                            @else
                                {{ __("Cambiar a operativo") }}
                            @endif
                        </button>
                    </form>
                @endif
                <form action="{{ route('vehiculos.baja', $vehiculo->matricula) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="modBtn">
                        @if ($vehiculo->baja)
                            {{ __("Dar de Alta") }}
                        @else
                            {{ __("Dar de Baja") }}
                        @endif
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layout>

<script src="../javascript/scriptAdministrador.js"></script>
