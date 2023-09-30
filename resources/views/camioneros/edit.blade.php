@if ($errors->any())
    abre el formulario
@endif
    <h2>Editar Camionero</h2>
    <form action="{{ route('camioneros.update', $camionero) }}" method="POST">
        @csrf
        @method('PATCH')
        @include('camioneros.form-fields')
    </form>

    <a href="{{ route('camioneros.show', $camionero) }}">Volver</a>
