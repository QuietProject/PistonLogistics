<x-layout 
    titulo='Agregar usuarios'
>
    <h2>Agregar usuarios</h2>
    @dump($errors)

    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf
        <div>  
            <label for="user">Usuario:</label>
            <input type="text" id="user" name="username" maxlength="20" value="{{ old('username') }}">
            @error('username')
                <span>{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="pass">Contraseña: </label>
            <input type="text" id="pass" name="contrasena" maxlength="20"
                value="{{ old('contrasena', 'Piston.Logistics') }}">
            @error('contrasena')
                <span>{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="nombre">nombre:</label>
            <input type="text" id="nombre" name="nombre" maxlength="32" value="{{ old('nombre') }}">
            @error('nombre')
                <span>{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="apellido">apellido:</label>
            <input type="text" id="apellido" name="apellido" maxlength="32" value="{{ old('apellido') }}">
            @error('apellido')
                <span>{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="celular">Celular:</label>
            <input type="number" id="celular" name="celular" maxlength="9" minlength="4"
                value="{{ old('celular') }}">
            @error('celular')
                <span>{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="rol">Rol: </label>
            <select id="rol" name="rol">
                <option value="0">Administrador</option>
                <option value="1">Funcionario Almacen</option>
                <option value="2">Camionero</option>
            </select>
            @error('rol')
                <span>{{ $message }}</span>
            @enderror
        </div>
        <div id="divLicencia" hidden>
            <label for="licencia">licencia: </label>
            <select id="licencia" name="licencia">
                <option value="0">A/E</option>
                <option value="1">B</option>
                <option value="2">C/F</option>
                <option value="3">D</option>
            </select>
            @error('licencia')
                <span>{{ $message }}</span>
            @enderror
        </div>
        <button type="submit">Agregar</button>
    </form>
    <script>
        document.getElementById('rol').addEventListener('change', function(e) {
            let licencia = document.getElementById('divLicencia');
            if (e.target.value == '2') {
                licencia.removeAttribute('hidden')
            } else {
                licencia.setAttribute('hidden', '')
            }
        });
    </script>




</x-layout>
