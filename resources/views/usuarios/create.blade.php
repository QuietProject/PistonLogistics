@if ($errors->any())
    abre el formulario
@endif
<h2>Ingresar usuario</h2>
<form action="{{ route('usuarios.store') }}" method="POST">
    @csrf
    <div>
        <label for="tipo">Tipo</label>
        <select name="tipo" id="tipo">
            <option value="0">Administrador</option>
            <option value="1" {{ old('tipo') == '1' ? 'selected' : '' }}>Almacen</option>
            <option value="2" {{ old('tipo') == '2' ? 'selected' : '' }}>Camionero</option>
            <option value="3" {{ old('tipo') == '3' ? 'selected' : '' }}>Cliente</option>
        </select>
    </div>
    <div>
        <label for="CI">CI</label>
        <input type="number" name="CI" id="CI" maxlength="8" minlength="8" value="{{ old('CI') }}">
        @error('CI')
            <span style="color: red">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="camionero">Camionero</label>
        <select name="camionero" id="camionero">
            @foreach ($camioneros as $camionero)
                @if ($camionero->baja == 0)
                    <option value="{{ $camionero->CI }}" {{ old('camionero') == $camionero->CI ? 'selected' : '' }}>
                        {{ $camionero->CI }} - {{ $camionero->nombre }}</option>
                @endif
            @endforeach
        </select>
        @error('camionero')
            <span style="color: red">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="cliente">Cliente</label>
        <select id="cliente" name="cliente">
            @foreach ($clientes as $cliente)
                @if ($cliente->baja == 0)
                    <option value="{{ $cliente->RUT }}" {{ old('cliente') == $cliente->RUT ? 'selected' : '' }}>
                        {{ $cliente->RUT }} - {{ $cliente->nombre }}</option>
                @endif
            @endforeach
        </select>
        @error('almacenCliente')
            <span style="color: red">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="almacenCliente">Almacen</label>
        <select name="almacenCliente" id="almacenCliente">
            @foreach ($almacenesClientes as $almacenCliente)
                @php
                    $almacen = $almacenCliente->almacen;
                    $cliente = $almacenCliente->cliente;
                @endphp
                @if ($almacen->baja == 0 && $cliente->baja == 0)
                    <option value="{{ $almacen->ID }}" {{ old('almacenCliente') == $almacen->ID ? 'selected' : '' }}>
                        {{ $almacen->ID }} - {{ $almacen->nombre }}</option>
                @endif
            @endforeach
        </select>
        @error('almacenCliente')
            <span style="color: red">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="almacenPropio">Almacen</label>
        <select name="almacenPropio" id="almacenPropio">
            @foreach ($almacenesPropios as $cliente)
                @php $almacen = $cliente->almacen @endphp
                @if ($almacen->baja == 0)
                    <option value="{{ $almacen->ID }}" {{ old('almacenPropio') == $almacen->ID ? 'selected' : '' }}>
                        {{ $almacen->ID }} - {{ $almacen->nombre }}</option>
                @endif
            @endforeach
        </select>
        @error('almacenPropio')
            <span style="color: red">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required value="{{ old('email') }}">
        @error('email')
            <span style="color: red">{{ $message }}</span>
        @enderror
    </div>
    {{-- ALMACENES --}}
    <button type="submit">Submit</button>
</form>
