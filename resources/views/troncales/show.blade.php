<x-layout menu="4" titulo="Troncal" import1="../css/styleTroncalesShow.css">
    <div class="addBackdrop disabled" id="addBackdrop"></div>
    <div class="display">
        <h2 class="titleText">Editar Troncal</h2>
        <a href="{{ route('ordenes.edit', $troncal) }}" class="addButton"
            style="width: 15vw; color: black; text-shadow: none;">
            <p style="text-align: center; margin-top: 1.5vh">Editar ordenes</p>
        </a>
        <h3 class="tableTitle">Orden</h3>
        <div class="tableContainer">
            <table class="tableView">
                <thead>
                    <tr>
                        <th style="width: 10%;" onclick="sortTable(0);arrowsTable(0);" id="0">ID</th>
                        <th style="width: 30%;" onclick="sortTable(0);arrowsTable(0);" id="0">Almacen</th>
                        <th style="width: 30%;" onclick="sortTable(0);arrowsTable(0);" id="0">Numero</th>
                        <th style="width: 30%;" onclick="sortTable(0);arrowsTable(0);" id="0">Baja</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ordenes as $orden)
                        <tr>
                            <td><a href="{{ route('almacenes.show', $orden->ID_almacen) }}">
                                    {{ $orden->ID_almacen }}</a></td>
                            <td>
                                <p>{{ $orden->nombre }}</p>
                            </td>
                            <td>{{ $orden->orden }}</td>
                            <td>
                                @if (!$orden->almacenBaja)
                                    De alta
                                @else
                                    El almacen esta dado de baja
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="editContainer">
            <div style="margin-top: 1vh; display: flex; justify-content: space-between">
                <p class="asignadoText">ID: </p>
                <p class="asignadoText">{{ $troncal->ID }}</p>
            </div>
            <div style="margin-top: 1vh; display: flex; justify-content: space-between">
                <p class="asignadoText">Nombre: </p>
                <p class="asignadoText">{{ $troncal->nombre }}</p>
            </div>
            <form action="{{ route('troncales.destroy', $troncal->ID) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="switchBtn" style="margin-top: 1vh">
                    @if ($troncal->baja)
                        Dar de Alta
                    @else
                        Dar de Baja
                    @endif
                </button>
            </form>
            <form action="{{ route('troncales.update', $troncal) }}" method="POST">
                @csrf
                @method('PATCH')
                <p style="font-size: 3vh; color: white; margin-top: 7.5vh; font-weight: 500">Cambiar Nombre</p>
                <div class="asignadoText" style="display: flex; justify-content: space-between"">
                    <label for="nombre" style="font-size: 2vh">Nombre</label>
                    <input type="text" name="nombre" id="nombre" required
                        value="{{ old('nombre', $troncal->nombre) }}">
                    @error('nombre')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="switchBtn" style="margin-top: 1vh">Confirmar</button>
            </form>
        </div>
    </div>
</x-layout>

<script src="../javascript/scriptAdministrador.js"></script>
