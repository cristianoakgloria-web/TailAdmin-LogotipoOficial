@extends('layouts.app')

@section('title', 'Detalhes da Fatura')
@section('header', 'Financeiro')

@section('content')
<div class="max-w-4xl mx-auto animate-fadeUp">
    <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl overflow-hidden">
        <div class="flex items-center justify-between p-6 border-b border-[#eab308]/20">
            <div class="flex items-center gap-3">
                <a href="{{ route('faturas.index') }}" class="text-gray-400 hover:text-[#eab308] transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <h2 class="text-xl font-bold text-white">Fatura {{ $fatura->numero_fatura }}</h2>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('faturas.edit', $fatura) }}" class="px-4 py-2 bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 rounded-lg">Editar</a>
                <a href="{{ route('pagamentos.create', ['fatura_id' => $fatura->id]) }}" class="px-4 py-2 bg-[#eab308]/10 hover:bg-[#eab308]/20 text-[#eab308] rounded-lg">Registar Pagamento</a>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <!-- Status -->
            <div class="flex justify-between items-start">
                <span class="px-3 py-1 rounded-full text-sm
                    @if($fatura->status == 'paga') bg-green-500/20 text-green-400
                    @elseif($fatura->status == 'pendente') bg-yellow-500/20 text-yellow-400
                    @elseif($fatura->status == 'parcial') bg-blue-500/20 text-blue-400
                    @else bg-red-500/20 text-red-400 @endif">
                    {{ ucfirst($fatura->status) }}
                </span>
                <div class="text-right text-sm text-zinc-500">
                    Criado em {{ $fatura->created_at->format('d/m/Y H:i') }}
                </div>
            </div>

            <!-- Dados principais -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div><label class="block text-xs text-zinc-500">Cliente</label><p class="text-gray-300">{{ $fatura->cliente->nome }}</p></div>
                <div><label class="block text-xs text-zinc-500">NIF</label><p class="text-gray-300">{{ $fatura->cliente->nif }}</p></div>
                <div><label class="block text-xs text-zinc-500">Data de Emissão</label><p class="text-gray-300">{{ $fatura->data_emissao->format('d/m/Y') }}</p></div>
                <div><label class="block text-xs text-zinc-500">Data de Vencimento</label><p class="text-gray-300">{{ $fatura->data_vencimento->format('d/m/Y') }}</p></div>
                <div><label class="block text-xs text-zinc-500">Valor Total</label><p class="text-2xl font-bold text-[#eab308]">Kz {{ number_format($fatura->valor_total, 2) }}</p></div>
                <div><label class="block text-xs text-zinc-500">Valor Pago</label><p class="text-green-400">Kz {{ number_format($fatura->valor_pago, 2) }}</p></div>
                <div><label class="block text-xs text-zinc-500">Saldo em aberto</label><p class="text-red-400">Kz {{ number_format($fatura->saldo, 2) }}</p></div>
                <div><label class="block text-xs text-zinc-500">Tipo</label><p class="text-gray-300">{{ ucfirst($fatura->tipo) }}</p></div>
            </div>

            @if($fatura->descricao)
            <div class="border-t border-[#eab308]/20 pt-4">
                <label class="block text-xs text-zinc-500">Descrição</label>
                <p class="mt-1 text-gray-300">{{ $fatura->descricao }}</p>
            </div>
            @endif

            <!-- Pagamentos associados -->
            <div class="border-t border-[#eab308]/20 pt-4">
                <h3 class="text-md font-semibold text-white mb-3">Pagamentos registados</h3>
                @if($fatura->pagamentos->count())
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-[#0a0a0c] border-b border-[#eab308]/20">
                            <tr><th class="py-2 px-3 text-left">Data</th><th>Valor (Kz)</th><th>Método</th><th>Referência</th></tr>
                        </thead>
                        <tbody>
                            @foreach($fatura->pagamentos as $p)
                            <tr class="border-b border-[#eab308]/10">
                                <td class="py-2 px-3">{{ $p->data_pagamento->format('d/m/Y') }}</td>
                                <td class="py-2 px-3">Kz {{ number_format($p->valor, 2) }}</td>
                                <td class="py-2 px-3">{{ ucfirst($p->metodo) }}</td>
                                <td class="py-2 px-3">{{ $p->referencia ?? '—' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-gray-500">Nenhum pagamento registado.</p>
                @endif
            </div>
        </div>

        <!-- Rodapé com botão de exclusão -->
        <div class="flex justify-end p-6 border-t border-[#eab308]/20 bg-[#0a0a0c]">
            <form action="{{ route('faturas.destroy', $fatura) }}" method="POST" onsubmit="return confirm('Excluir fatura permanentemente?')">
                @csrf @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-500/10 hover:bg-red-500/20 text-red-400 rounded-lg">Excluir Fatura</button>
            </form>
        </div>
    </div>
</div>
@endsection