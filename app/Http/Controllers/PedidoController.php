<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cliente;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        // Usamos 'with' para carregar os dados do cliente e evitar lentidão (Eager Loading)
        $pedidos = Pedido::with('cliente')->paginate(10);
        return view('pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        // Precisamos da lista de clientes para preencher o <select> no formulário
        $clientes = Cliente::all();
        return view('pedidos.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'valor_total' => 'required|numeric|min:0',
            'status' => 'required|in:pendente,pago,cancelado',
        ]);

        Pedido::create($request->all());

        return redirect()->route('pedidos.index')
            ->with('success', 'Pedido registrado com sucesso!');
    }

    public function show(Pedido $pedido)
    {
        return view('pedidos.show', compact('pedido'));
    }

    // Como você mencionou que não planeia usar o Edit por agora, 
    // deixaremos os métodos abaixo prontos mas focados no básico.

    public function edit(Pedido $pedido)
    {
        $clientes = Cliente::all();
        return view('pedidos.edit', compact('pedido', 'clientes'));
    }

    public function update(Request $request, Pedido $pedido)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'valor_total' => 'required|numeric',
            'status' => 'required',
        ]);

        $pedido->update($request->all());
        return redirect()->route('pedidos.index')->with('success', 'Pedido atualizado!');
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->delete();
        return redirect()->route('pedidos.index')->with('success', 'Pedido excluído.');
    }
}