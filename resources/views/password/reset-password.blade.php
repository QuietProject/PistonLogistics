<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __("Cambiar contraseña") }} - Piston Logistics</title>
</head>
<body>
    <h1>Piston Logistics</h1>
    <h2>{{ __("Cambiar contraseña") }}</h2>
    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ request()->route('token') }}">
        <div>
            <label for="email">{{ __("Email") }}</label>
            <input type="email" name="email" id="email" required value="{{ old('email') }}">
            @error('email')
                <span style="color: red">{{ __($message) }}</span>
            @enderror
        </div>
        <div>
            <label for="password">{{ __("Contraseña") }}</label>
            <input type="password" name="password" id="password" required
                value="{{ old('password') }}">
            @error('password')
                <span style="color: red">{{ __($message) }}</span>
            @enderror
        </div>
        <div>
            <label for="password_confirmation">{{ __("Repita su contraseña") }}</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
                value="{{ old('password_confirmation') }}">
            @error('password_confirmation')
                <span style="color: red">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit">{{ __("Confirmar") }}</button>
    </form>
</body>
</html>
