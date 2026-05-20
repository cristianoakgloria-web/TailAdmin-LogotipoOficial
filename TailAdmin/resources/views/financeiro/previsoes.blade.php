@extends('layouts.app')

@section('title', 'Previsões Financeiras')
@section('header', 'Financeiro')

@section('content')
<div class="space-y-6 animate-fadeUp">
    <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-6">
        <h2 class="text-xl font-bold text-white mb-4">Previsão de Entradas (Faturas Pendentes)</h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#0a0a0c] border-b border-[#eab308]/20">
                    <tr><th class="p-3 text-left">Data de Vencimento</th><th class="p-3 text-left">Valor Total (Kz)</th></tr>
                </thead>
                <tbody>
                    @forelse($previsaoEntradas ?? [] as $p)
                    <tr class="border-b border-[#eab308]/10">
                        <td class="p-3">{{ \Carbon\Carbon::parse($p->data_vencimento)->format('d/m/Y') }}</td>
                        <td class="p-3">Kz {{ number_format($p->total, 2) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="2" class="p-3 text-center text-gray-500">Nenhuma fatura pendente.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-6">
        <h2 class="text-xl font-bold text-white mb-4">Projecção de Saídas (Média últimos 3 meses)</h2>
        <p class="text-3xl font-bold text-red-400">Kz {{ number_format($mediaSaidasMensal ?? 0, 2) }}</p>
        <p class="text-sm text-zinc-500 mt-2">*Estimativa baseada em despesas passadas. Utilize o Diário de Caixa para controlo real.</p>
    </div>
</div>
@endsection