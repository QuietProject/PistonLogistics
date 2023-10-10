@if ($errors->any())
    abre el formulario
@endif
<h2>Editar Almacen {{ $tipo }}</h2>
<form action="{{ route('almacenes.update', $almacen) }}" method="POST">
    @csrf
    @method('PATCH')
    @include('almacenes.form-fields')
    <button type="submit">Submit</button>
</form>
