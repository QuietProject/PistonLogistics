<x-layout menu="2" titulo="Usuarios" import1="../css/styleUsuarios.css">
    <div class="display">
        <h2 class="titleText">Usuario</h2>
        <div class="tableContainer">
            <div style="display: flex; justify-content: space-between">
                <p class="asignadoText">Usuario: </p>
                <p class="asignadoText">{{ $user->user }}</p>
            </div>
            <div style="display: flex; justify-content: space-between">
                <p class="asignadoText">Rol: </p>
                <p class="asignadoText">
                    @switch($user->rol)
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
            </div>
            <div style="display: flex; justify-content: space-between">
                <p class="asignadoText">Correo: </p>
                <p class="asignadoText">{{ $user->email }}</p>
            </div>
            <div style="display: flex; justify-content: space-between">
                <p class="asignadoText">Correo verificado:</p>
                <p class="asignadoText">
                    {{ $user->hasVerifiedEmail() ? \Carbon\Carbon::parse($user->email_verified_at)->format('d/m/y H:i') : 'No esta verificado' }}
                </p>
            </div>
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
                <button type="submit" class="modBtn">
                    Eliminar
                </button>
            </form>
            </p>
        </div>
        <div class="editContainer">
            <h2 class="asignadoText" style="font-size: 3vh; margin-bottom: 1vh">Editar Usuario</h2>
            <form action="{{ route('usuarios.update', $user) }}" method="POST">
                @csrf
                @method('PATCH')
                <div style="display: flex; justify-content: space-around">
                    <label for="email" class="asignadoText">Email</label>
                    <input type="email" name="email" id="email" required
                        value="{{ old('email', $user->email) }}">
                    @error('email')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="modBtn">Confirmar</button>
            </form>
        </div>
    </div>
</x-layout>

<script src="../javascript/scriptAdministrador.js"></script>
<script src="../javascript/scriptUsuario.js"></script>
