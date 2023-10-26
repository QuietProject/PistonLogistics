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
            <option value="cliente" {{ old('tipo') == 'cliente' ? 'selected' : '' }}>Cliente</option>
        </select>
    </div>
    @include('almacenes.form-fields')
    <div>
        <label for="RUT">Cliente</label>
        <select name="RUT" id="RUT">
            @foreach ($empresas as $cliente)
                @if ($cliente->baja == 0)
                    <option value="{{ $cliente->RUT }}">{{ $cliente->nombre }} - {{ $cliente->RUT }}</option>
                @endif
            @endforeach
        </select>
        @error('RUT')
            <span style="color: red">{{ $message }}</span>
        @enderror
    </div>
    <button type="submit">Submit</button>

</form>
