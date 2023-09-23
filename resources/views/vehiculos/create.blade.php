<x-layout titulo='Ingresar Vehiculo'>

    <h2>Ingresar Vehiculo</h2>
    <form action="{{ route('vehiculos.store') }}" method="POST">
        @csrf
        <div>
            <label for="tipo">Tipo</label>
            <select name="tipo" id="tipo">
                <option value="camion">Camion</option>
                <option value="camioneta">Camioneta</option>
            </select>
        </div>
        @include('vehiculos.form-fields')
    </form>

    <a href="{{ route('vehiculos.index') }}">Volver</a>


</x-layout>
