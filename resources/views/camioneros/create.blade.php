<x-layout titulo='Ingresar Camionero'>
    <h2>Ingresar Camionero</h2>

    <form action="{{ route('camioneros.store')}}" method="POST">
        @csrf
        <label for="Cedula">Cedula</label>
        <input type="number" maxlength="8" minlength="8" required name="CI">
        <label for="Nombre">Nombre</label>
        <input type="text" name="nombre">
        <label for="Apellido">Apellido</label>
        <input type="text" name="apellido">
        <button type="submit">Submit</button>
    </form>

    <a href="{{ route('camioneros.index') }}">Volver</a>


</x-layout>
