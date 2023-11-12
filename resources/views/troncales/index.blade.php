<x-layout menu="4" titulo="Troncales" import1="../css/styleTroncales.css">
    <div class="addBackdrop disabled" id="addBackdrop"></div>
    <div class="display">
        <h2 class="titleText">Troncales</h2>
        <input type="button" value="Agregar" class="addButton" id="addTruck">
        <input type="text" id="searchInput" class="filterText" placeholder="Search" onkeyup="searchFilter()">
        <div class="tableContainer">
            <table class="tableView" id="tableTrucks">
                <thead>
                    <tr>
                        <th style="width: 10%;" onclick="sortTable(0);arrowsTable(0);" id="0">ID</th>
                        <th style="width: 30%;" onclick="sortTable(1);arrowsTable(1);" id="0">Nombre</th>
                        <th style="width: 30%;" onclick="sortTable(2);arrowsTable(2);" id="0">Cantidad almacenes</th>
                        <th style="width: 30%;" onclick="sortTable(3);arrowsTable(3);" id="0">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($troncales as $troncal)
                        <tr>
                            <td><a href="{{ route('troncales.show', $troncal) }}"> {{ $troncal->ID }}</a>
                            </td>
                            <td>{{ $troncal->nombre }}</td>
                            <td>{{ count($troncal->ordenes) }}</td>
                            <td>

                                @if ($troncal->baja)
                                    de baja
                                @else
                                    operativo
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
                <h2 class="adderTitle">Ingresar Troncal</h2>
                <form action="{{ route('troncales.store') }}" method="POST">
                    @csrf
                    <div class="inputBox" style="top 20%">
                        <label for="nombre" style="font-size: 2vh;">Nombre</label>
                        <input style="inputBox" type="text" name="nombre" id="nombre" required
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

<script src="../javascript/scriptAdministrador.js"></script>
