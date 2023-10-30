<x-layout titulo='Usuarios'>
    @include('usuarios.edit')
    <h2>Usuario</h2>

    <p>Usuario: {{ $user->user }}</p>
    <p>Rol: @switch($user->rol)
            @case(0)
                Administrador
            @break

            @case(1)
                Almacen
            @break

            @case(2)
                Camionero
            @break

            @case(3)
                Cliente
            @break
        @endswitch
    </p>
    <p>Correo: {{ $user->email }}</p>
    <p>Correo verificado: {{ $user->hasVerifiedEmail() ? $user->email_verified_at : 'No esta verificado' }}</p>
    @if (!$user->hasVerifiedEmail())
        @if (is_null($user->password))
            <form action="{{ route('usuarios.resendPasswordNotification', $user) }}" method="POST">
                @csrf
                <button type="submit">
                    Reenviar mail de verificacion
                </button>
            </form>
        @else
            <form action="{{ route('usuarios.resendEmailNotification', $user) }}" method="POST">
                @csrf
                <button type="submit">
                    Reenviar mail de verificacion
                </button>
            </form>
        @endif
    @endif
    <form action="{{ route('usuarios.destroy', $user) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">
            Eliminar
        </button>
    </form>
    </p>

    <a href="{{ route('usuarios.index') }}">Volver</a>
</x-layout>
