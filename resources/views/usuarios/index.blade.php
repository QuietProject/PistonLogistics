<x-layout titulo='Usuarios'>
    @include('usuarios.create')
    <h2>Usuarios</h2>
    <table>
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Rol</th>
                <th>Email</th>
                <th>Verificacion email</th>
                <th>eliminar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $user)
                <tr>
                    <td><a href="{{ route('usuarios.show', $user) }}"> {{ $user->user }}</a> </td>
                    <td> @switch($user->rol)
                            @case(0)
                                Administrador
                            @break

                            @case(1)
                                Almacen
                            @break

                            @case(2)
                                Camionero
                            @break

                            @case(3)
                                Cliente
                            @break
                        @endswitch
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->email_verified_at  ? $user->email_verified_at :'-' }}</td>
                    <td>{{ $user->user }}</td>
                    <td>
                        <form action="{{ route('usuarios.destroy', $user) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</x-layout>
