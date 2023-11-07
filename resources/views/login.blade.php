<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __("Iniciar Sesion") }} - Piston Logistics</title>
</head>
<body>
    <h1>{{ __("Iniciar Sesion") }} - Piston Logistics</h1>
    <form action="{{ route('login') }}" method="POST">
        @csrf

        <div>
            <label for="user">{{ __("Usuario") }}</label>
            <input type="text" name="user" id="user" required>
            @error('user')
                <span style="color: red">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="password">{{ __("Contraseña") }}  </label>
            <input type="password" name="password" id="password" required>
            @error('password')
                <span style="color: red">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="remember">{{ __("Mantener sesion inciada") }}</label>
            <input type="checkbox" name="remember" id="remember">
        </div>
        <button type="submit">{{ __("Iniciar Sesion") }}</button>
        @error('authError')
        <span style="color: red">{{ $message }}</span>
    @enderror
    </form>
    <p>Usuario: prueba Constraseña: submarino</p>
    <a href="{{ route('password.request') }}">{{ __("¿Olvidaste tu contraseña?") }}</a>
    <a href="{{route("locale","es")}}">español</a>
    <a href="{{route("locale","en")}}">ingles</a>
</body>
</html>
