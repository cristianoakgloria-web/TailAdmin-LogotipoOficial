@extends('layouts.app')

@section('title', 'Registar Pagamento')
@section('header', 'Financeiro')

@section('content')
<div class="max-w-2xl mx-auto animate-fadeUp">
    <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-6">
        <h2 class="text-xl font-bold text-white mb-4">Registar Pagamento</h2>

        <form method="POST" action="{{ route('pagamentos.store') }}">
            @csrf

            @if(isset($fatura) && $fatura)
                <input type="hidden" name="fatura_id" value="{{ $fatura->id }}">
                <div class="mb-4 p-3 bg-[#1a1a1c] rounded-lg">
                    <p class="text-sm text-zinc-400">Fatura: <span class="text-white">{{ $fatura->numero_fatura }}</span></p>
                    <p class="text-sm text-zinc-400">Cliente: <span class="text-white">{{ $fatura->cliente->nome }}</span></p>
                    <p class="text-sm text-zinc-400">Valor total: <span class="text-[#eab308]">Kz {{ number_format($fatura->valor_total, 2) }}</span></p>
                    <p class="text-sm text-zinc-400">Saldo em aberto: <span class="text-red-400">Kz {{ number_format($fatura->saldo, 2) }}</span></p>
                </div>
            @else
                <div class="mb-4">
                    <label class="block text-sm text-zinc-400 mb-1">Fatura *</label>
                    <select name="fatura_id" required class="w-full bg-black border border-gray-700 rounded-lg p-2">
                        <option value="">Selecione</option>
                        @foreach($faturas as $fat)
                            <option value="{{ $fat->id }}">{{ $fat->numero_fatura }} - {{ $fat->cliente->nome }} (Saldo: Kz {{ number_format($fat->saldo, 2) }})</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="mb-4">
                <label class="block text-sm text-zinc-400 mb-1">Valor pago (Kz) *</label>
                <input type="number" step="0.01" name="valor" required class="w-full bg-black border border-gray-700 rounded-lg p-2">
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm text-zinc-400 mb-1">Data Pagamento *</label>
                    <input type="date" name="data_pagamento" value="{{ date('Y-m-d') }}" required class="w-full bg-black border border-gray-700 rounded-lg p-2">
                </div>
                <div>
                    <label class="block text-sm text-zinc-400 mb-1">Método *</label>
                    <select name="metodo" class="w-full bg-black border border-gray-700 rounded-lg p-2">
                        <option value="dinheiro">Dinheiro</option>
                        <option value="transferencia">Transferência Bancária</option>
                        <option value="deposito">Depósito</option>
                        <option value="cheque">Cheque</option>
                        <option value="outro">Outro</option>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm text-zinc-400 mb-1">Referência (comprovativo)</label>
                <input type="text" name="referencia" class="w-full bg-black border border-gray-700 rounded-lg p-2" placeholder="Nº de transferência, cheque, etc.">
            </div>

            <div class="mb-4">
                <label class="block text-sm text-zinc-400 mb-1">Observações</label>
                <textarea name="observacoes" rows="2" class="w-full bg-black border border-gray-700 rounded-lg p-2"></textarea>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('pagamentos.index') }}" class="px-4 py-2 bg-gray-700 rounded-lg">Cancelar</a>
                <button type="submit" class="px-6 py-2 bg-[#eab308] text-black font-bold rounded-lg">Registar Pagamento</button>
            </div>
        </form>
    </div>
</div>
@endsection