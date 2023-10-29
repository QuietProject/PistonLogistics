<?php

namespace App\Http\Controllers;

use App\Models\AlmacenCliente;
use App\Models\AlmacenPropio;
use App\Models\Camionero;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::all('user', 'rol', 'email', 'email_verified_at');
        $camioneros = Camionero::all();
        $almacenesPropios = AlmacenPropio::all();
        $almacenesClientes = AlmacenCliente::all();
        return view('usuarios.index', [
            'usuarios' => $usuarios,
            'camioneros' => $camioneros,
            'almacenesPropios' => $almacenesPropios,
            'almacenesClientes' => $almacenesClientes,
            'user' => new User()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function verify($id, $hash)
    {
        $user = User::findOrFail($id);
        if (!hash_equals((string) $user->getKey(), (string) $id)) {
            return 'pollo 1';
        }

        if (!hash_equals(sha1($user->getEmailForVerification()), (string) $hash)) {
            return 'pollo 2';
        }

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();

            event(new Verified($user));
        }
        return 'ajam?';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        switch ($request->input('tipo')) {
                //ADMINISTRADOR
            case 0:
                $validated = $request->validate([
                    'CI' => ['bail', 'required', 'digits:8', 'integer', 'unique:users,user'],
                    'email' => ['required', 'email', 'max:255', 'unique:users,email']
                ]);

                $user = new User();
                $user->rol = 0;
                $user->user = $validated['CI'];
                $user->email = $validated['email'];
                $user->password = bcrypt('password');
                $user->save();
                event(new Registered($user));
                break;
            case 1:
                $validated = $request->validate([
                    'CI' => ['bail', 'required', 'digits:8', 'integer'],
                    'almacenPropio' => ['required', 'integer', 'exists:ALMACENES_PROPIOS,ID', Rule::exists('ALMACENES', 'ID')->where(function (Builder $query) {
                        return $query->where('baja', 0);
                    })],
                    'email' => ['required', 'email', 'max:255', 'unique:users,email']
                ]);
                //validar que no exista nombre de usuario
                break;
            case 2:
                $validated = $request->validate([
                    'camionero' => ['bail', 'required', 'digits:8', 'integer', 'unique:users,user', Rule::exists('CAMIONEROS', 'CI')->where(function (Builder $query) {
                        return $query->where('baja', 0);
                    }),],
                    'email' => ['required', 'email', 'max:255', 'unique:users,email']
                ]);
                $user = new User();
                $user->rol = 2;
                $user->user = $validated['camionero'];
                $user->email = $validated['email'];
                $user->password = bcrypt('password');
                $user->save();
                event(new Registered($user));
                break;
            case 3:
                $validated = $request->validate([
                    'almacenCliente' => ['required', 'integer', 'exists:ALMACENES_CLIENTES_DE_ALTA'],
                    'email' => ['required', 'email', 'max:255', 'unique:users,email']
                ]);
                break;
                //validar que no exista nombre de usuario
            default:
                return redirect()->back()->with('error', 'Ha ocurrido un error');
                break;
        }
        return redirect()->back()->with('success', 'Si');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('usuarios.show', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function resendNotification(User $user)
    {
        if ($user->hasVerifiedEmail()) {
            return back()->with('error', 'El usuario ya verificó su email');
        }
        $user->sendEmailVerificationNotification();
        return back()->with('success', 'Se reenvió el correo de verificación');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return to_route('usuarios.index')->with('success', 'El usuario se ha eliminado correctamente');
    }
}
