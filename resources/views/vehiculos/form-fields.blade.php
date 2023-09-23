<div>
    <label for="matricula">Matricula</label>
    <input type="text" name="matricula" id="matricula" maxlength="7" minlength="7" required value="{{ old('matricula') }}">
    @error('matricula')
        <span style="color: red">{{ $message }}</span>
    @enderror
</div>
<div>
    <label for="peso_max">Peso Maximo</label>
    <input type="number" name="peso_max" id="peso_max" required value="{{ old('peso_max') }}">
    <span>kg</span>
    @error('peso_max')
        <span style="color: red">{{ $message }}</span>
    @enderror
</div>
<div>
    <label for="vol_max">Volumen Maximo</label>
    <input type="number" name="vol_max" id="vol_max" step="0.1" required value="{{ old('vol_max') }}">
    <span>m3</span>
    @error('vol_max')
        <span style="color: red">{{ $message }}</span>
    @enderror
</div>
<button type="submit">Submit</button>
