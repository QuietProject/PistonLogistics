<x-layout menu="5" titulo="Vehiculos" import1="../css/styleVehiculos.css">
    <!-- Backdrop Blur -->
    <div class="addBackdrop disabled" id="addBackdrop">
    </div>
    <!-- Trucks Screen -->
    <div class="display" id="displayTrucks">
        <!-- Title -->
        <h1 class="titleText">{{ __('Vehiculos') }}</h1>
        <!-- Add Button -->
        <input type="button" value={{ __('Agregar') }} class="addButton" id="addTruck">
        <!-- SearchBar -->
        <input type="text" id="searchInput" class="filterText" placeholder={{ __('Buscar') }}
            onkeyup="searchFilter()">
        <!-- Trucks Title -->
        <p class="tableTitle">{{ __('Camiones') }}</p>
        <!-- Camionetas Title -->
        <p class="tableTitle" style="left: 63vw">{{ __('Camionetas') }}</p>
        <!-- Tables Container -->
        <div class="tableContainer">
            <!-- Truck Table -->
            <table class="tableView" id="tableTrucks">
                <thead>
                    <tr>
                        <th style="width: 33%;" onclick="sortTable(0);arrowsTable(0);" id="0">
                            {{ __('Matricula') }}</th>
                        <th style="width: 33%;" onclick="sortTable(1);arrowsTable(1);" id="1">
                            {{ __('Peso Maximo') }}</th>
                        <th style="width: 33%;" onclick="sortTable(3);arrowsTable(3);" id="3">
                            {{ __('Estado') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($camiones as $camion)
                        <tr>
                            <td><a href="{{ route('vehiculos.show', $camion->matricula) }}">
                                    {{ $camion->matricula }}</a>
                            </td>
                            <td>{{ $camion->peso_max }}kg</td>
                            <td>
                                @if ($camion->baja)
                                    {{ __('De Baja') }}
                                @else
                                    @if ($camion->es_operativo)
                                        {{ __('Operativo') }}
                                    @else
                                        {{ __('Fuera De Servicio') }}
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tableContainer" style="left: 50vw;">
            <table class="tableView" id="tableCamionetas">
                <thead>
                    <tr>
                        <th style="width: 33%;" onclick="sortTableAlternate(0);arrowsTable(4);"" id="4">
                            {{ __('Matricula') }}</th>
                        <th style="width: 33%;" onclick="sortTableAlternate(1);arrowsTable(5);"" id="5">
                            {{ __('Peso Maximo') }}</th>
                        <th style="width: 33%;" onclick="sortTableAlternate(3);arrowsTable(7);"" id="7">
                            {{ __('Estado') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($camionetas as $camioneta)
                        <tr>
                            <td><a style="linkVehicle" href="{{ route('vehiculos.show', $camioneta->matricula) }}">
                                    {{ $camioneta->matricula }}</a>
                            </td>
                            <td>{{ $camioneta->peso_max }}kg</td>
                            <td>
                                @if ($camioneta->baja)
                                    {{ __('De Baja') }}
                                @else
                                    @if ($camioneta->es_operativo)
                                        {{ __('Operativo') }}
                                    @else
                                        {{ __('Fuera De Servicio') }}
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Add Trucks -->
        <div class="addInterface" id="addTruckInterface" style="display: none">
            <!-- Close Button -->
            <div class="cornerButton" id="closeButtonCornerTrucks"></div>
            <div class="closeButton" id="closeButtonTrucks">
                <div class="xLine" style="rotate: 45deg;"></div>
                <div class="xLine" style="rotate: -45deg;"></div>
            </div>
            <!-- Add Vehicle -->
            <div class="addForm">
                @if ($errors->any())
                    <script>
                        document.getElementById("addBackdrop").style.display = "flex";
                        document.getElementById("addTruckInterface").style.display = "flex";
                    </script>
                @endif
                <h2 class="adderTitle">{{ __('Ingresar Vehiculo') }}</h2>
                <form action="{{ route('vehiculos.store') }}" method="POST">
                    @csrf
                    <div class="inputBox" style="display: flex; justify-content: space-between; margin-top: 10vh">
                        <label for="tipo" style="font-size: 2vh">{{ __('Tipo') }} </label>
                        <select name="tipo" id="tipo">
                            <option value="camion">{{ __('Camion') }}</option>
                            <option value="camioneta">{{ __('Camioneta') }}</option>
                        </select>
                    </div>
                    <div class="inputBox" style="display: flex; justify-content: space-between;">
                        <label for="matricula" style="font-size: 2vh">{{ __('Matricula') }}</label>
                        <input type="text" name="matricula" id="matricula" maxlength="7" minlength="7"
                            requiredvalue="{{ old('matricula') }}" pattern="[A-Za-z]{3}[0-9]{4}" autocomplete="off">
                        @error('matricula')
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
                    <div class="inputBox" style="display: flex; justify-content: space-between;">
                        <label for="peso_max" style="font-size: 2vh">{{ __('Peso Maximo') }}(kg)</label>
                        <input type="number" name="peso_max" id="peso_max" required
                            value="{{ old('peso_max', $vehiculo->peso_max) }}" autocomplete="off">
                        @error('peso_max')
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

<script src="../javascript/scriptAdministrador.js"></script>
