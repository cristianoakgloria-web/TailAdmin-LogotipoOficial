@extends('layouts.app')

@section('title', 'Dashboard Financeiro')
@section('header', 'Financeiro')
@section('subheader', 'Visão geral do fluxo de caixa')

@section('content')
<div class="space-y-6 animate-fadeUp">
    @if(session('success'))
        <div class="p-4 rounded-xl bg-[#eab308]/10 border border-[#eab308]/40 text-[#eab308] text-sm">{{ session('success') }}</div>
    @endif

    <!-- Cards resumo (usando dados do controller) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-5">
            <p class="text-zinc-500 text-sm">Total a Receber</p>
            <p class="text-2xl font-bold text-white">Kz {{ number_format($totalReceber ?? 0, 2) }}</p>
        </div>
        <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-5">
            <p class="text-zinc-500 text-sm">Total Recebido</p>
            <p class="text-2xl font-bold text-white">Kz {{ number_format($totalRecebido ?? 0, 2) }}</p>
        </div>
        <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-5">
            <p class="text-zinc-500 text-sm">Entradas (últimos 30d)</p>
            <p class="text-2xl font-bold text-green-400">Kz {{ number_format($entradasUltimos30 ?? 0, 2) }}</p>
        </div>
        <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-5">
            <p class="text-zinc-500 text-sm">Saídas (últimos 30d)</p>
            <p class="text-2xl font-bold text-red-400">Kz {{ number_format($saidasUltimos30 ?? 0, 2) }}</p>
        </div>
    </div>

    <!-- Saldo e alertas -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-5">
            <p class="text-zinc-500 text-sm">Saldo actual (últimos 30d)</p>
            <p class="text-3xl font-bold {{ ($saldoAtual ?? 0) >= 0 ? 'text-green-400' : 'text-red-400' }}">Kz {{ number_format($saldoAtual ?? 0, 2) }}</p>
        </div>

    </div>

    <!-- Últimos movimentos do diário de caixa -->
    <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-5">
        <h3 class="text-lg font-bold text-white mb-3">Últimos movimentos (diário de caixa)</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-[#0a0a0c] border-b border-[#eab308]/20">
                    <tr>
                        <th class="py-2 px-3 text-left">Data</th>
                        <th class="py-2 px-3 text-left">Descrição</th>
                        <th class="py-2 px-3 text-left">Categoria</th>
                        <th class="py-2 px-3 text-right">Valor (Kz)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ultimosMovimentos ?? [] as $mov)
                    <tr class="border-b border-[#eab308]/10">
                        <td class="py-2 px-3">{{ \Carbon\Carbon::parse($mov->data_vencimento)->format('d/m/Y') }}</td>
                        <td class="py-2 px-3">{{ $mov->descricao }}</td>
                        <td class="py-2 px-3">{{ $mov->categoria ?? 'Geral' }}</td>
                        <td class="py-2 px-3 text-right {{ $mov->tipo == 'entrada' ? 'text-green-400' : 'text-red-400' }}">
                            {{ $mov->tipo == 'entrada' ? '+' : '-' }} Kz {{ number_format($mov->valor, 2) }}
                        </td>
                     </tr>
                    @empty
                    <tr><td colspan="4" class="py-4 text-center text-gray-500">Nenhum movimento registado nos últimos 30 dias.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3 text-right">
            <a href="{{ route('diario-caixa.index') }}" class="text-sm text-[#eab308] hover:underline">Ir para Diário de Caixa →</a>
        </div>
    </div>

    <!-- Botão para registar movimento manual (usa o modal do diário) -->
    <div class="flex justify-end">
        <button onclick="abrirModalTransacao()" class="px-4 py-2 bg-[#eab308] text-black rounded-lg">+ Novo Movimento Manual</button>
    </div>
</div>

<script>
function abrirModalTransacao() {
    // Se existir a função global do diário de caixa, chama-a
    if (typeof window.abrirModalTransacao === 'function') {
        window.abrirModalTransacao();
    } else {
        alert('Use o menu "Diário de Caixa" para adicionar movimentos.');
    }
}
</script>
@endsection