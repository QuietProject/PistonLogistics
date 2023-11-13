<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaveClienteRequest;
use App\Models\Cliente;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::all();
        return   view('clientes.index', ['clientes' => $clientes, 'cliente' => new Cliente()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveClienteRequest $request)
    {
        Cliente::create($request->validated());
        return to_route('clientes.show', $request->input('RUT'))->with('success', 'El cliente se creo correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)
    {
        //dd($cliente->almacenes_cliente);
        return view('clientes.show', ['cliente' => $cliente]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */

     /*public function update(SaveClienteRequest $request, Cliente $cliente)
    {
        $cliente->update($request->validated());
        return to_route('clientes.show', $cliente)->with('success', 'El cliente se actualizo correctamente');
    }*/

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->update(['baja' => !$cliente->baja]);
        return redirect()->back()->with('success', __('El cliente se actualizo correctamente'));
    }
}
