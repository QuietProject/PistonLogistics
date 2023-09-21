<x-layout 
    titulo='Usuarios'
>
    <h2>Usuarios</h2>
    <a href="{{ route('usuarios.create') }}">Agregar usuarios</a>
    @dump($usuarios)
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Telefono</th>
                <th>Rol</th>
                <th>Licencia</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->id }}</td>
                    <td>{{ $usuario->username }}</td>
                    <td>{{ $usuario->nombre }}</td>
                    <td>{{ $usuario->apellido }}</td>
                    <td>{{ $usuario->telefono }}</td>
                    <td>{{ $usuario->rol }}</td>
                    <td>{{ $usuario->licencia }}</td>
                    <td>
                        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-layout>
