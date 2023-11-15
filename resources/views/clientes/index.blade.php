<x-layout menu="6" titulo="Clientes" import1="../css/styleClientes.css">
    <div class="addBackdrop disabled" id="addBackdrop"></div>
    <div class="display">
        <h2 class="titleText">{{ __('Clientes') }}</h2>
        <input type="text" id="searchInput" class="filterText" placeholder={{ __('Buscar') }} onkeyup="searchFilter()">
        <div class="tableContainer">
            <table class="tableView">
                <thead>
                    <tr>
                        <th style="width: 33%;" onclick="sortTable(0);arrowsTable(0);" id="0">RUT</th>
                        <th style="width: 33%;" onclick="sortTable(0);arrowsTable(1);" id="0">
                            {{ __('Nombre') }}</th>
                        <th style="width: 33%;" onclick="sortTable(0);arrowsTable(2);" id="0">
                            {{ __('Baja') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $cliente)
                        <tr>
                            <td><a href="{{ route('clientes.show', $cliente->RUT) }}"> {{ $cliente->RUT }}</a> </td>
                            <td>{{ $cliente->nombre }}</td>
                            <td>
                                <form action="{{ route('clientes.destroy', $cliente->RUT) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="switchBtn">
                                        @if ($cliente->baja)
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
        <div class="editContainer">
            <h2 class="asignadoText">{{ __('Ingresar cliente') }}</h2>
            <form action="{{ route('clientes.store') }}" method="POST">
                @csrf
                <div
                    style="display: flex; justify-content: space-between; width: 20vw; left: 7.5vw; position: relative;">
                    <label for="RUT" class="asignadoText">RUT</label>
                    <input type="number" name="RUT" id="RUT" maxlength="12" minlength="12" required
                        value="{{ old('RUT') }}">
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
                <div
                    style="display: flex; justify-content: space-between; width: 20vw; left: 7.5vw; position: relative; margin-top: 1vh">
                    <label for="nombre" class="asignadoText">{{ __('Nombre') }}</label>
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
                <button type="submit" class="switchBtn" style="margin-top: 1vh">{{ __('Confirmar') }}</button>
            </form>
        </div>
    </div>
</x-layout>

<script src="../javascript/scriptAlmacenes.js"></script>
<script src="../javascript/scriptUsuario.js"></script>
