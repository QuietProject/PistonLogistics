<x-layout menu="1" titulo="Camioneros" import1="../css/styleCamioneros.css">
    <div class="addBackdrop disabled" id="addBackdrop"></div>
    <div class="display" id="displayTrucks">
        <!-- Title -->
        <h1 class="titleText">{{ __('Camioneros') }}</h1>
        <!-- Add Button -->
        <input type="button" value={{ __('Agregar') }} class="addButton" id="addTruck">
        <!-- SearchBar -->
        <input type="text" id="searchInput" class="filterText" placeholder={{ __('Buscar') }}
            onkeyup="searchFilter()">
        <!-- Tables Container -->
        <div class="tableContainer">
            <!-- Driver Table -->
            <table class="tableView" id="tableDriver">
                <thead>
                    <tr>
                        <th style="width: 25%;" onclick="sortTable(0);arrowsTable(0);" id="0">
                            {{ __('CI') }} </th>
                        <th style="width: 35%;" onclick="sortTable(1);arrowsTable(1);" id="1">
                            {{ __('Nombre') }}</th>
                        <th style="width: 20%;" onclick="sortTable(2);arrowsTable(2);" id="2">
                            {{ __('Estado') }}</th>
                        <th style="width: 20%;" onclick="sortTable(3);arrowsTable(3);" id="3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($camioneros as $camionero)
                        <tr>
                            <td><a href="{{ route('camioneros.show', $camionero->CI) }}"> {{ $camionero->CI }}</a> </td>
                            <td>{{ $camionero->nombre }}</td>
                            <td>
                                <form action="{{ route('camioneros.destroy', $camionero->CI) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    @if ($camionero->baja)
                                        {{ __('Inactivo') }}
                                    @else
                                        {{ __('Activo') }}
                                    @endif
                                </form>
                            </td>
                            <td>
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
                <h2 class="adderTitle">{{ __('Ingresar Camionero') }}</h2>
                <form action="{{ route('camioneros.store') }}" method="POST">
                    @csrf
                    <div class="inputBox" style="margin-top: 12.5vh">
                        <label for="CI" style="font-size: 2vh">{{ __('Cedula') }}</label>
                        <input type="number" name="CI" id="CI" maxlength="8" minlength="8" required
                            value="{{ old('CI') }}">
                        @error('CI')
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
                    <div class="inputBox">
                        <label for="nombre" style="font-size: 2vh">{{ __('Nombre') }}</label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}">
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
                    <button type="submit" class="submitBtn">{{ __('Confirmar') }}</button>
                </form>
            </div>
        </div>
    </div>
</x-layout>

<script src="../javascript/scriptCamionero.js"></script>
