@extends('layouts.app')

@section('title', 'Pagamentos')
@section('header', 'Financeiro')

@section('content')
<div class="space-y-6 animate-fadeUp">
    @if(session('success'))
        <div class="p-4 rounded-xl bg-[#eab308]/10 border border-[#eab308]/40 text-[#eab308] text-sm">{{ session('success') }}</div>
    @endif

    <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold text-white">Pagamentos Registados</h2>
        <a href="{{ route('pagamentos.create') }}" class="bg-[#eab308] text-black px-4 py-2 rounded-lg">+ Novo Pagamento</a>
    </div>

    <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl overflow-x-auto">
        <table class="w-full">
            <thead class="bg-[#0a0a0c] border-b border-[#eab308]/20">
                <tr><th class="p-3 text-left">ID</th><th>Fatura</th><th>Cliente</th><th>Valor (Kz)</th><th>Data Pag.</th><th>Método</th><th>Ações</th></tr>
            </thead>
            <tbody>
                @forelse($pagamentos as $p)
                <tr class="border-b border-[#eab308]/10">
                    <td class="p-3">#{{ $p->id }}</td>
                    <td class="p-3">{{ $p->fatura->numero_fatura }}</td>
                    <td class="p-3">{{ $p->fatura->cliente->nome }}</td>
                    <td class="p-3">Kz {{ number_format($p->valor, 2) }}</td>
                    <td class="p-3">{{ $p->data_pagamento->format('d/m/Y') }}</td>
                    <td class="p-3">{{ ucfirst($p->metodo) }}</td>
                    <td class="p-3">
                        <a href="{{ route('pagamentos.confirmar', $p->id) }}" class="text-blue-400">Confirmar</a>
                        <form action="{{ route('pagamentos.destroy', $p->id) }}" method="POST" class="inline" onsubmit="return confirm('Remover pagamento?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-400 ml-2">Excluir</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="py-12 text-center text-gray-500">Nenhum pagamento registado.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $pagamentos->links() }}
</div>
@endsection