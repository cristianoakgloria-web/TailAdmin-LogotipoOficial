@extends('layouts.app')

@section('title', 'Faturas')
@section('header', 'Financeiro')
@section('subheader', 'Gestão de faturas')

@section('content')
<div class="space-y-6 animate-fadeUp">
    @if(session('success'))
        <div class="p-4 rounded-xl bg-[#eab308]/10 border border-[#eab308]/40 text-[#eab308] text-sm">{{ session('success') }}</div>
    @endif

    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
        <h2 class="text-xl font-bold text-white">Faturas</h2>
        <a href="{{ route('faturas.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-[#eab308] hover:bg-[#d4a007] text-black font-bold rounded-lg transition">+ Nova Fatura</a>
    </div>

    <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#0a0a0c] border-b border-[#eab308]/20">
                    <tr>
                        <th class="p-3 text-left text-xs font-semibold text-zinc-500">Nº Fatura</th>
                        <th class="p-3 text-left text-xs font-semibold text-zinc-500">Cliente</th>
                        <th class="p-3 text-left text-xs font-semibold text-zinc-500">Emissão</th>
                        <th class="p-3 text-left text-xs font-semibold text-zinc-500">Vencimento</th>
                        <th class="p-3 text-left text-xs font-semibold text-zinc-500">Valor (Kz)</th>
                        <th class="p-3 text-left text-xs font-semibold text-zinc-500">Status</th>
                        <th class="p-3 text-left text-xs font-semibold text-zinc-500">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($faturas as $fat)
                    <tr class="border-b border-[#eab308]/10 hover:bg-[#eab308]/5 transition">
                        <td class="p-3 text-gray-300">{{ $fat->numero_fatura }}</td>
                        <td class="p-3 text-gray-300">{{ $fat->cliente->nome }}</td>
                        <td class="p-3 text-gray-300">
                            @if($fat->data_emissao)
                                {{ \Carbon\Carbon::parse($fat->data_emissao)->format('d/m/Y') }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="p-3 text-gray-300">
                            @if($fat->data_vencimento)
                                {{ \Carbon\Carbon::parse($fat->data_vencimento)->format('d/m/Y') }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="p-3 text-gray-300">Kz {{ number_format($fat->valor_total, 2, ',', '.') }}</td>
                        <td class="p-3">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                @if($fat->status == 'paga') bg-green-500/20 text-green-400
                                @elseif($fat->status == 'pendente') bg-yellow-500/20 text-yellow-400
                                @elseif($fat->status == 'parcial') bg-blue-500/20 text-blue-400
                                @else bg-red-500/20 text-red-400 @endif">
                                {{ ucfirst($fat->status) }}
                            </span>
                        </td>
                        <td class="p-3">
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('faturas.show', $fat) }}" class="text-green-400 hover:text-green-300 text-sm">Ver</a>
                                <a href="{{ route('faturas.edit', $fat) }}" class="text-blue-400 hover:text-blue-300 text-sm">Editar</a>
                                <form action="{{ route('faturas.destroy', $fat) }}" method="POST" class="inline" onsubmit="return confirm('Excluir fatura?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 text-sm">Excluir</button>
                                </form>
                                <a href="{{ route('pagamentos.create', ['fatura_id' => $fat->id]) }}" class="text-[#eab308] hover:text-[#d4a007] text-sm">Registar Pagamento</a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="py-12 text-center text-gray-500">Nenhuma fatura encontrada.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{ $faturas->links() }}
</div>
@endsection