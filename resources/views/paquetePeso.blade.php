<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/stylePaquetePeso.css">
    <link rel="stylesheet" href="./css/styleMenu.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Almacen</title>
</head>

<body>
    <!-- Ham Menu -->
    <div class="menuIcon" id="menuIcon">
        <div>
            <i class='bx bx-menu' id="menu"></i>
        </div>
    </div>

    <div class="sideMenu" id="sideMenu">
        <div>
            <div>
                <div></div>
                <a href="../almacenCarga">Carga</a>
                <a href="../almacenDescarga">Descarga</a>
                <a href="../verLotes">Lotes</a>
                <a href="../verPaquetes">Paquetes</a>
                <a href="../crearLote">Crear Lote</a>
            </div>

            <div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit">Cerrar sesión</button>
                </form>
            </div>
        </div>
    </div>

    @if (session('message'))
        <script>
            Swal.fire({
                position: 'top',
                icon: 'success',
                title: '{{ session('message') }}',
                showConfirmButton: false,
                timer: 1000,
                customClass: {
                    container: 'popup'
                }
            })
            setTimeout(() => {
                window.location.href = "{{ route('clear.message') }}";
            }, 500);
        </script>
    @endif

    <form method="POST" action=" {{ route('paquetePeso.asignar') }} " id="form">
        @csrf
        <div>
            <h1>Asignar Peso</h1>
            <i class='bx bx-package'></i>
        </div>
        <div>
            <div>
                <h3>Paquete</h3>
                <input type="number" name="paquete" id="paquete" required>
            </div>
            <div>
                <h3>Peso</h3>
                <input type="number" name="peso" id="peso" required>
            </div>
        </div>
        <div>
            <div>
                <input type="submit" value="Asignar" id="btnSubmit">
            </div>
        </div>

    </form>








    <script defer src="./javascript/scriptMenu.js"></script>
    <script defer src="./javascript/scriptPaquetePeso.js"></script>
</body>

</html>
