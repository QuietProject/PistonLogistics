<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/styleLogin.css">
    <script src="https://kit.fontawesome.com/b9577afa32.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>{{ __('Iniciar Sesion') }} - Piston Logistics</title>
</head>

<body>
    <div class="logInContainer">
        <h1 class="title">Piston Logistics<br>{{ __('Iniciar Sesion') }}</h1>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="inputBox">
                <label for="user" class="inputTitle">{{ __('Usuario') }}</label>
                <input type="text" name="user" id="user" required>
                @error('user')
                    <script>
                        Swal.fire({
                            icon: "error",
                            title: "{{ $message }}",
                            showConfirmButton: false,
                            timer: 1000
                        });
                    </script>
                @enderror
            </div>
            <div class="inputBox">
                <label for="password" class="inputTitle">{{ __('Contraseña') }} </label>
                <input type="password" name="password" id="password" required>
                @error('password')
                    <script>
                        Swal.fire({
                            icon: "error",
                            title: "{{ $message }}",
                            showConfirmButton: false,
                            timer: 1000
                        });
                    </script>
                @enderror
            </div>
            <div class="inputBox2">
                <button type="submit" class="submitBtn">{{ __('Iniciar Sesion') }}</button>
                @error('authError')
                    <script>
                        Swal.fire({
                            icon: "error",
                            title: "{{ $message }}",
                            showConfirmButton: false,
                            timer: 1000
                        });
                    </script>
                @enderror
            </div>
            <div class="cbxPass">
                <p>{{ __('Cambiar Idioma') }}</p>
                <a href="{{ route('locale', app()->getLocale() == 'es' ? 'en' : 'es') }}" class="langBtn"><i
                        class="fa-solid fa-language" style="margin-top: 2.25vh"></i></a>
            </div>
            <div class="cbxPass2">
                <label for="remember">{{ __('Mantener Sesion Inciada') }}</label>
                <input type="checkbox" name="remember" id="remember" style="margin: 0; height: 2.5vw; width: 2.5vw">
            </div>
            <div style="width: 100%; height: 10%; top: 12.5vh; position: relative; text-align: center">
                <a href="{{ route('password.request') }}" class="forgotBox">{{ __('¿Olvidaste tu contraseña?') }}</a>
            </div>
        </form>
    </div>

</body>

</html>
