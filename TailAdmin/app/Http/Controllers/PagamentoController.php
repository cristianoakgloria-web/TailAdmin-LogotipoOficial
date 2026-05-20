<?php

namespace App\Http\Controllers;

use App\Models\Pagamento;
use App\Models\Fatura;
use App\Models\Transacao;        // <-- teu modelo
use App\Models\ArquivoCaixa;     // <-- teu modelo
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagamentoController extends Controller
{
    public function index()
    {
        $pagamentos = Pagamento::with('fatura.cliente')->orderBy('data_pagamento', 'desc')->paginate(15);
        return view('financeiro.pagamentos.index', compact('pagamentos'));
    }

    public function create(Request $request)
    {
        $fatura = null;
        if ($request->has('fatura_id')) {
            $fatura = Fatura::with('cliente')->findOrFail($request->fatura_id);
        }
        $faturas = Fatura::where('status', '!=', 'paga')->orderBy('data_vencimento')->get();
        return view('financeiro.pagamentos.create', compact('faturas', 'fatura'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fatura_id' => 'required|exists:faturas,id',
            'valor' => 'required|numeric|min:0.01',
            'data_pagamento' => 'required|date',
            'metodo' => 'required|in:dinheiro,transferencia,deposito,cheque,outro',
            'referencia' => 'nullable|string|max:100',
            'observacoes' => 'nullable|string'
        ]);

        $fatura = Fatura::find($validated['fatura_id']);

        // Verificar se o pagamento não ultrapassa o saldo
        $saldoAtual = $fatura->saldo;
        if ($validated['valor'] > $saldoAtual) {
            return redirect()->back()->withErrors(['valor' => 'O valor do pagamento não pode ser superior ao saldo em aberto.'])->withInput();
        }

        $validated['user_id'] = Auth::id();
        $pagamento = Pagamento::create($validated);

        // Actualizar status da fatura
        $novoSaldo = $fatura->saldo - $validated['valor'];
        if ($novoSaldo <= 0) {
            $fatura->status = 'paga';
        } elseif ($fatura->status == 'pendente') {
            $fatura->status = 'parcial';
        }
        $fatura->save();

        // ==========================================================
        // INTEGRAÇÃO COM O DIÁRIO DE CAIXA EXISTENTE
        // ==========================================================
        // Procura o diário de caixa do mês/ano corrente (ou cria um)
        $mesAtual = strtoupper(now()->format('F')); // "MAIO", "JUNHO", etc.
        $anoAtual = now()->year;

        $arquivoCaixa = ArquivoCaixa::where('user_id', Auth::id())
            ->where('mes', $mesAtual)
            ->where('ano', $anoAtual)
            ->first();

        // Se não existir diário para o mês, podes optar por criar automaticamente
        if (!$arquivoCaixa) {
            // Cria um diário padrão para o mês (ajuste conforme necessidade)
            $arquivoCaixa = ArquivoCaixa::create([
                'user_id' => Auth::id(),
                'nome' => "Diário {$mesAtual} {$anoAtual}",
                'mes' => $mesAtual,
                'ano' => $anoAtual,
                'moeda' => 'AKZ',
                'saldo_anterior' => 0,
                'despesa_anterior' => 0,
                'status' => 'rascunho'
            ]);
        }

        // Criar uma transação de entrada no diário de caixa
        Transacao::create([
            'arquivo_caixa_id' => $arquivoCaixa->id,
            'data_vencimento' => $validated['data_pagamento'],
            'tipo' => 'entrada',
            'valor' => $validated['valor'],
            'descricao' => "Pagamento da fatura {$fatura->numero_fatura} - {$fatura->cliente->nome}",
            'categoria' => 'Recebimento de fatura',
            'observacao' => "Referência: {$validated['referencia']} | Método: {$validated['metodo']}"
        ]);

        return redirect()->route('pagamentos.index')
            ->with('success', 'Pagamento registado e adicionado ao Diário de Caixa.');
    }

    public function confirmar($id)
    {
        $pagamento = Pagamento::with('fatura.cliente')->findOrFail($id);
        return view('financeiro.pagamentos.confirmar', compact('pagamento'));
    }

    public function destroy($id)
    {
        $pagamento = Pagamento::findOrFail($id);
        $fatura = $pagamento->fatura;

        // Remover a transação associada no diário de caixa
        // (vamos procurar pela descrição e valor aproximado)
        Transacao::where('descricao', 'like', "%Pagamento da fatura {$fatura->numero_fatura}%")
            ->where('valor', $pagamento->valor)
            ->where('data_vencimento', $pagamento->data_pagamento)
            ->delete();

        $pagamento->delete();

        // Recalcular status da fatura
        $fatura->status = ($fatura->saldo <= 0) ? 'paga' : (($fatura->pagamentos->count() > 0) ? 'parcial' : 'pendente');
        $fatura->save();

        return redirect()->route('pagamentos.index')
            ->with('success', 'Pagamento removido e transação do diário cancelada.');
    }
}