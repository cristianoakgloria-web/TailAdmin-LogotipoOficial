<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendasController extends Controller
{
    /**
     * Lista de campanhas/serviços
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'todos');
        $query = Servico::with('cliente', 'responsavel');
        
        if ($status !== 'todos') {
            $query->where('status', $status);
        }
        
        $servicos = $query->latest()->paginate(15);
        
        return view('vendas.index', compact('servicos', 'status'));
    }

    /**
     * Formulário para nova campanha/serviço
     */
    public function create()
    {
        $clientes = Cliente::orderBy('nome')->get();
        return view('vendas.create', compact('clientes'));
    }

    /**
     * Armazenar nova campanha
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id'    => 'required|exists:clientes,id',
            'titulo'        => 'required|string|max:255',
            'descricao'     => 'nullable|string',
            'valor'         => 'nullable|numeric|min:0',
            'status'        => 'in:proposta,negociacao,contratado,em_andamento,concluido,cancelado',
            'data_prevista' => 'nullable|date',
            'observacoes'   => 'nullable|string'
        ]);
        
        $validated['responsavel_id'] = Auth::id();
        
        Servico::create($validated);
        
        return redirect()->route('vendas.index')
            ->with('success', 'Campanha/Serviço criado com sucesso.');
    }

    /**
     * Detalhes da campanha
     */
    public function show($id)
    {
        $servico = Servico::with('cliente', 'responsavel')->findOrFail($id);
        return view('vendas.show', compact('servico'));
    }

    /**
     * Formulário de edição
     */
    public function edit($id)
    {
        $servico = Servico::findOrFail($id);
        $clientes = Cliente::orderBy('nome')->get();
        return view('vendas.edit', compact('servico', 'clientes'));
    }

    /**
     * Atualizar campanha
     */
    public function update(Request $request, $id)
    {
        $servico = Servico::findOrFail($id);
        
        $validated = $request->validate([
            'cliente_id'    => 'required|exists:clientes,id',
            'titulo'        => 'required|string|max:255',
            'descricao'     => 'nullable|string',
            'valor'         => 'nullable|numeric|min:0',
            'status'        => 'in:proposta,negociacao,contratado,em_andamento,concluido,cancelado',
            'data_prevista' => 'nullable|date',
            'data_inicio'   => 'nullable|date',
            'data_fim'      => 'nullable|date',
            'observacoes'   => 'nullable|string'
        ]);
        
        $servico->update($validated);
        
        return redirect()->route('vendas.show', $servico->id)
            ->with('success', 'Campanha atualizada com sucesso.');
    }

    /**
     * Excluir campanha
     */
    public function destroy($id)
    {
        $servico = Servico::findOrFail($id);
        $servico->delete();
        
        return redirect()->route('vendas.index')
            ->with('success', 'Campanha removida.');
    }

    /**
     * Pipeline (Kanban)
     */
    public function pipeline()
    {
        $statusLabels = [
            'proposta'      => 'Propostas',
            'negociacao'    => 'Negociações',
            'contratado'    => 'Contratados',
            'em_andamento'  => 'Em Andamento',
            'concluido'     => 'Concluídos',
            'cancelado'     => 'Cancelados'
        ];
        
        $servicos = Servico::with('cliente')
            ->orderBy('data_prevista')
            ->get()
            ->groupBy('status');
        
        return view('vendas.pipeline', compact('servicos', 'statusLabels'));
    }

    /**
     * Atualizar status
     */
    public function updateStatus(Request $request, $id)
    {
        $servico = Servico::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:proposta,negociacao,contratado,em_andamento,concluido,cancelado'
        ]);
        
        // Se mudou para "contratado", preencher data_inicio
        if ($request->status == 'contratado' && is_null($servico->data_inicio)) {
            $servico->data_inicio = now();
        }
        
        // Se mudou para "concluido", preencher data_fim
        if ($request->status == 'concluido' && is_null($servico->data_fim)) {
            $servico->data_fim = now();
        }
        
        $servico->status = $request->status;
        $servico->save();
        
        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->route('vendas.pipeline')
            ->with('success', 'Status atualizado.');
    }

    /**
     * Gerar proposta
     */
    public function gerarProposta($id)
    {
        $servico = Servico::with('cliente')->findOrFail($id);
        return view('vendas.proposta', compact('servico'));
    }

    /**
     * Converter proposta em serviço contratado
     */
    public function converterPedido($id)
    {
        $servico = Servico::findOrFail($id);
        
        if (!in_array($servico->status, ['proposta', 'negociacao'])) {
            return redirect()->back()->with('error', 'Apenas propostas ou negociações podem ser convertidas.');
        }
        
        $servico->status = 'contratado';
        $servico->data_inicio = now();
        $servico->save();
        
        return redirect()->route('vendas.show', $servico->id)
            ->with('success', 'Proposta convertida em serviço contratado!');
    }
    
    // Base de Conhecimento
    public function clientes()
    {
        $clientes = Cliente::withCount('servicos')->paginate(10);
        return view('vendas.clientes', compact('clientes'));
    }
    
    public function clientePerfil($id)
    {
        $cliente = Cliente::with('servicos')->findOrFail($id);
        return view('vendas.cliente-perfil', compact('cliente'));
    }
}