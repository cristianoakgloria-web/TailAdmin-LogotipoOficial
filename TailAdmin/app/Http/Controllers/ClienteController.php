<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClienteController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::paginate(10); 
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome'     => 'required|string|min:3|max:255',
            'email'    => 'required|email|unique:clientes,email',
            'cpf_cnpj' => 'required|string|unique:clientes,cpf_cnpj',
            'telefone' => 'required|string|max:20',
        ]);

        Cliente::create($request->all());
        return redirect()->route('clientes.index')
            ->with('success', 'Cliente criado com sucesso.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nome'     => 'required|string|min:3|max:255',
            'email'    => 'required|email|unique:clientes,email,' . $cliente->id,
            'cpf_cnpj' => 'required|string|unique:clientes,cpf_cnpj,' . $cliente->id,
            'telefone' => 'required|string|max:20',
        ]);

        $cliente->update($request->all());

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')
            ->with('success', 'Cliente excluído com sucesso!');
    }
}
