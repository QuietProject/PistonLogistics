{{-- @if ($errors->any())
    abre el formulario
@endif
<h2>Editar {{ $tipo }}</h2>
<form action="{{ route('vehiculos.update', $vehiculo) }}" method="POST">
    @csrf
    @method('PATCH')
    @include('vehiculos.form-fields')
</form> --}}
