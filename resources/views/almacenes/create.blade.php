@if ($errors->any())
    abre el formulario
@endif
<h2>Ingresar Almacen</h2>
<form action="{{ route('almacenes.store') }}" method="POST">
    @csrf
    <div>
        <label for="tipo">Tipo</label>
        <select name="tipo" id="tipo">
            <option value="propio">Propio</option>
            <option value="cliente" {{ old('tipo') == 'camioneta' ? 'selected' : '' }}>Cliente</option>
        </select>
    </div>
    @include('almacenes.form-fields')
</form>
