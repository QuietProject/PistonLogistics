<div>
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" id="nombre" required value="{{ old('nombre',$almacen->nombre) }}">
    @error('nombre')
        <span style="color: red">{{ $message }}</span>
    @enderror
</div>
<div>
    <label for="direccion">Direccion</label>
    <input type="text" name="direccion" id="direccion" step="0.1" value="{{ old('direccion',$almacen->direccion) }}">
    @error('direccion')
        <span style="color: red">{{ $message }}</span>
    @enderror
</div>

