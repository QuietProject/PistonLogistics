@if ($errors->any())
    abre el formulario
@endif
<h2>Editar Troncal</h2>
<form action="{{ route('troncales.update', $troncal) }}" method="POST">
    @csrf
    @method('PATCH')
    <div>
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" id="nombre" required value="{{ old('nombre',$troncal->nombre) }}">
        @error('nombre')
            <span style="color: red">{{ $message }}</span>
        @enderror
    </div>
    <button type="submit">Submit</button>
</form>
