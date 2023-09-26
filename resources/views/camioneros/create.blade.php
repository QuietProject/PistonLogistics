<x-layout titulo='Ingresar Camionero'>
    <h2>Ingresar Camionero</h2>
    <form action="{{ route('camioneros.store') }}" method="POST">
        @csrf
        <div>
            <label for="CI">Cedula</label>
            <input type="number" name="CI" id="CI" maxlength="8" minlength="8" required value="{{ old('CI') }}">
            @error('CI')
                <span style="color: red">{{ $message }}</span>
            @enderror
        </div>
        @include('camioneros.form-fields')
    </form>

    <a href="{{ route('camioneros.index') }}">Volver</a>


</x-layout>
