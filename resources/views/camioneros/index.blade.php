<x-layout menu="1" titulo="Conductores" import1="../css/styleCamioneros.css">
    <div class="addBackdrop disabled" id="addBackdrop"></div>
    <div class="display" id="displayTrucks">
        <!-- Title -->
        <h1 class="titleText">Conductores</h1>
        <!-- Add Button -->
        <input type="button" value="Agregar" class="addButton" id="addTruck">
        <!-- SearchBar -->
        <input type="text" id="searchInput" class="filterText" placeholder="Search" onkeyup="searchFilter()">
        <!-- Tables Container -->
        <div class="tableContainer">
            <!-- Driver Table -->
            <table class="tableView" id="tableDriver">
                <thead>
                    <tr>
                        <th style="width: 25%;" onclick="sortTable(0);arrowsTable(0);" id="0">CI </th>
                        <th style="width: 35%;" onclick="sortTable(1);arrowsTable(1);" id="1">Nombre</th>
                        <th style="width: 20%;" onclick="sortTable(2);arrowsTable(2);" id="2">Estado</th>
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
                                        Inactivo
                                    @else
                                        Activo
                                    @endif
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('camioneros.destroy', $camionero->CI) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="switchBtn">
                                        @if ($camionero->baja)
                                            Dar de Alta
                                        @else
                                            Dar de Baja
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
                <h2 class="adderTitle">Ingresar Camionero</h2>
                <form action="{{ route('camioneros.store') }}" method="POST">
                    @csrf
                    <div class="inputBox" style="margin-top: 12.5vh">
                        <label for="CI" style="font-size: 2vh">Cedula</label>
                        <input type="number" name="CI" id="CI" maxlength="8" minlength="8" required
                            value="{{ old('CI') }}">
                        @error('CI')
                            <span style="color: red">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="inputBox">
                        <label for="nombre" style="font-size: 2vh">Nombre</label>
                        <input type="text" name="nombre" id="nombre"
                            value="{{ old('nombre') }}">
                        @error('nombre')
                            <span style="color: red">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit" class="submitBtn">Confirmar</button>
                </form>
            </div>
        </div>
    </div>
</x-layout>

<script src="../javascript/scriptCamionero.js"></script>
