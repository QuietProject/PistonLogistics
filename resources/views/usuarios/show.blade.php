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
        <h2 class="titleText">Usuario</h2>
        <div class="tableContainer">
            <p class="asignadoText">Usuario: {{ $user->user }}</p>
            <p class="asignadoText">Rol: @switch($user->rol)
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
            <p class="asignadoText">Correo: {{ $user->email }}</p>
            <p class="asignadoText">Correo verificado: {{ $user->hasVerifiedEmail() ? $user->email_verified_at : 'No esta verificado' }}</p>
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
            <h2 class="asignadoText">Editar Usuario</h2>
            <form action="{{ route('usuarios.update', $user) }}" method="POST">
                @csrf
                @method('PATCH')
                <div>
                    <label for="email" class="asignadoText">Email</label>
                    <input type="email" name="email" id="email" required
                        value="{{ old('email', $user->email) }}">
                    @error('email')
                        <span style="color: red">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="modBtn">Submit</button>
            </form>
        </div>
    </div>
</body>

</html>

<script src="../javascript/scriptAdministrador.js"></script>
<script src="../javascript/scriptUsuario.js"></script>
