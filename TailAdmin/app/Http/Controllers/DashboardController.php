<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Servico;
use App\Models\Transacao;
use App\Models\Fatura;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ========== CARDS PRINCIPAIS ==========
        $totalClientes = Cliente::count();

        // Serviços contratados + concluídos = receita efectiva
        $totalVendas = Servico::whereIn('status', ['contratado', 'concluido'])->sum('valor');

        // Serviços em andamento (proposta, negociação, em_andamento)
        $servicosPendentes = Servico::whereIn('status', ['proposta', 'negociacao', 'em_andamento'])->count();

        // Faturas pendentes (se o módulo existir)
        $totalFaturasPendentesValor = 0;
        $totalFaturasPendentesQtd = 0;
        if (class_exists(Fatura::class)) {
            $totalFaturasPendentesValor = Fatura::where('status', 'pendente')->sum('valor_total');
            $totalFaturasPendentesQtd = Fatura::where('status', 'pendente')->count();
        }

        // Movimentação dos últimos 30 dias (via diário de caixa)
        $movimentos30d = Transacao::where('data_vencimento', '>=', now()->subDays(30))->get();
        $entradasUltimos30 = $movimentos30d->where('tipo', 'entrada')->sum('valor');
        $saidasUltimos30 = $movimentos30d->where('tipo', 'saida')->sum('valor');
        $saldo30d = $entradasUltimos30 - $saidasUltimos30;

        // Crescimento de clientes (comparação mês anterior)
        $clientesMesAnterior = Cliente::whereBetween('created_at', [
            now()->subMonths(2)->startOfMonth(),
            now()->subMonths(1)->endOfMonth()
        ])->count();
        $crescimentoClientes = $clientesMesAnterior > 0
            ? round((($totalClientes - $clientesMesAnterior) / $clientesMesAnterior) * 100)
            : 0;

        // Crescimento de vendas (comparação mês anterior)
        $vendasMesAnterior = Servico::whereIn('status', ['contratado', 'concluido'])
            ->whereBetween('created_at', [
                now()->subMonths(2)->startOfMonth(),
                now()->subMonths(1)->endOfMonth()
            ])
            ->sum('valor');
        $crescimentoVendas = $vendasMesAnterior > 0
            ? round((($totalVendas - $vendasMesAnterior) / $vendasMesAnterior) * 100)
            : 0;

        // ========== GRÁFICO DE VENDAS (últimos 12 meses) ==========
        $vendasMensais = [];
        for ($i = 11; $i >= 0; $i--) {
            $mes = now()->subMonths($i);
            $total = Servico::whereIn('status', ['contratado', 'concluido'])
                ->whereYear('created_at', $mes->year)
                ->whereMonth('created_at', $mes->month)
                ->sum('valor');
            $vendasMensais[] = [
                'mes' => $mes->format('M'),
                'ano' => $mes->year,
                'total' => $total
            ];
        }

        // ========== ATIVIDADES RECENTES ==========
        $atividades = collect();

        // Últimos 5 serviços
        Servico::with('cliente')->latest()->take(5)->get()->each(function ($servico) use (&$atividades) {
            $atividades->push([
                'tipo' => 'servico',
                'descricao' => "Novo serviço: {$servico->titulo}",
                'cliente' => $servico->cliente->nome,
                'valor' => $servico->valor,
                'data' => $servico->created_at,
                'icone' => '📄',
                'cor' => 'blue'
            ]);
        });

        // Últimos 5 clientes
        Cliente::latest()->take(5)->get()->each(function ($cliente) use (&$atividades) {
            $atividades->push([
                'tipo' => 'cliente',
                'descricao' => 'Novo cliente cadastrado',
                'cliente' => $cliente->nome,
                'valor' => null,
                'data' => $cliente->created_at,
                'icone' => '👤',
                'cor' => 'green'
            ]);
        });

        // Últimas 5 transações (diário de caixa)
        Transacao::latest()->take(5)->get()->each(function ($transacao) use (&$atividades) {
            $atividades->push([
                'tipo' => 'transacao',
                'descricao' => $transacao->descricao,
                'cliente' => null,
                'valor' => $transacao->valor,
                'data' => $transacao->created_at,
                'icone' => $transacao->tipo == 'entrada' ? '💰' : '💸',
                'cor' => $transacao->tipo == 'entrada' ? 'green' : 'red'
            ]);
        });

        // Ordenar e pegar as 5 mais recentes
        $atividadesRecentes = $atividades->sortByDesc('data')->take(5);

        // ========== ÚLTIMOS SERVIÇOS PARA TABELA ==========
        $ultimosServicos = Servico::with('cliente')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // ========== TICKET MÉDIO E SERVIÇOS CONCLUÍDOS ==========
        $servicosConcluidos = Servico::where('status', 'concluido')->count();
        $ticketMedio = $servicosConcluidos > 0 ? $totalVendas / $servicosConcluidos : 0;

        return view('dashboard.index', compact(
            'totalClientes',
            'totalVendas',
            'servicosPendentes',
            'totalFaturasPendentesValor',
            'totalFaturasPendentesQtd',
            'entradasUltimos30',
            'saidasUltimos30',
            'saldo30d',
            'crescimentoClientes',
            'crescimentoVendas',
            'vendasMensais',
            'atividadesRecentes',
            'ultimosServicos',
            'servicosConcluidos',
            'ticketMedio'
        ));
    }
}