@if ($errors->any())
    abre el formulario
@endif
<h2>Ingresar Troncal</h2>
<form action="{{ route('troncales.store') }}" method="POST">
    @csrf
    <div>
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" required value="{{ old('nombre') }}">
        @error('nombre')
            <span style="color: red">{{ $message }}</span>
        @enderror
    </div>
    <button type="submit">Submit</button>

</form>
