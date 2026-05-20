@extends('layouts.app')

@section('title', 'Conciliação de Vendas')
@section('header', 'Financeiro')

@section('content')
<div class="space-y-6 animate-fadeUp">
    @if(session('success'))
        <div class="p-4 rounded-xl bg-[#eab308]/10 border border-[#eab308]/40 text-[#eab308] text-sm">{{ session('success') }}</div>
    @endif

    <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl overflow-x-auto">
        <table class="w-full">
            <thead class="bg-[#0a0a0c] border-b border-[#eab308]/20">
                <tr>
                    <th class="p-3 text-left">Nº Fatura</th>
                    <th class="p-3 text-left">Cliente</th>
                    <th class="p-3 text-left">Valor (Kz)</th>
                    <th class="p-3 text-left">Pago (Kz)</th>
                    <th class="p-3 text-left">Saldo (Kz)</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($faturas as $fat)
                <tr class="border-b border-[#eab308]/10">
                    <td class="p-3">{{ $fat->numero_fatura }}</td>
                    <td class="p-3">{{ $fat->cliente->nome }}</td>
                    <td class="p-3">Kz {{ number_format($fat->valor_total, 2) }}</td>
                    <td class="p-3">Kz {{ number_format($fat->valor_pago, 2) }}</td>
                    <td class="p-3 font-bold {{ $fat->saldo > 0 ? 'text-red-400' : 'text-green-400' }}">Kz {{ number_format($fat->saldo, 2) }}</td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded-full text-xs {{ $fat->status == 'paga' ? 'bg-green-500/20 text-green-400' : 'bg-yellow-500/20 text-yellow-400' }}">
                            {{ ucfirst($fat->status) }}
                        </span>
                    </td>
                    <td class="p-3">
                        @if($fat->status != 'paga')
                            <form action="{{ route('financeiro.confirmarConciliacao') }}" method="POST">
                                @csrf
                                <input type="hidden" name="fatura_id" value="{{ $fat->id }}">
                                <button type="submit" class="px-3 py-1 bg-[#eab308]/20 text-[#eab308] rounded text-xs" {{ $fat->saldo > 0 ? 'disabled' : '' }}>
                                    {{ $fat->saldo <= 0 ? 'Marcar como Paga' : 'Saldo pendente' }}
                                </button>
                            </form>
                        @else
                            <span class="text-green-400 text-xs">Conciliada</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $faturas->links() }}
</div>
@endsection