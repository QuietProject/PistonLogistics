<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $titulo ?? '' }} - Piston logistics</title>
</head>

<body>

    <x-nav />

    @if (session('success'))
        <h4 style="color: green;">{{ session('success') }}</h4>
    @endif
    @if (session('warn'))
        <h4 style="color: orange;">{{ session('warn') }}</h4>
    @endif
    @if (session('error'))
        <h4 style="color: red;">{{ session('error') }}</h4>
    @endif

    {{ $slot }}

</body>

</html>