<x-layout titulo='Editar Cliente'>
    <h2>Editar Cliente</h2>
    <form action="{{ route('clientes.update',$cliente) }}" method="POST">
        @csrf
        @method('PATCH')
        @include('clientes.form-fields')
    </form>

    <a href="{{ route('clientes.show',$cliente) }}">Volver</a>


</x-layout>
