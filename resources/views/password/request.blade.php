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
    <form action="#{{-- route('clientes.store') --}}" method="POST">
        @csrf
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" required value="{{ old('email') }}">
            @error('email')
                <span style="color: red">{{ $message }}</span>
            @enderror
        </div>
    </form>
    <a href="{{ route('login') }}">Volver</a>
</body>
</html>
