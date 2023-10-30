<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contraseña olvidada - Piston Logistics</title>
</head>
<body>
    <h1>Piston Logistics</h1>
    <h2>Contraseña olvidada</h2>
    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ request()->route('token') }}">
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required value="{{ old('email') }}">
            @error('email')
                <span style="color: red">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" required
                value="{{ old('password') }}">
            @error('password')
                <span style="color: red">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="password_confirmation">Repita su contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
                value="{{ old('password_confirmation') }}">
            @error('password_confirmation')
                <span style="color: red">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
