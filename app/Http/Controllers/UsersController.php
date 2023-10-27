<?php

namespace App\Http\Controllers;

use App\Models\AlmacenCliente;
use App\Models\AlmacenPropio;
use App\Models\Camionero;
use App\Models\User;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tipo = $request->input('tipo');
        switch ($tipo) {
                //ADMINISTRADOR
            case 0:
                $validated = $request->validate([
                    'CI' => ['bail', 'required', 'digits:8', 'integer', 'unique:users,user'],
                    'email' => ['required', 'email', 'max:64', 'unique:users,email']
                ]);
                break;
            case 1:
                $validated = $request->validate([
                    'CI' => ['bail', 'required', 'digits:8', 'integer'],
                    'almacenPropio' => ['required', 'integer','exists:ALMACENES_PROPIOS,ID', Rule::exists('ALMACENES', 'ID')->where(function (Builder $query) {
                        return $query->where('baja', 0);
                    })],
                    'email' => ['required', 'email', 'max:64', 'unique:users,email']
                ]);
                //validar que no exista nombre de usuario
                break;
            case 2:
                $validated = $request->validate([
                    'camionero' => ['bail', 'required', 'digits:8', 'integer', 'unique:users,user', Rule::exists('CAMIONEROS', 'CI')->where(function (Builder $query) {
                        return $query->where('baja', 0);
                    }),],
                    'email' => ['required', 'email', 'max:64', 'unique:users,email']
                ]);
                break;
            case 3:
                $validated = $request->validate([
                    'almacenCliente' => ['required', 'integer', 'exists:ALMACENES_CLIENTES,ID', Rule::exists('almacenes', 'ID')->where(function (Builder $query) {
                        return $query->where('baja', 0);
                    }),Rule::exists('ALMACENES_CLIENTES', 'ID')->where(function (Builder $query) {
                        return $query->join('CLIENTES','CLIENTES.RUT','=','ALMACENES_CLIENTES.RUT')->where('CLIENTES.baja', 0);
                    })],
                    'email' => ['required', 'email', 'max:64', 'unique:users,email']
                ]);
                break;
            default:
                return redirect()->back()->with('error', 'Ha ocurrido un error');
                break;
        }
        dd($validated);
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
    public function edit(User $user)
    {
        //
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
        //
    }
}
