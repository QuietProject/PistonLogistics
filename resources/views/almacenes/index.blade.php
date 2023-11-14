{{-- <x-layout menu="3" titulo="{{ __("Almacenes") }}" import1="../css/styleAlmacenes.css"> --}}
<x-layout menu="3" titulo="Almacenes" import1="../css/styleAlmacenes.css">
    <div class="addBackdrop disabled" id="addBackdrop"></div>
    <div class="display">
        <input type="button" value={{ __('Agregar') }} class="addButton" id="addTruck">
        <input type="text" id="searchInput" class="filterText" placeholder={{ __('Buscar') }}
            onkeyup="searchFilter()">
        <h2 class="titleText">{{ __('Almacenes') }}</h2>
        <h2 class="tableTitle">{{ __('Almacenes propios') }}</h2>
        <div class="tableContainer">
            <table class="tableView" id="tablePropios">
                <thead>
                    <tr>
                        <th style="width: 10%;" onclick="sortTable(0);arrowsTable(0);" id="0">
                            {{ __('ID') }}</th>
                        <th style="width: 30%;" onclick="sortTable(1);arrowsTable(1);" id="1">
                            {{ __('Nombre') }}</th>
                        <th style="width: 30%;" onclick="sortTable(2);arrowsTable(2);" id="2">
                            {{ __('Direccion') }}</th>
                        <th style="width: 30%;" onclick="sortTable(3);arrowsTable(3);" id="3">
                            {{ __('Estado') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($propios as $propio)
                        @php $almacen = $propio->almacen; @endphp
                        <tr>
                            <td><a href="{{ route('almacenes.show', $almacen->ID) }}"> {{ $almacen->ID }}</a>
                            </td>
                            <td>{{ $almacen->nombre }}</td>
                            <td>{{ $almacen->direccion }}</td>
                            <td>
                                @if ($almacen->baja)
                                    {{ __('De baja') }}
                                @else
                                    {{ __('Operativo') }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <h2 class="tableTitle" style="left: 57vw; top: 20vh;">{{ __('Almacenes de clientes') }}</h2>
        <div class="tableContainer" style="left: 50vw;">
            <table class="tableView" id="tableClientes">
                <thead>
                    <tr>
                        <th style="width: 10%;" onclick="sortTableAlternate(0);arrowsTable(4);"" id="4">
                            {{ __('ID') }}</th>
                        <th style="width: 25%;" onclick="sortTableAlternate(1);arrowsTable(5);"" id="5">
                            {{ __('Nombre') }}</th>
                        <th style="width: 25%;" onclick="sortTableAlternate(2);arrowsTable(6);"" id="6">
                            {{ __('Direccion') }}</th>
                        <th style="width: 20%;" onclick="sortTableAlternate(3);arrowsTable(7);"" id="7">
                            {{ __('Cliente') }}</th>
                        <th style="width: 20%;" onclick="sortTableAlternate(4);arrowsTable(8);"" id="7">
                            {{ __('Estado') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $cliente)
                        @php $almacen = $cliente->almacen; @endphp
                        <tr>
                            <td><a href="{{ route('almacenes.show', $almacen->ID) }}"> {{ $almacen->ID }}</a>
                            </td>
                            <td>{{ $almacen->nombre }}</td>
                            <td>{{ $almacen->direccion }}</td>
                            <td><a href="{{ route('clientes.show', $cliente->RUT) }}">
                                    {{ $cliente->cliente->nombre }}</a>
                            </td>
                            <td>
                                @if ($almacen->baja)
                                    {{ __('De baja') }}
                                @else
                                    {{ __('Operativo') }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="addInterface" id="addTruckInterface" style="display: none">
            <div class="cornerButton" id="closeButtonCornerTrucks"></div>
            <div class="closeButton" id="closeButtonTrucks">
                <div class="xLine" style="rotate: 45deg;"></div>
                <div class="xLine" style="rotate: -45deg;"></div>
            </div>
            <div class="addForm">
                @if ($errors->any())
                    <script>
                        document.getElementById("addBackdrop").style.display = "flex";
                        document.getElementById("addTruckInterface").style.display = "flex";
                    </script>
                @endif
                <h2 class="adderTitle">{{ __('Ingresar Almacen') }}</h2>
                <form action="{{ route('almacenes.store') }}" method="POST">
                    @csrf
                    <div class="inputBox" style="display: flex; justify-content: space-between">
                        <label for="tipo">{{ __('Tipo') }}</label>
                        <select name="tipo" id="tipo2">
                            <option value="propio">{{ __('Propio') }}</option>
                            <option value="cliente" {{ old('tipo') == 'cliente' ? 'selected' : '' }}>
                                {{ __('Cliente') }}</option>
                        </select>
                    </div>
                    <div class="inputBox" style="display: flex; justify-content: space-between">
                        <label for="nombre">{{ __('Nombre') }}*</label>
                        <input type="text" name="nombre" id="nombre" required value="{{ old('nombre') }}">
                        @error('nombre')
                            <script>
                                Swal.fire({
                                    icon: "error",
                                    title: "{{ $message }}",
                                    showConfirmButton: false,
                                    timer: 1000
                                });
                            </script>
                        @enderror
                    </div>
                    <div class="inputBox" style="display: flex; justify-content: space-between">
                        <label for="calle">{{ __('Calle') }}*</label>
                        <input type="text" name="calle" id="calle" required value="{{ old('calle') }}">
                        @error('calle')
                            <script>
                                Swal.fire({
                                    icon: "error",
                                    title: "{{ $message }}",
                                    showConfirmButton: false,
                                    timer: 1000
                                });
                            </script>
                        @enderror
                    </div>
                    <div class="inputBox" style="display: flex; justify-content: space-between">
                        <label for="numero">{{ __('Numero') }}*</label>
                        <input type="text" name="numero" id="numero" required value="{{ old('numero') }}">
                        @error('numero')
                            <script>
                                Swal.fire({
                                    icon: "error",
                                    title: "{{ $message }}",
                                    showConfirmButton: false,
                                    timer: 1000
                                });
                            </script>
                        @enderror
                    </div>
                    <div class="inputBox" style="display: flex; justify-content: space-between">
                        <label for="codigoPostal">{{ __('Codigo postal') }}</label>
                        <input type="number" name="codigoPostal" id="codigoPostal" step="1"
                            value="{{ old('codigoPostal') }}">
                        @error('codigoPostal')
                            <script>
                                Swal.fire({
                                    icon: "error",
                                    title: "{{ $message }}",
                                    showConfirmButton: false,
                                    timer: 1000
                                });
                            </script>
                        @enderror
                    </div>
                    <div class="inputBox" style="display: flex; justify-content: space-between">
                        <label for="localidad">{{ __('Localidad') }}</label>
                        <input type="text" name="localidad" id="localidad" value="{{ old('localidad') }}">
                        @error('localidad')
                            <script>
                                Swal.fire({
                                    icon: "error",
                                    title: "{{ $message }}",
                                    showConfirmButton: false,
                                    timer: 1000
                                });
                            </script>
                        @enderror
                    </div>
                    <div class="inputBox" style="display: flex; justify-content: space-between">
                        <label for="departamento">{{ __('Departamento') }}</label>
                        <select name="departamento" id="departamento">
                            <option value="Montevideo" {{ old('departamento') == 'Montevideo' ? 'selected' : '' }}>
                                Montevideo</option>
                            <option value="Artigas" {{ old('departamento') == 'Artigas' ? 'selected' : '' }}>Artigas
                            </option>
                            <option value="Canelones" {{ old('departamento') == 'Canelones' ? 'selected' : '' }}>
                                Canelones</option>
                            <option value="Cerro Largo" {{ old('departamento') == 'Cerro Largo' ? 'selected' : '' }}>
                                Cerro Largo</option>
                            <option value="Colonia" {{ old('departamento') == 'Colonia' ? 'selected' : '' }}>Colonia
                            </option>
                            <option value="Durazno" {{ old('departamento') == 'Durazno' ? 'selected' : '' }}>Durazno
                            </option>
                            <option value="Flores" {{ old('departamento') == 'Flores' ? 'selected' : '' }}>Flores
                            </option>
                            <option value="Florida" {{ old('departamento') == 'Florida' ? 'selected' : '' }}>Florida
                            </option>
                            <option value="Lavalleja" {{ old('departamento') == 'Lavalleja' ? 'selected' : '' }}>
                                Lavalleja</option>
                            <option value="Maldonado" {{ old('departamento') == 'Maldonado' ? 'selected' : '' }}>
                                Maldonado</option>
                            <option value="Paysandu" {{ old('departamento') == 'Paysandu' ? 'selected' : '' }}>
                                Paysandu</option>
                            <option value="Río Negro" {{ old('departamento') == 'Río Negro' ? 'selected' : '' }}>Río
                                Negro</option>
                            <option value="Rivera" {{ old('departamento') == 'Rivera' ? 'selected' : '' }}>Rivera
                            </option>
                            <option value="Rocha" {{ old('departamento') == 'Rocha' ? 'selected' : '' }}>Rocha
                            </option>
                            <option value="Salto" {{ old('departamento') == 'Salto' ? 'selected' : '' }}>Salto
                            </option>
                            <option value="San José" {{ old('departamento') == 'San José' ? 'selected' : '' }}>San
                                José</option>
                            <option value="Soriano" {{ old('departamento') == 'Soriano' ? 'selected' : '' }}>Soriano
                            </option>
                            <option value="Tacuarembo" {{ old('departamento') == 'Tacuarembo' ? 'selected' : '' }}>
                                Tacuarembo</option>
                            <option value="Treinta y Tres"
                                {{ old('departamento') == 'Treinta y Tres' ? 'selected' : '' }}>Treinta y Tres</option>
                        </select>
                    </div>
                    <div class="inputBox" style="display: none; justify-content: space-between" id="RUTBox">
                        <label for="RUT">{{ __('Cliente') }}</label>
                        <select name="RUT" id="RUT">
                            @foreach ($empresas as $cliente)
                                @if ($cliente->baja == 0)
                                    <option value="{{ $cliente->RUT }}"
                                        {{ old('RUT') == $cliente->RUT ? 'selected' : '' }}>{{ $cliente->nombre }} -
                                        {{ $cliente->RUT }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        @error('RUT')
                            <script>
                                Swal.fire({
                                    icon: "error",
                                    title: "{{ $message }}",
                                    showConfirmButton: false,
                                    timer: 1000
                                });
                            </script>
                        @enderror
                    </div>
                    <button type="submit" class="submitBtn">{{ __('Confirmar') }}</button>

                </form>
            </div>
        </div>
    </div>
</x-layout>

<script src="../javascript/scriptAlmacenes.js"></script>
