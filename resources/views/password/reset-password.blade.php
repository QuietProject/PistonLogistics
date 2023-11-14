<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/stylePswForgRst.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>{{ __('Cambiar contraseña') }} - Piston Logistics</title>
</head>

<body>
    <div class="logInContainer">
        <h1 class="title">Piston Logistics</h1>
        <h2 class="title" style="font-size: 3vh; margin-top: 1vh; color: var(--baseDark)">
            {{ __('Cambiar contraseña') }}</h2>
        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ request()->route('token') }}">
            <div class="inputBox">
                <label for="email">{{ __('Email') }}</label>
                <input type="email" name="email" id="email" required value="{{ old('email') }}">
                @error('email')
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
                <label for="password">{{ __('Contraseña') }}</label>
                <input type="password" name="password" id="password" required value="{{ old('password') }}">
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
            <div class="inputBox">
                <label for="password_confirmation">{{ __('Repita su contraseña') }}</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    value="{{ old('password_confirmation') }}">
                @error('password_confirmation')
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
            <button type="submit" class="submitBtn">{{ __('Confirmar') }}</button>
        </form>
    </div>
</body>

</html>
