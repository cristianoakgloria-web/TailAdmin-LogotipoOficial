@extends('layouts.app')

@section('title', 'Fiscal')
@section('header', 'Fiscal')
@section('subheader', 'Visão geral das obrigações fiscais')

@section('content')
<div class="space-y-6 animate-fadeUp">
    @if(session('success'))
        <div class="p-4 rounded-xl bg-[#eab308]/10 border border-[#eab308]/40 text-[#eab308] text-sm flex items-center gap-2">
            <span>✅</span> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="p-4 rounded-xl bg-red-500/10 border border-red-500/40 text-red-400 text-sm flex items-center gap-2">
            <span>⚠️</span> {{ session('error') }}
        </div>
    @endif

    <!-- Cards de resumo -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-gradient-to-br from-[#111114] to-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-5 hover:border-[#eab308]/40 transition-all duration-300">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-full bg-[#eab308]/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-[#eab308]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <p class="text-zinc-500 text-sm uppercase tracking-wider">Faturas pagas<br>(12 meses)</p>
            </div>
            <p class="text-3xl font-bold text-white">{{ number_format($faturasPorMes->sum('quantidade'), 0, ',', '.') }}</p>
        </div>

        <div class="bg-gradient-to-br from-[#111114] to-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-5 hover:border-[#eab308]/40 transition-all duration-300">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-full bg-green-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p class="text-zinc-500 text-sm uppercase tracking-wider">Valor faturado<br>(12 meses)</p>
            </div>
            <p class="text-3xl font-bold text-[#eab308]">Kz {{ number_format($faturasPorMes->sum('total'), 2, ',', '.') }}</p>
        </div>

        <div class="bg-gradient-to-br from-[#111114] to-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-5 hover:border-[#eab308]/40 transition-all duration-300">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 rounded-full bg-blue-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                </div>
                <p class="text-zinc-500 text-sm uppercase tracking-wider">Documentos<br>arquivados</p>
            </div>
            <p class="text-3xl font-bold text-blue-400">{{ number_format($totalDocumentos, 0, ',', '.') }}</p>
            <a href="{{ route('fiscal.arquivoIndex') }}" class="text-xs text-[#eab308] hover:underline mt-2 inline-block">Ver arquivo →</a>
        </div>
    </div>

    <!-- Tabela de faturação mensal -->
    <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-5">
        <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-[#eab308]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            Faturação mensal (últimos 12 meses)
        </h3>
        @if($faturasPorMes->count())
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-[#0a0a0c] border-b border-[#eab308]/20">
                    <tr>
                        <th class="py-3 px-4 text-left text-xs font-semibold text-zinc-500 uppercase tracking-wider">Mês</th>
                        <th class="py-3 px-4 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider">Total (Kz)</th>
                        <th class="py-3 px-4 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider">Faturas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($faturasPorMes as $item)
                    <tr class="border-b border-[#eab308]/10 hover:bg-[#eab308]/5 transition">
                        <td class="py-3 px-4 text-gray-300">{{ \Carbon\Carbon::createFromFormat('Y-m', $item->mes)->translatedFormat('F/Y') }}</td>
                        <td class="py-3 px-4 text-right text-[#eab308] font-medium">Kz {{ number_format($item->total, 2, ',', '.') }}</td>
                        <td class="py-3 px-4 text-right text-gray-300">{{ $item->quantidade }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-8 text-gray-500">
            <svg class="w-12 h-12 mx-auto mb-3 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <p>Nenhuma fatura paga nos últimos 12 meses.</p>
        </div>
        @endif
    </div>

    <!-- Próximas obrigações fiscais -->
    <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-5">
        <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-[#eab308]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Próximas obrigações fiscais
        </h3>
        <ul class="space-y-3">
            @forelse($proximasObrigacoes as $obrig)
            <li class="flex justify-between items-center border-b border-[#eab308]/10 py-3 hover:bg-[#eab308]/5 transition px-2 rounded-lg">
                <span class="text-gray-300">{{ $obrig['titulo'] }}</span>
                <span class="inline-flex items-center gap-1 text-[#eab308] text-sm font-semibold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    {{ $obrig['data_limite'] }}
                </span>
            </li>
            @empty
            <li class="text-center text-gray-500 py-4">Nenhuma obrigação registada.</li>
            @endforelse
        </ul>
        <div class="mt-6 pt-2 border-t border-[#eab308]/20 text-right">
            <a href="{{ route('fiscal.relatorios') }}" class="inline-flex items-center gap-2 text-[#eab308] hover:text-[#facc15] text-sm font-semibold transition">
                Gerar relatórios detalhados
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</div>
@endsection