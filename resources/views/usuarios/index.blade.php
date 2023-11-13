<x-layout menu="2" titulo="Usuarios" import1="../css/styleUsuarios.css">
    <div class="display">
        <h2 class="titleText">{{ __("Usuarios") }}</h2>
        <input type="text" id="searchInput" class="filterText" placeholder={{ __("Buscar") }} onkeyup="searchFilter()">
        <div class="tableContainer">
            <table class="tableView" id="tableTrucks">
                <thead>
                    <tr>
                        <th style="width: 15%;" onclick="sortTable(0);arrowsTable(0);" id="0">{{ __("Usuario") }}</th>
                        <th style="width: 15%;" onclick="sortTable(0);arrowsTable(0);" id="0">{{ __("Rol") }}</th>
                        <th style="width: 25%;" onclick="sortTable(0);arrowsTable(0);" id="0">{{ __("Email") }}</th>
                        <th style="width: 20%;" onclick="sortTable(0);arrowsTable(0);" id="0">{{ __("Verificacion email") }}</th>
                        <th style="width: 15%;" onclick="sortTable(0);arrowsTable(0);" id="0"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $user)
                        <tr>
                            <td><a href="{{ route('usuarios.show', $user) }}"> {{ $user->user }}</a> </td>
                            <td> @switch($user->rol)
                                    @case(0)
                                        {{ __("Administrador") }}
                                    @break

                                    @case(1)
                                        {{ __("Almacen") }}
                                    @break

                                    @case(2)
                                        {{ __("Camionero") }}
                                    @break

                                    @case(3)
                                        {{ __("Cliente") }}
                                    @break
                                @endswitch
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->email_verified_at ? \Carbon\Carbon::parse($user->email_verified_at)->format('d/m/y H:i') : '-' }}
                            </td>
                            <td>
                                <form action="{{ route('usuarios.destroy', $user) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="switchBtn">
                                        {{ __("Eliminar") }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="editContainer">
            <h2 style="color: white; font-size: 3vh">{{ __("Ingresar usuario") }}</h2>
            <form action="{{ route('usuarios.store') }}" method="POST">
                @csrf
                <div style="margin-top: 1vh; display: flex; justify-content: space-between">
                    <label for="tipo" style="color: white; font-size: 2vh">{{ __("Tipo") }}</label>
                    <select name="tipo" id="tipo">
                        <option value="0">{{ __("Administrador") }}</option>
                        <option value="1" {{ old('tipo') == '1' ? 'selected' : '' }}>{{ __("Almacen") }}</option>
                        <option value="2" {{ old('tipo') == '2' ? 'selected' : '' }}>{{ __("Camionero") }}</option>
                        <option value="3" {{ old('tipo') == '3' ? 'selected' : '' }}>{{ __("Cliente") }}</option>
                    </select>
                </div>
                <div id="ciInput" style="margin-top: 1vh; display: flex; justify-content: space-between">
                    <label for="CI" style="color: white; font-size: 2vh">{{ __("CI") }}</label>
                    <input type="number" name="CI" id="CI" maxlength="8" minlength="8"
                        value="{{ old('CI') }}">
                    @error('CI')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div id="camioneroInput" style=" display: none; margin-top: 1vh; justify-content: space-between">
                    <label for="camionero" style="color: white; font-size: 2vh">{{ __("Camionero") }}</label>
                    <select name="camionero" id="camionero">
                        @foreach ($camioneros as $camionero)
                            @if ($camionero->baja == 0)
                                <option value="{{ $camionero->CI }}"
                                    {{ old('camionero') == $camionero->CI ? 'selected' : '' }}>
                                    {{ $camionero->CI }} - {{ $camionero->nombre }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('camionero')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div id="clienteInput" style="margin-top: 1vh; display: none; justify-content: space-between">
                    <label for="cliente" style="color: white; font-size: 2vh">{{ __("Cliente") }}</label>
                    <select id="cliente" name="cliente">
                        @foreach ($clientes as $cliente)
                            @if ($cliente->baja == 0)
                                <option value="{{ $cliente->RUT }}"
                                    {{ old('cliente') == $cliente->RUT ? 'selected' : '' }}>
                                    {{ $cliente->RUT }} - {{ $cliente->nombre }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('cliente')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div id="almacenClienteInput"
                    style="margin-top: 1vh; display: none; justify-content: space-between">
                    <label for="almacenCliente" style="color: white; font-size: 2vh">{{ __("Almacen") }}</label>
                    <select name="almacenCliente" id="almacenCliente">
                        @foreach ($almacenesClientes as $almacenCliente)
                            `
                            @php
                                $almacen = $almacenCliente->almacen;
                                $cliente = $almacenCliente->cliente;
                            @endphp
                            @if ($almacen->baja == 0 && $cliente->baja == 0)
                                <option value="{{ $almacen->ID }}"
                                    {{ old('almacenCliente') == $almacen->ID ? 'selected' : '' }}>
                                    {{ $almacen->ID }} - {{ $almacen->nombre }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('almacenCliente')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div id="almacenPropioInput" style="margin-top: 1vh; display: none; justify-content: space-between">
                    <label for="almacenPropio" style="color: white; font-size: 2vh">{{ __("Almacen") }}</label>
                    <select name="almacenPropio" id="almacenPropio">
                        @foreach ($almacenesPropios as $cliente)
                            @php $almacen = $cliente->almacen @endphp
                            @if ($almacen->baja == 0)
                                <option value="{{ $almacen->ID }}"
                                    {{ old('almacenPropio') == $almacen->ID ? 'selected' : '' }}>
                                    {{ $almacen->ID }} - {{ $almacen->nombre }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('almacenPropio')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <div id="emailInput" style="margin-top: 1vh; display: flex; justify-content: space-between">
                    <label for="email" style="color: white; font-size: 2vh">{{ __("Email") }}</label>
                    <input type="email" name="email" id="email" required value="{{ old('email') }}">
                    @error('email')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="modBtn">{{ __("Confirmar") }}</button>
            </form>
        </div>

    </div>
</x-layout>

<script src="../javascript/scriptAdministrador.js"></script>
<script src="../javascript/scriptUsuario.js"></script>
