{{-- @if ($errors->any())
    abre el formulario
@endif
<h2>Editar Cliente</h2>
<form action="{{ route('clientes.update', $cliente) }}" method="POST">
    @csrf
    @method('PATCH')
    @include('clientes.form-fields')
</form> --}}
