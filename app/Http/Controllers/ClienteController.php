<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller  // Confirme que extends Controller
{
    public function index()
    {
        // Adicione withCount para contar os serviços (campanhas) de cada cliente
        $clientes = Cliente::withCount('servicos')->paginate(10);
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function show(Cliente $cliente)
    {
        // Carregue os serviços (campanhas) do cliente para exibir no show
        $cliente->load('servicos');
        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nome'     => 'required|string|min:3|max:255',
            'bi'       => 'nullable|string|unique:clientes,bi',
            'nif'      => 'required|string|unique:clientes,nif',
            'email'    => 'nullable|email|unique:clientes,email',
            'telefone' => 'nullable|string|max:20',
        ]);

        Cliente::create($validated);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente criado com sucesso.');
    }

    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'nome'     => 'required|string|min:3|max:255',
            'bi'       => 'nullable|string|unique:clientes,bi,' . $cliente->id,
            'nif'      => 'required|string|unique:clientes,nif,' . $cliente->id,
            'email'    => 'nullable|email|unique:clientes,email,' . $cliente->id,
            'telefone' => 'nullable|string|max:20',
        ]);

        $cliente->update($validated);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente actualizado com sucesso!');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')
            ->with('success', 'Cliente excluído com sucesso!');
    }
}