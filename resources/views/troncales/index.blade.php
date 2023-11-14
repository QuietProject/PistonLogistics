<x-layout menu="4" titulo="Troncales" import1="../css/styleTroncales.css">
    <div class="addBackdrop disabled" id="addBackdrop"></div>
    <div class="display">
        <h2 class="titleText">{{ __('Troncales') }}</h2>
        <input type="button" value={{ __('Agregar') }} class="addButton" id="addTruck">
        <input type="text" id="searchInput" class="filterText" placeholder={{ __('Buscar') }}
            onkeyup="searchFilter()">
        <div class="tableContainer">
            <table class="tableView" id="tableTrucks">
                <thead>
                    <tr>
                        <th style="width: 10%;" onclick="sortTable(0);arrowsTable(0);" id="0">ID</th>
                        <th style="width: 30%;" onclick="sortTable(1);arrowsTable(1);" id="0">
                            {{ __('Nombre') }}</th>
                        <th style="width: 30%;" onclick="sortTable(2);arrowsTable(2);" id="0">
                            {{ __('Cantidad almacenes') }}</th>
                        <th style="width: 30%;" onclick="sortTable(3);arrowsTable(3);" id="0">
                            {{ __('Estado') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($troncales as $troncal)
                        <tr>
                            <td><a href="{{ route('troncales.show', $troncal) }}"> {{ $troncal->ID }}</a>
                            </td>
                            <td>{{ $troncal->nombre }}</td>
                            <td>{{ $troncal->cantidadOrdenes }}</td>
                            <td>

                                @if ($troncal->baja)
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
                <h2 class="adderTitle">{{ __('Ingresar Troncal') }}</h2>
                <form action="{{ route('troncales.store') }}" method="POST">
                    @csrf
                    <div class="inputBox" style="top 20%">
                        <label for="nombre" style="font-size: 2vh;">{{ __('Nombre') }}</label>
                        <input style="inputBox" type="text" name="nombre" id="nombre" required
                            value="{{ old('nombre') }}">
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

<script src="../javascript/scriptAdministrador.js"></script>
