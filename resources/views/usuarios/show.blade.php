<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="#">
    <link rel="stylesheet" href="../css/style.css ">
    <link rel="stylesheet" href="../css/styleUsuarios.css">
    <script src="https://kit.fontawesome.com/b9577afa32.js" crossorigin="anonymous"></script>
    <title>Piston Logistics</title>
</head>

<body>
    <div class="navDiv">
        <a href="{{ route('camioneros.index') }}" class="button inactive"></a>
        <a href="{{ route('usuarios.index') }}" class="button active" id="btnRutes"></a>
        <a href="{{ route('almacenes.index') }}" class="button inactive" id="btnWarehouses"></a>
        <a href="{{ route('troncales.index') }}" class="button inactive" id="btnProducts"></a>
        <a href="{{ route('vehiculos.index') }}" class="button inactive"></a>
        <a href="{{ route('clientes.index') }}" class="button inactive"></a>
    </div>
    <div class="display">
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
        </form>
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
    </div>
</body>

</html>

<script src="../javascript/scriptAdministrador.js"></script>
<script src="../javascript/scriptUsuario.js"></script>
