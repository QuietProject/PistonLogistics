<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $titulo ?? '' }} - Piston logistics</title>
</head>

<body>

    <a href="{{ route('inicio') }}" style="text-decoration: none; color:black;">
        <h1>Piston logistics</h1>
    </a>
    <a href="{{ route('camioneros.index') }}">Camioneros</a>
    <a href="{{ route('usuarios.index') }}">Usuarios</a>
    <a href="{{ route('almacenes.index') }}"">Almacenes</a>
    <a href="{{ route('troncales.index') }}"">Troncales</a>
    <a href="{{ route('vehiculos.index') }}"">Vehiculos</a>
    <a href="{{ route('clientes.index') }}"">Clientes</a>
    <a href="{{ route('logout') }}">Cerrar Sesion</a>
    <a href="{{ route('lleva.index') }}">Asignar Lleva</a>
    <span>user: {{ auth()->user()->user }}</span>

    @if (session('success'))
        <h4 style="color: green;">{{ session('success') }}</h4>
    @endif
    @if (session('error'))
        <h4 style="color: red;">{{ session('error') }}</h4>
    @endif

    {{ $slot }}

</body>

</html>
