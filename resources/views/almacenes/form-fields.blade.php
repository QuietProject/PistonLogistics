<div>
    <label for="nombre">Nombre</label>
    <input type="number" name="nombre" id="nombre" required value="{{ old('nombre',$almacen->nombre) }}">
    @error('nombre')
        <span style="color: red">{{ $message }}</span>
    @enderror
</div>
<div>
    <label for="direccion">Direccion</label>
    <input type="number" name="direccion" id="direccion" step="0.1" required value="{{ old('direccion',$almacen->direccion) }}">
    @error('direccion')
        <span style="color: red">{{ $message }}</span>
    @enderror
</div>
<button type="submit">Submit</button>
