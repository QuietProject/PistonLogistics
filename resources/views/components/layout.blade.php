<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://kit.fontawesome.com/b9577afa32.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="../css/style.css">
    @isset($import1)
        <link rel="stylesheet" href="{{ $import1 }}">
    @endisset
    @isset($import2)
        <link rel="stylesheet" href="{{ $import2 }}">
    @endisset
    @isset($import3)
        <link rel="stylesheet" href="{{ $import3 }}">
    @endisset
    <title>{{ __($titulo) ?? '' }} - Piston logistics</title>
</head>

<body>
    @if (session('success'))
    Swal.fire({{ session('success') }});
    @endif
    @if (session('error'))
    Swal.fire({{ session('error') }});
    @endif
    <div class="navDiv">
    <a href="{{ route('camioneros.index') }}" class="button {{ $menu == '1' ? 'active' : 'inactive' }}"><i class="fa-solid fa-id-card"></i></a>
    <a href="{{ route('usuarios.index') }}" class="button {{ $menu == '2' ? 'active' : 'inactive' }}"><i class="fa-solid fa-user"></i></a>
    <a href="{{ route('almacenes.index') }}" class="button {{ $menu == '3' ? 'active' : 'inactive' }}"><i class="fa-solid fa-warehouse"></i></a>
    <a href="{{ route('troncales.index') }}" class="button {{ $menu == '4' ? 'active' : 'inactive' }}"><i class="fa-solid fa-road"></i></a>
    <a href="{{ route('vehiculos.index') }}" class="button {{ $menu == '5' ? 'active' : 'inactive' }}"><i class="fa-solid fa-truck"></i></a>
    <a href="{{ route('clientes.index') }}" class="button {{ $menu == '6' ? 'active' : 'inactive' }}"><i class="fa-solid fa-briefcase"></i></a>
    <a href="{{ route('asignar') }}" class="button {{ $menu == '7' ? 'active' : 'inactive' }}"><i class="fa-solid fa-box"></i></a>
    <a href="{{route("locale", app()->getLocale()=='es'? 'en':'es')}}" class="buttonEnd" style="bottom: 3vw;"><i class="fa-solid fa-language"></i></a>
    <a href="{{ route('logout') }}" class="buttonEnd" style="bottom: 0;"><i class="fa-solid fa-right-from-bracket"></i></a>
    </div>

    {{ $slot }}

</body>

</html>
