<?php

namespace App\Http\Controllers;

use App\Models\Fatura;
use App\Models\Pagamento;
use App\Models\Transacao;   // <- tua model (tabela 'transacaos')
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceiroController extends Controller
{
    public function index()
    {
        // Totais a partir das faturas e pagamentos
        $totalReceber = Fatura::where('status', 'pendente')->sum('valor_total');
        $totalRecebido = Pagamento::sum('valor');

        // Movimentos do teu diário de caixa (tabela 'transacaos')
        $movimentos = Transacao::where('data_vencimento', '>=', now()->subDays(30))
            ->orderBy('data_vencimento', 'desc')
            ->get();

        $entradasUltimos30 = $movimentos->where('tipo', 'entrada')->sum('valor');
        $saidasUltimos30 = $movimentos->where('tipo', 'saida')->sum('valor');
        $saldoAtual = $entradasUltimos30 - $saidasUltimos30;

        // Faturas a vencer nos próximos 7 dias
        $vencendoProximos7Dias = Fatura::where('status', 'pendente')
            ->where('data_vencimento', '>=', now())
            ->where('data_vencimento', '<=', now()->addDays(7))
            ->count();

        // Últimos 10 movimentos do diário
        $ultimosMovimentos = Transacao::orderBy('data_vencimento', 'desc')->limit(10)->get();

        return view('financeiro.dashboard', compact(
            'totalReceber',
            'totalRecebido',
            'entradasUltimos30',
            'saidasUltimos30',
            'saldoAtual',
            'vencendoProximos7Dias',
            'ultimosMovimentos'
        ));
    }

    public function previsoes()
    {
        // Entradas previstas (faturas pendentes)
        $previsaoEntradas = Fatura::where('status', 'pendente')
            ->select('data_vencimento', DB::raw('SUM(valor_total) as total'))
            ->groupBy('data_vencimento')
            ->orderBy('data_vencimento')
            ->get();

        // Média de saídas dos últimos 3 meses (usando a tua tabela 'transacaos')
        $mediaSaidasMensal = Transacao::where('tipo', 'saida')
            ->where('data_vencimento', '>=', now()->subMonths(3))
            ->select(DB::raw('SUM(valor) / 3 as media'))
            ->value('media') ?? 0;

        return view('financeiro.previsoes', compact('previsaoEntradas', 'mediaSaidasMensal'));
    }

    public function alertas()
    {
        // Faturas vencidas
        $faturasVencidas = Fatura::where('status', 'pendente')
            ->where('data_vencimento', '<', now())
            ->with('cliente')
            ->get();

        // Faturas a vencer nos próximos 7 dias
        $faturasAVencer = Fatura::where('status', 'pendente')
            ->where('data_vencimento', '>=', now())
            ->where('data_vencimento', '<=', now()->addDays(7))
            ->with('cliente')
            ->get();

        return view('financeiro.tesouraria.alertas', compact('faturasVencidas', 'faturasAVencer'));
    }

    /**
     * Redireciona para o Diário de Caixa (onde já tens o modal de movimentos manuais)
     */
    public function movimentar(Request $request)
    {
        return redirect()->route('diario-caixa.index')
            ->with('info', 'Utilize o módulo "Diário de Caixa" para registar movimentos manuais.');
    }

    public function conciliacao()
    {
        $faturas = Fatura::with('cliente', 'pagamentos')
            ->orderBy('data_emissao', 'desc')
            ->paginate(15);

        return view('financeiro.conciliacao', compact('faturas'));
    }

    public function confirmarConciliacao(Request $request)
    {
        $fatura = Fatura::findOrFail($request->fatura_id);

        if ($fatura->status === 'paga') {
            return redirect()->back()->with('info', 'Fatura já estava paga.');
        }

        if ($fatura->saldo <= 0) {
            $fatura->status = 'paga';
            $fatura->save();
            return redirect()->back()->with('success', 'Fatura conciliada com sucesso.');
        }

        return redirect()->back()->with('error', 'A fatura ainda tem saldo pendente.');
    }
}