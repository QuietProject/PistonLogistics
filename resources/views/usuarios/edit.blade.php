{{-- @if ($errors->any())
    abre el formulario
@endif
<h2>Editar Usuario</h2>
<form action="{{ route('usuarios.update', $user) }}" method="POST">
    @csrf
    @method('PATCH')
    <div>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required value="{{ old('email', $user->email) }}">
        @error('email')
            <span style="color: red">{{ $message }}</span>
        @enderror
    </div>
    <button type="submit">Submit</button>
</form> --}}
