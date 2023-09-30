@if ($errors->any())
    abre el formulario
@endif
<h2>Ingresar Vehiculo</h2>
<form action="{{ route('vehiculos.store') }}" method="POST">
    @csrf
    <div>
        <label for="tipo">Tipo</label>
        <select name="tipo" id="tipo">
            <option value="camion">Camion</option>
            <option value="camioneta">Camioneta</option>
        </select>
    </div>
    <div>
        <label for="matricula">Matricula</label>
        <input type="text" name="matricula" id="matricula" maxlength="7" minlength="7" required
            value="{{ old('matricula') }}">
        @error('matricula')
            <span style="color: red">{{ $message }}</span>
        @enderror
    </div>
    @include('vehiculos.form-fields')
</form>
