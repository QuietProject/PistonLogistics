<x-layout titulo='Ingresar cliente'>
    <h2>Ingresar cliente</h2>
    <form action="{{ route('clientes.store') }}" method="POST">
        @csrf
        <div>
            <label for="RUT">RUT</label>
            <input type="number" name="RUT" id="RUT" maxlength="12" minlength="12" required value="{{ old('RUT') }}">
            @error('RUT')
                <span style="color: red">{{ $message }}</span>
            @enderror
        </div>
        @include('clientes.form-fields')
    </form>

    <a href="{{ route('clientes.index') }}">Volver</a>


</x-layout>
