@extends('layouts.app')

@section('title', 'Confirmar Pagamento')
@section('header', 'Financeiro')

@section('content')
<div class="max-w-2xl mx-auto animate-fadeUp">
    <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-6">
        <h2 class="text-xl font-bold text-white mb-4">Detalhes do Pagamento</h2>

        <div class="space-y-3 p-4 bg-[#1a1a1c] rounded-xl">
            <p><span class="text-zinc-500">Fatura:</span> <span class="text-white">{{ $pagamento->fatura->numero_fatura }}</span></p>
            <p><span class="text-zinc-500">Cliente:</span> <span class="text-white">{{ $pagamento->fatura->cliente->nome }}</span></p>
            <p><span class="text-zinc-500">Valor pago:</span> <span class="text-green-400 font-bold">Kz {{ number_format($pagamento->valor, 2) }}</span></p>
            <p><span class="text-zinc-500">Data de pagamento:</span> <span class="text-white">{{ $pagamento->data_pagamento->format('d/m/Y') }}</span></p>
            <p><span class="text-zinc-500">Método:</span> <span class="text-white">{{ ucfirst($pagamento->metodo) }}</span></p>
            @if($pagamento->referencia)
            <p><span class="text-zinc-500">Referência:</span> <span class="text-white">{{ $pagamento->referencia }}</span></p>
            @endif
            @if($pagamento->observacoes)
            <p><span class="text-zinc-500">Observações:</span> <span class="text-white">{{ $pagamento->observacoes }}</span></p>
            @endif
        </div>

        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('pagamentos.index') }}" class="px-4 py-2 bg-gray-700 rounded-lg">Voltar</a>
            <a href="{{ route('faturas.show', $pagamento->fatura_id) }}" class="px-4 py-2 bg-[#eab308] text-black font-bold rounded-lg">Ver Fatura</a>
        </div>
    </div>
</div>
@endsection