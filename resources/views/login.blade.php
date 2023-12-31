<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/styleLogin.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Piston Logistics</title>
</head>

<body>
    <a class="cambioIdioma" href="{{ route('locale', app()->getLocale() == 'es' ? 'en' : 'es') }}">
        <div>
            <h2>{{ app()->getLocale() == 'es' ? 'en' : 'es' }}</h2>
        </div>
    </a>
    <form class="logInContainer" method="POST" action=" {{ route('login') }} ">
        @csrf

        <div>
            <i class='bx bxs-truck'></i>
            <h1 class="{{ app()->getLocale() }}">{{ __("Iniciar Sesión") }}</h1>
            <i class='bx bxs-truck'></i>
        </div>

        <div>
            <input type="text" name="user" required placeholder="{{ __("Usuario") }}" autocomplete="username">
            <input type="password" name="password" required placeholder="{{ __("Contraseña") }}" minlength="8">
        </div>
        <div>
            <a href="{{ env("BACKOFFICE_URL") }}?front">¿Olvidaste tu contraseña?</a>
            <input type="submit" value="{{ __("Iniciar Sesión") }}" id="buttonLogIn">
        </div>
    </form>
</body>

</html>
