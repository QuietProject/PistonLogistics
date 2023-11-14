<x-layout menu="4" titulo="Troncal" import1="../css/styleTroncalesShow.css">
    <div class="addBackdrop disabled" id="addBackdrop"></div>
    <div class="display">
        <h2 class="titleText">{{ __('Troncal') }}</h2>
        <a href="{{ route('ordenes.edit', $troncal) }}" class="addButton"
            style="width: 15vw; color: black; text-shadow: none;">
            <p style="text-align: center; margin-top: 1.5vh">{{ __('Editar ordenes') }}</p>
        </a>
        <h3 class="tableTitle">{{ __('Almacenes') }}</h3>
        <div class="tableContainer">
            <table class="tableView">
                <thead>
                    <tr>
                        <th style="width: 10%;" onclick="sortTable(0);arrowsTable(0);" id="0">ID</th>
                        <th style="width: 30%;" onclick="sortTable(0);arrowsTable(0);" id="0">
                            {{ __('Almacen') }}</th>
                        <th style="width: 30%;" onclick="sortTable(0);arrowsTable(0);" id="0">
                            {{ __('Numero') }}</th>
                        <th style="width: 30%;" onclick="sortTable(0);arrowsTable(0);" id="0">
                            {{ __('Baja') }}</th>
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
                                    {{ __('De alta') }}
                                @else
                                    {{ __('El almacen esta dado de baja') }}
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
                <p class="asignadoText">{{ __('Nombre') }}: </p>
                <p class="asignadoText">{{ $troncal->nombre }}</p>
            </div>
            <form action="{{ route('troncales.destroy', $troncal->ID) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="switchBtn" style="margin-top: 1vh">
                    @if ($troncal->baja)
                        {{ __('Dar de Alta') }}
                    @else
                        {{ __('Dar de Baja') }}
                    @endif
                </button>
            </form>
            <form action="{{ route('troncales.update', $troncal) }}" method="POST">
                @csrf
                @method('PATCH')
                <p style="font-size: 3vh; color: white; margin-top: 7.5vh; font-weight: 500">{{ __('Cambiar Nombre') }}
                </p>
                <div class="asignadoText" style="display: flex; justify-content: space-between"">
                    <label for="nombre" style="font-size: 2vh">{{ __('Nombre') }}</label>
                    <input type="text" name="nombre" id="nombre" required
                        value="{{ old('nombre', $troncal->nombre) }}">
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
                <button type="submit" class="switchBtn" style="margin-top: 1vh">{{ __('Confirmar') }}</button>
            </form>
        </div>
    </div>
</x-layout>

<script src="../javascript/scriptAdministrador.js"></script>
