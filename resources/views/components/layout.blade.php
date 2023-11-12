<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @isset($import1)
        <link rel="stylesheet" href="{{ $import1 }}">
    @endisset
    @isset($import2)
        <link rel="stylesheet" href="{{ $import2 }}">
    @endisset
    @isset($import3)
        <link rel="stylesheet" href="{{ $import3 }}">
    @endisset
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
    <a href="{{ route('asignar') }}">Asignar</a>
    <a href="{{ route('logout') }}">Cerrar Sesion</a>

    <span>user: {{ auth()->user()->user }}</span>

    @isset($menu)
        {{-- DESPUES CUANDO ARRANQUES A IMPLEMENTAR LAYOUT SACA EL ISSET ASI TE SALTA LAS QUE TE OLVIDASTE  --}}

        <h4>{{ $menu == '1' ? 'active' : 'inactive' }}</h4>
        <h4>{{ $menu == '2' ? 'active' : 'inactive' }}</h4>
        <h4>{{ $menu == '3' ? 'active' : 'inactive' }}</h4>
        <h4>{{ $menu == '4' ? 'active' : 'inactive' }}</h4>
    @endisset

    @if (session('success'))
        <h4 style="color: green;">{{ session('success') }}</h4>
    @endif
    @if (session('error'))
        <h4 style="color: red;">{{ session('error') }}</h4>
    @endif

    {{ $slot }}

</body>

</html>
