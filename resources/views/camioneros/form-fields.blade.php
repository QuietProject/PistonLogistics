<div>
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $camionero->nombre) }}">
    @error('nombre')
    <span style="color: red">{{ $message }}</span>
    @enderror
</div>
<button type="submit">Submit</button>
