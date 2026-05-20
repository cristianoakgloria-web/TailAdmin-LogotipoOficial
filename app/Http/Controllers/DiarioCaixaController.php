<?php

namespace App\Http\Controllers;

use App\Models\Transacao;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DiarioCaixaController extends Controller
{
    public function index(Request $request)
    {
        $arquivoId = $request->arquivo_id;
        $arquivoAtual = null;
        
        if ($arquivoId) {
            $arquivoAtual = \App\Models\ArquivoCaixa::where('user_id', auth()->id())->find($arquivoId);
        }
        
        $transacoesQuery = \App\Models\Transacao::query();
        
        if ($arquivoId) {
            $transacoesQuery->where('arquivo_caixa_id', $arquivoId);
        } else {
            $transacoesQuery->whereMonth('data_vencimento', date('m'))
                ->whereYear('data_vencimento', date('Y'))
                ->whereNull('arquivo_caixa_id');
        }
        
        $transacoes = $transacoesQuery->orderBy('data_vencimento', 'desc')->get();
        
        $totalEntradas = $transacoes->where('tipo', 'entrada')->sum('valor');
        $totalSaidas = $transacoes->where('tipo', 'saida')->sum('valor');
        $saldoAtual = $totalEntradas - $totalSaidas;
        
        $arquivos = \App\Models\ArquivoCaixa::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('diario-caixa.index', compact(
            'arquivoAtual',
            'transacoes',
            'totalEntradas',
            'totalSaidas',
            'saldoAtual',
            'arquivos'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'data_vencimento' => 'required|date',
            'tipo' => 'required|in:entrada,saida',
            'valor' => 'required|numeric|min:0.01',
            'descricao' => 'required|string|max:255',
            'categoria' => 'nullable|string|max:50',
            'observacao' => 'nullable|string',
            'arquivo_caixa_id' => 'nullable|exists:arquivo_caixas,id',
            'redirect_to_arquivo' => 'nullable',
        ]);

        Transacao::create($validated);

        // Redirecionar para o diário correto
        if ($request->arquivo_caixa_id && $request->redirect_to_arquivo) {
            return redirect()->route('diario-caixa.index', ['arquivo_id' => $request->arquivo_caixa_id])
                ->with('success', '✅ Transação adicionada com sucesso!');
        }

        return redirect()->route('diario-caixa.index')
            ->with('success', '✅ Transação adicionada com sucesso!');
    }

    public function destroy($id)
    {
        $transacao = Transacao::findOrFail($id);
        $transacao->delete();

        return response()->json([
            'success' => true,
            'message' => 'Transação excluída com sucesso!'
        ]);
    }

    public function preview(Request $request)
    {
        $request->validate([
            'ano' => 'required|integer|min:2000|max:2099',
            'mes' => 'required|string',
            'moeda' => 'required|string|max:3',
            'saldo_anterior' => 'nullable|numeric',
        ]);

        $ano = (int) $request->ano;
        $mes = strtoupper($request->mes);
        $moeda = strtoupper($request->moeda);
        $saldoMesAnterior = (float) ($request->saldo_anterior ?? 0);

        $meses = [
            'JANEIRO' => 1, 'FEVEREIRO' => 2, 'MARÇO' => 3, 'MARCO' => 3,
            'ABRIL' => 4, 'MAIO' => 5, 'JUNHO' => 6,
            'JULHO' => 7, 'AGOSTO' => 8, 'SETEMBRO' => 9,
            'OUTUBRO' => 10, 'NOVEMBRO' => 11, 'DEZEMBRO' => 12
        ];
        
        $mesNumero = $meses[$mes] ?? date('m');

        $transacoes = Transacao::whereYear('data_vencimento', $ano)
            ->whereMonth('data_vencimento', $mesNumero)
            ->orderBy('data_vencimento')
            ->get();

        $itens = [];
        $saldoAtual = $saldoMesAnterior;
        $totalEntradas = 0;
        $totalSaidas = 0;

        foreach ($transacoes as $index => $t) {
            $entrada = $t->tipo === 'entrada' ? (float) $t->valor : 0;
            $saida = $t->tipo === 'saida' ? (float) $t->valor : 0;
            $saldoAtual += $entrada - $saida;
            
            $totalEntradas += $entrada;
            $totalSaidas += $saida;

            $itens[] = [
                'numero' => $index + 1,
                'data' => Carbon::parse($t->data_vencimento)->format('d-m-Y'),
                'designacao' => $t->descricao,
                'entrada' => $entrada,
                'saida' => $saida,
                'saldo' => round($saldoAtual, 2),
            ];
        }

        return response()->json([
            'success' => true,
            'ano' => $ano,
            'mes' => $mes,
            'moeda' => $moeda,
            'saldoMesAnterior' => $saldoMesAnterior,
            'itens' => $itens,
            'totalEntradas' => round($totalEntradas, 2),
            'totalSaidas' => round($totalSaidas, 2),
            'saldoFinal' => round($saldoAtual, 2),
        ]);
    }

    /**
     * Exportar Diário de Caixa em Excel (via Python)
     */
    public function exportar(Request $request)
    {
        // Se for GET, redireciona para o formulário
        if ($request->isMethod('GET')) {
            return redirect()->route('diario-caixa.index')
                ->with('error', '⚠️ Preencha o formulário para exportar o relatório.');
        }

        // Validar dados do formulário
        $request->validate([
            'ano' => 'required|integer|min:2000|max:2099',
            'mes' => 'required|string',
            'moeda' => 'required|string|max:3',
            'saldo_anterior' => 'nullable|numeric',
            'despesa_anterior' => 'nullable|numeric',
            'sexo' => 'nullable|string|max:1',
            'nome' => 'nullable|string|max:255',
        ]);

        // Dados básicos
        $ano = $request->ano;
        $mes = strtoupper($request->mes);
        $moeda = strtoupper($request->moeda);

        // Dados do footer
        $user = auth()->user();
        $saldoAnterior = floatval($request->saldo_anterior ?? 0);
        $despesaAnterior = floatval($request->despesa_anterior ?? 0);
        $sexo = $request->sexo ?? $user->sexo ?? 'M';
        $nome = $request->nome ?? $user->nome ?? 'Administrador';

        // Mapear mês para número
        $meses = [
            'JANEIRO' => 1, 'FEVEREIRO' => 2, 'MARÇO' => 3, 'MARCO' => 3,
            'ABRIL' => 4, 'MAIO' => 5, 'JUNHO' => 6,
            'JULHO' => 7, 'AGOSTO' => 8, 'SETEMBRO' => 9,
            'OUTUBRO' => 10, 'NOVEMBRO' => 11, 'DEZEMBRO' => 12
        ];
        $mesNumero = $meses[$mes] ?? date('m');

        // Buscar transações do banco de dados
        $transacoes = Transacao::whereYear('data_vencimento', $ano)
            ->whereMonth('data_vencimento', $mesNumero)
            ->orderBy('data_vencimento')
            ->get()
            ->map(function ($t) {
                return [
                    'data' => Carbon::parse($t->data_vencimento)->format('d-m-Y'),
                    'designacao' => $t->descricao,
                    'entrada' => $t->tipo === 'entrada' ? (float) $t->valor : 0,
                    'saida' => $t->tipo === 'saida' ? (float) $t->valor : 0,
                ];
            })
            ->toArray();

        // Preparar dados para o script Python
        $dados = json_encode([
            'ano' => $ano,
            'mes' => $mes,
            'moeda' => $moeda,
            'saldo_anterior' => $saldoAnterior,
            'despesa_anterior' => $despesaAnterior,
            'sexo' => $sexo,
            'nome' => $nome,
            'transacoes' => $transacoes,
        ], JSON_UNESCAPED_UNICODE);

        // Caminhos
        $scriptDir = base_path('app/python');
        $scriptPath = $scriptDir . '/diario_caixa.py';
        $excelFile = $scriptDir . '/Custo_Entrada&Saida.xlsx';

        // Verificar se o script existe
        if (!file_exists($scriptPath)) {
            \Log::error('Script Python não encontrado: ' . $scriptPath);
            return back()->with('error', '❌ Script Python não encontrado. Contacte o administrador.');
        }

        // Verificar se o Python está instalado
        $pythonCheck = shell_exec('which python3 2>&1');
        if (empty($pythonCheck)) {
            \Log::error('Python3 não encontrado no servidor');
            return back()->with('error', '❌ Python não está instalado no servidor.');
        }

        // Remover arquivo anterior se existir
        if (file_exists($excelFile)) {
            unlink($excelFile);
        }

        // Executar o script Python
        $comando = sprintf(
            'cd %s && python3 %s %s 2>&1',
            escapeshellarg($scriptDir),
            escapeshellarg($scriptPath),
            escapeshellarg($dados)
        );

        \Log::info('📊 Gerando Diário de Caixa...');
        \Log::info('Comando: ' . $comando);

        $output = shell_exec($comando);

        \Log::info('Output Python: ' . ($output ?? 'vazio'));

        // Verificar se o arquivo foi gerado
        if (file_exists($excelFile) && filesize($excelFile) > 0) {
            $filename = "Custo_Entrada&Saida_{$mes}_{$ano}.xlsx";

            \Log::info('✅ Excel gerado: ' . $filename);

            return response()->download($excelFile, $filename, [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ])->deleteFileAfterSend(true);
        }

        // Se falhou, log detalhado
        \Log::error('❌ Falha ao gerar Excel.');
        \Log::error('Script: ' . $scriptPath . ' | Existe: ' . (file_exists($scriptPath) ? 'Sim' : 'Não'));
        \Log::error('Output Python: ' . ($output ?? 'vazio'));
        \Log::error('Arquivo esperado: ' . $excelFile . ' | Existe: ' . (file_exists($excelFile) ? 'Sim' : 'Não'));

        return back()->with('error', '❌ Erro ao gerar o arquivo Excel. Verifique os logs para mais detalhes.');
    }
}