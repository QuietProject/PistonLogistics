@if ($errors->any())
    abre el formulario
@endif
<h2>Ingresar Almacen</h2>
<form action="{{ route('almacenes.store') }}" method="POST">
    @csrf
    <div>
        <label for="tipo">Tipo</label>
        <select name="tipo" id="tipo" >
            <option value="propio">Propio</option>
            <option value="cliente" {{ old('tipo') == 'cliente' ? 'selected' : '' }}>Cliente</option>
        </select>
    </div>
    @include('almacenes.form-fields')
    <label for="RUT">RUT</label>
    <input type="number" name="RUT" id="RUT" maxlength="12" minlength="12" value="{{ old('RUT') }}">
    @error('RUT')
        <span style="color: red">{{ $message }}</span>
    @enderror
    </div> 
    <button type="submit">Submit</button>

</form>

