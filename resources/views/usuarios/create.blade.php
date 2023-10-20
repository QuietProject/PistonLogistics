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
        <input type="number" name="CI" id="CI" maxlength="8" minlength="8" required
            value="{{ old('CI   ') }}">
        @error('RUT')
            <span style="color: red">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="CI">CI</label>
        <input type="number" name="CI" id="CI" maxlength="8" minlength="8" required
            value="{{ old('CI   ') }}">
        @error('RUT')
            <span style="color: red">{{ $message }}</span>
        @enderror
    </div>
    {{-- ALMACENES --}}
    <button type="submit">Submit</button>
</form>
