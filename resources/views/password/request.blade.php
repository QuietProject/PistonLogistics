<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/stylePswForg.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>{{ __('Contraseña olvidada') }} - Piston Logistics</title>
</head>

<body>
    <div class="logInContainer">
        <h1 class="title">Piston Logistics</h1>
        <h2 class="title" style="font-size: 3vh; margin-top: 1vh; color: var(--baseDark)">
            {{ __('Contraseña olvidada') }}</h2>
        <form action="#{{-- route('clientes.store') --}}" method="POST">
            @csrf
            <div class="inputBox">
                <label for="email" class="inputTitle">{{ __('Email') }}</label>
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
                <input type="submit" value="{{ __('Confirmar') }}" class="submitBtn">
            </div>
        </form>
        <div style="width: 100%; height: 10%; position: relative; text-align: center">
            <a href="{{ route('login') }}" class="forgotBox">{{ __('Volver') }}</a>
        </div>
    </div>
</body>

</html>
