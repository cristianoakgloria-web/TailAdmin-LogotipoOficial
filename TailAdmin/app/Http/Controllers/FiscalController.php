<?php

namespace App\Http\Controllers;

use App\Models\Fatura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FiscalController extends Controller
{
    public function index()
    {
        // Totais por mês (últimos 12 meses) – usando faturas pagas
        $faturasPorMes = Fatura::where('status', 'paga')
            ->where('data_emissao', '>=', now()->subMonths(12))
            ->selectRaw('DATE_FORMAT(data_emissao, "%Y-%m") as mes, SUM(valor_total) as total, COUNT(*) as quantidade')
            ->groupBy('mes')
            ->orderBy('mes', 'desc')
            ->get();

        // Total de documentos (temporariamente 0)
        $totalDocumentos = 0;

        // Próximas obrigações fiscais
        $proximasObrigacoes = [
            ['titulo' => 'Declaração Mensal de IVA', 'data_limite' => now()->endOfMonth()->setDay(15)->format('d/m/Y')],
            ['titulo' => 'Entrega da Declaração Anual de Rendimentos', 'data_limite' => '31/05/' . date('Y')],
        ];

        return view('fiscal.index', compact('faturasPorMes', 'totalDocumentos', 'proximasObrigacoes'));
    }

    public function relatorios()
    {
        $anos = Fatura::selectRaw('YEAR(data_emissao) as ano')->distinct()->orderBy('ano', 'desc')->pluck('ano');
        return view('fiscal.relatorios', compact('anos'));
    }

    public function exportar(Request $request)
    {
        $request->validate([
            'ano' => 'required|integer',
            'mes' => 'nullable|integer|between:1,12',
        ]);

        $ano = $request->ano;
        $mes = $request->mes;

        $query = Fatura::with('cliente')
            ->where('status', 'paga')
            ->whereYear('data_emissao', $ano);

        if ($mes) {
            $query->whereMonth('data_emissao', $mes);
        }

        $faturas = $query->orderBy('data_emissao')->get();

        if ($faturas->isEmpty()) {
            return redirect()->back()->with('error', 'Nenhuma fatura encontrada para o período selecionado.');
        }

        $fileName = "relatorio_fiscal_{$ano}" . ($mes ? "_{$mes}" : '') . ".csv";
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ];

        $callback = function () use ($faturas) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Nº Fatura', 'Data Emissão', 'Cliente', 'NIF', 'Valor (Kz)', 'Status']);
            foreach ($faturas as $fat) {
                fputcsv($file, [
                    $fat->numero_fatura,
                    $fat->data_emissao->format('d/m/Y'),
                    $fat->cliente->nome,
                    $fat->cliente->nif,
                    number_format($fat->valor_total, 2, ',', '.'),
                    $fat->status
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function arquivoIndex()
    {
        // Enquanto a tabela documentos_fiscais não existir, retorna vazio
        $documentos = collect(); // coleção vazia
        return view('fiscal.arquivo-digital', compact('documentos'));
    }

    public function upload(Request $request)
    {
        // Desativado temporariamente
        return redirect()->route('fiscal.arquivoIndex')
            ->with('error', 'Funcionalidade de upload temporariamente indisponível. Configure a tabela documentos_fiscais.');
    }

    public function download($id)
    {
        return redirect()->route('fiscal.arquivoIndex')
            ->with('error', 'Documento não encontrado.');
    }

    public function destroyDocumento($id)
    {
        return redirect()->route('fiscal.arquivoIndex')
            ->with('error', 'Funcionalidade temporariamente indisponível.');
    }
}