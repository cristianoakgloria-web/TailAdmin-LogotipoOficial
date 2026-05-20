@extends('layouts.app')

@section('title', 'Alertas de Tesouraria')
@section('header', 'Financeiro')

@section('content')
<div class="space-y-6 animate-fadeUp">
    <!-- Faturas Vencidas -->
    <div class="bg-[#0c0c0e] border border-red-500/30 rounded-xl overflow-hidden">
        <div class="bg-red-500/10 px-6 py-4 border-b border-red-500/20">
            <h2 class="text-lg font-bold text-red-400 flex items-center gap-2">
                <span>⚠️</span> Faturas Vencidas
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#0a0a0c] border-b border-[#eab308]/20">
                    <tr><th class="p-3 text-left">Fatura</th><th>Cliente</th><th>Vencimento</th><th>Valor (Kz)</th><th>Ações</th></tr>
                </thead>
                <tbody>
                    @forelse($faturasVencidas ?? [] as $fat)
                    <tr class="border-b border-[#eab308]/10">
                        <td class="p-3">{{ $fat->numero_fatura }}</td>
                        <td class="p-3">{{ $fat->cliente->nome }}</td>
                        <td class="p-3 text-red-400">{{ $fat->data_vencimento->format('d/m/Y') }}</td>
                        <td class="p-3">Kz {{ number_format($fat->valor_total, 2) }}</td>
                        <td class="p-3"><a href="{{ route('faturas.show', $fat) }}" class="text-blue-400">Ver</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="p-6 text-center text-gray-500">Nenhuma fatura vencida.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Faturas a Vencer (próximos 7 dias) -->
    <div class="bg-[#0c0c0e] border border-yellow-500/30 rounded-xl overflow-hidden">
        <div class="bg-yellow-500/10 px-6 py-4 border-b border-yellow-500/20">
            <h2 class="text-lg font-bold text-yellow-400 flex items-center gap-2">
                <span>📅</span> Faturas a Vencer (próximos 7 dias)
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#0a0a0c] border-b border-[#eab308]/20">
                    <tr><th class="p-3 text-left">Fatura</th><th>Cliente</th><th>Vencimento</th><th>Valor (Kz)</th><th>Ações</th></tr>
                </thead>
                <tbody>
                    @forelse($faturasAVencer ?? [] as $fat)
                    <tr class="border-b border-[#eab308]/10">
                        <td class="p-3">{{ $fat->numero_fatura }}</td>
                        <td class="p-3">{{ $fat->cliente->nome }}</td>
                        <td class="p-3">{{ $fat->data_vencimento->format('d/m/Y') }}</td>
                        <td class="p-3">Kz {{ number_format($fat->valor_total, 2) }}</td>
                        <td class="p-3"><a href="{{ route('faturas.show', $fat) }}" class="text-blue-400">Ver</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="p-6 text-center text-gray-500">Nenhuma fatura a vencer nos próximos 7 dias.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection