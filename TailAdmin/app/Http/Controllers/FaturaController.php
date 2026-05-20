<?php

namespace App\Http\Controllers;

use App\Models\Fatura;
use App\Models\Cliente;
use App\Models\Servico;
use Illuminate\Http\Request;

class FaturaController extends Controller
{
    public function index()
    {
        $faturas = Fatura::with('cliente')->orderBy('data_emissao', 'desc')->paginate(15);
        return view('financeiro.faturas.index', compact('faturas'));
    }

    public function create()
    {
        $clientes = Cliente::orderBy('nome')->get();
        $servicos = Servico::whereIn('status', ['contratado', 'concluido'])->get();
        return view('financeiro.faturas.create', compact('clientes', 'servicos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'servico_id' => 'nullable|exists:servicos,id',
            'data_emissao' => 'required|date',
            'data_vencimento' => 'required|date|after_or_equal:data_emissao',
            'valor_total' => 'required|numeric|min:0',
            'tipo' => 'required|in:servico,consultoria,campanha,outro',
            'descricao' => 'nullable|string'
        ]);

        // Gerar número único da fatura (ex: FT-2025-0001)
        $ano = date('Y');
        $ultimaFatura = Fatura::whereYear('created_at', $ano)->count();
        $numero = 'FT-' . $ano . str_pad($ultimaFatura + 1, 4, '0', STR_PAD_LEFT);
        $validated['numero_fatura'] = $numero;
        $validated['status'] = 'pendente';

        Fatura::create($validated);

        return redirect()->route('faturas.index')
            ->with('success', "Fatura {$numero} criada com sucesso.");
    }

    public function show($id)
    {
        $fatura = Fatura::with('cliente', 'pagamentos', 'servico')->findOrFail($id);
        return view('financeiro.faturas.show', compact('fatura'));
    }

    public function edit($id)
    {
        $fatura = Fatura::findOrFail($id);
        $clientes = Cliente::orderBy('nome')->get();
        $servicos = Servico::all();
        return view('financeiro.faturas.edit', compact('fatura', 'clientes', 'servicos'));
    }

    public function update(Request $request, $id)
    {
        $fatura = Fatura::findOrFail($id);

        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'servico_id' => 'nullable|exists:servicos,id',
            'data_emissao' => 'required|date',
            'data_vencimento' => 'required|date|after_or_equal:data_emissao',
            'valor_total' => 'required|numeric|min:0',
            'tipo' => 'required|in:servico,consultoria,campanha,outro',
            'descricao' => 'nullable|string',
            'status' => 'in:pendente,parcial,paga,cancelada'
        ]);

        $fatura->update($validated);

        return redirect()->route('faturas.show', $fatura->id)
            ->with('success', 'Fatura actualizada.');
    }

    public function destroy($id)
    {
        $fatura = Fatura::findOrFail($id);
        if ($fatura->pagamentos()->count() > 0) {
            return redirect()->back()->with('error', 'Não é possível excluir uma fatura com pagamentos associados.');
        }
        $fatura->delete();
        return redirect()->route('faturas.index')->with('success', 'Fatura excluída.');
    }
}