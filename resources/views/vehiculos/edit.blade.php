<x-layout titulo='Editar Vehiculo'>

    <h2>Editar Vehiculo</h2>
    <form action="{{ route('vehiculos.update',$vehiculo) }}" method="POST">
        @csrf
        @method('PATCH')
        @include('vehiculos.form-fields')
    </form>

    <a href="{{ route('vehiculos.show',$vehiculo) }}">Volver</a>


</x-layout>
