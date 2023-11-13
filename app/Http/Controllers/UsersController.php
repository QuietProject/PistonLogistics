<?php

namespace App\Http\Controllers;

use App\Models\AlmacenCliente;
use App\Models\AlmacenPropio;
use App\Models\Camionero;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Termwind\Components\BreakLine;

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
        $clientes = Cliente::all();
        return view('usuarios.index', [
            'usuarios' => $usuarios,
            'camioneros' => $camioneros,
            'almacenesPropios' => $almacenesPropios,
            'almacenesClientes' => $almacenesClientes,
            'clientes' => $clientes,
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
            return to_route('login')->with('error',__('Ha ocurrdio un error'));
        }

        if (!hash_equals(sha1($user->getEmailForVerification()), (string) $hash)) {
            return to_route('login')->with('error',__('Ha ocurrdio un error'));
        }
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        if ($user->rol == 0) {
            return to_route('login')->with('success',__('Se ha verificado el email correctamente'));
        }
        //TODO
        return 'retornar a aplcacion';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        switch ($request->input('tipo')) {
            case 0:
                $validated = $request->validate([
                    'CI' => ['bail', 'required', 'digits:8', 'integer', 'unique:users,user'],
                    'email' => ['required', 'email', 'max:255', 'unique:users,email']
                ]);

                $user->rol = 0;
                $user->user = $validated['CI'];
                break;
            case 1:
                $validated = $request->validate([
                    'CI' => ['bail', 'required', 'digits:8', 'integer'],
                    'almacenPropio' => ['required', 'integer', 'exists:ALMACENES_PROPIOS,ID', Rule::exists('ALMACENES', 'ID')->where(function (Builder $query) {
                        return $query->where('baja', 0);
                    })],
                    'email' => ['required', 'email', 'max:255', 'unique:users,email']
                ]);
                $name = $validated['CI'] . '.' . $validated['almacenPropio'];
                $usuarios = User::where('user', $name)->count();
                if ($usuarios != 0) {
                    return redirect()->back()->withErrors(['CI' => __('El usuario ya existe')])->withInput();
                }
                $user->rol = 1;
                $user->user = $name;
                break;
            case 2:
                $validated = $request->validate([
                    'camionero' => ['bail', 'required', 'digits:8', 'integer', 'unique:users,user', Rule::exists('CAMIONEROS', 'CI')->where(function (Builder $query) {
                        return $query->where('baja', 0);
                    }),],
                    'email' => ['required', 'email', 'max:255', 'unique:users,email']
                ]);
                $user->rol = 2;
                $user->user = $validated['camionero'];
                break;
            case 3:
                $validated = $request->validate([
                    'almacenCliente' => ['required', 'integer', 'exists:ALMACENES_CLIENTES_DE_ALTA'],
                    'email' => ['required', 'email', 'max:255', 'unique:users,email']
                ]);
                $name = $validated['almacenCliente'] . '.' . AlmacenCliente::find($validated['almacenCliente'])->cliente->nombre;
                $usuarios = User::where('user', $name)->count();
                if ($usuarios != 0) {
                    return redirect()->back()->withErrors(['error' => __('El usuario ya existe')])->withInput();
                }
                $user->rol = 3;
                $user->user = $name;
                break;
            default:
                return redirect()->back()->with('error', __('Ha ocurrido un error'));
                break;
        }

        $user->email = $validated['email'];
        $user->save();

        $status = Password::sendResetLink(
            ['email' => $user->email]
        );
        if ($status === Password::RESET_LINK_SENT) {
            return to_route('usuarios.show', $user->user)->with('success', __('Se ha creado el usuario correctamente'));
        } else {
            $user->delete();
            return redirect()->back()->with('error', __('Ha ocurrido un error') . ': ' . $status)->withInput();
        }
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
     *
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function resendEmailNotification(User $user)
    {
        if ($user->hasVerifiedEmail()) {
            return back()->with('error', __('El usuario ya verificó su email'));
        }
        $user->sendEmailVerificationNotification();
        return back()->with('success', __('Se reenvió el correo de verificación'));
    }

    /**
     *
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function resendPasswordNotification(User $user)
    {
        $status = Password::sendResetLink(
            ['email' => $user->email]
        );
        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', __($status))
            : back()->withErrors('error', __('Ha ocurrido un error') . ': ' . __($status));
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
        $email = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:users,email']
        ]);
        $email['email_verified_at'] = null;
        $user->update($email);
        $user->sendEmailVerificationNotification();
        return redirect()->back()->with('success', __('El usuario se actualizo correctamente'));
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
        return to_route('usuarios.index')->with('success', __('El usuario se ha eliminado correctamente'));
    }

    /**
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->input('email'))->first();

        if (empty($user)) {
            return redirect()->back()->withErrors(['email' => __('No hemos podido encontrar el email')])->withInput();
        }
        if (!$user->hasVerifiedEmail()) {
            return redirect()->back()->withErrors(['email' => __('El email no esta verificado, comuniquese con un administrador')])->withInput();
        }


        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }


    /**
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {

                if (!$user->hasVerifiedEmail()) {
                    $user->markEmailAsVerified();
                }

                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if($status !== Password::PASSWORD_RESET){
            return back()->withErrors(['email' => [__($status)]]);
        }

        $rol = User::where('email', $request->only('email')['email'])->first()->rol;

        if ($rol == 0) {
            return redirect()->route('login')->with('success', __($status));
        }
        //TODO
        return 'retornar a aplcacion';
    }
}
