@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')
@section('subheader', 'Visão geral do sistema')

@section('content')
<div class="space-y-8 animate-fadeUp">

    {{-- ==================== CARDS ==================== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Vendas totais --}}
        <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-6 hover:border-[#eab308]/40 transition">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-full bg-[#eab308]/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#eab308]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-green-500 text-sm font-semibold bg-green-500/10 px-2 py-1 rounded-lg">{{ $crescimentoVendas >= 0 ? '↑' : '↓' }} {{ abs($crescimentoVendas) }}%</span>
            </div>
            <h3 class="text-zinc-500 text-sm uppercase tracking-wider mb-1">VENDAS TOTAIS</h3>
            <p class="text-3xl font-bold text-white">Kz {{ number_format($totalVendas, 2, ',', '.') }}</p>
            <p class="text-zinc-600 text-xs mt-2">Serviços contratados/concluídos</p>
        </div>

        {{-- Clientes --}}
        <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-6 hover:border-[#eab308]/40 transition">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-full bg-[#eab308]/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#eab308]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <span class="text-green-500 text-sm font-semibold bg-green-500/10 px-2 py-1 rounded-lg">{{ $crescimentoClientes >= 0 ? '↑' : '↓' }} {{ abs($crescimentoClientes) }}%</span>
            </div>
            <h3 class="text-zinc-500 text-sm uppercase tracking-wider mb-1">CLIENTES</h3>
            <p class="text-3xl font-bold text-white">{{ number_format($totalClientes, 0, ',', '.') }}</p>
            <p class="text-zinc-600 text-xs mt-2">Total cadastrados</p>
        </div>

        {{-- Serviços pendentes --}}
        <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-6 hover:border-[#eab308]/40 transition">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-full bg-yellow-500/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-yellow-500 text-sm font-semibold bg-yellow-500/10 px-2 py-1 rounded-lg">Em andamento</span>
            </div>
            <h3 class="text-zinc-500 text-sm uppercase tracking-wider mb-1">SERVIÇOS PENDENTES</h3>
            <p class="text-3xl font-bold text-white">{{ $servicosPendentes }}</p>
            <p class="text-zinc-600 text-xs mt-2">Propostas / Negociações / Em execução</p>
        </div>

        {{-- Faturas pendentes --}}
        <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-6 hover:border-[#eab308]/40 transition">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-full bg-red-500/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <span class="text-red-500 text-sm font-semibold bg-red-500/10 px-2 py-1 rounded-lg">A receber</span>
            </div>
            <h3 class="text-zinc-500 text-sm uppercase tracking-wider mb-1">FATURAS PENDENTES</h3>
            <p class="text-2xl font-bold text-white">Kz {{ number_format($totalFaturasPendentesValor, 2, ',', '.') }}</p>
            <p class="text-zinc-600 text-xs mt-2">{{ $totalFaturasPendentesQtd }} fatura(s) em aberto</p>
        </div>
    </div>

    {{-- ==================== FLUXO DE CAIXA + TICKET MÉDIO ==================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-6">
            <h3 class="text-lg font-bold text-white mb-3">Fluxo de Caixa (últimos 30 dias)</h3>
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-zinc-500">Entradas</p>
                    <p class="text-2xl font-bold text-green-400">+ Kz {{ number_format($entradasUltimos30, 2, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-sm text-zinc-500">Saídas</p>
                    <p class="text-2xl font-bold text-red-400">- Kz {{ number_format($saidasUltimos30, 2, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-sm text-zinc-500">Saldo</p>
                    <p class="text-2xl font-bold {{ $saldo30d >= 0 ? 'text-[#eab308]' : 'text-red-400' }}">Kz {{ number_format($saldo30d, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-6 flex items-center justify-between">
            <div>
                <p class="text-sm text-zinc-500">Ticket médio por serviço</p>
                <p class="text-3xl font-bold text-white">Kz {{ number_format($ticketMedio, 2, ',', '.') }}</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-zinc-500">Serviços concluídos</p>
                <p class="text-3xl font-bold text-white">{{ $servicosConcluidos }}</p>
            </div>
        </div>
    </div>

    {{-- ==================== GRÁFICO + ATIVIDADES ==================== --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-6">
            <h3 class="text-lg font-bold text-white mb-4">Vendas mensais (últimos 12 meses)</h3>
            <div class="h-64">
                @if(count($vendasMensais) > 0)
                    <canvas id="vendasChart" class="w-full h-full"></canvas>
                @else
                    <div class="h-64 flex items-center justify-center text-zinc-500">
                        Sem dados de vendas nos últimos 12 meses.
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-6">
            <h3 class="text-lg font-bold text-white mb-4">Atividades recentes</h3>
            <div class="space-y-4 max-h-[320px] overflow-y-auto pr-2">
                @forelse($atividadesRecentes as $atv)
                <div class="flex items-start gap-3 pb-3 border-b border-[#eab308]/10">
                    <div class="w-8 h-8 rounded-full bg-{{ $atv['cor'] }}-500/10 flex items-center justify-center flex-shrink-0">
                        <span class="text-lg">{{ $atv['icone'] }}</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-300">{{ $atv['descricao'] }}</p>
                        @if($atv['cliente'])<p class="text-xs text-zinc-500">{{ $atv['cliente'] }}</p>@endif
                        @if($atv['valor'])<p class="text-xs text-zinc-500">Valor: Kz {{ number_format($atv['valor'], 2, ',', '.') }}</p>@endif
                        <p class="text-xs text-zinc-600 mt-1">{{ $atv['data']->diffForHumans() }}</p>
                    </div>
                </div>
                @empty
                <p class="text-center text-gray-500 py-8">Nenhuma atividade recente.</p>
                @endforelse
            </div>
            <a href="#" class="block text-center mt-4 text-[#eab308] hover:text-[#facc15] text-sm font-semibold transition">
                Ver todas as actividades →
            </a>
        </div>
    </div>

    {{-- ==================== TABELA DE ÚLTIMOS SERVIÇOS ==================== --}}
    <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-bold text-white">Últimos serviços / campanhas</h3>
            <a href="{{ route('vendas.index') }}" class="text-[#eab308] hover:text-[#facc15] text-sm font-semibold transition">Ver todos</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-[#eab308]/20">
                        <th class="text-left py-3 px-4 text-xs font-semibold text-zinc-500 uppercase">Título</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-zinc-500 uppercase">Cliente</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-zinc-500 uppercase">Valor (Kz)</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-zinc-500 uppercase">Status</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-zinc-500 uppercase">Data</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ultimosServicos as $servico)
                    <tr class="border-b border-[#eab308]/10 hover:bg-[#eab308]/5 transition">
                        <td class="py-3 px-4 text-sm text-gray-300">{{ $servico->titulo }}</td>
                        <td class="py-3 px-4 text-sm text-gray-300">{{ $servico->cliente->nome }}</td>
                        <td class="py-3 px-4 text-sm text-gray-300">Kz {{ number_format($servico->valor, 2, ',', '.') }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                @if($servico->status == 'contratado') bg-green-500/20 text-green-500
                                @elseif($servico->status == 'concluido') bg-emerald-500/20 text-emerald-500
                                @elseif($servico->status == 'em_andamento') bg-yellow-500/20 text-yellow-500
                                @elseif($servico->status == 'proposta') bg-blue-500/20 text-blue-500
                                @elseif($servico->status == 'negociacao') bg-purple-500/20 text-purple-500
                                @else bg-red-500/20 text-red-500 @endif">
                                {{ ucfirst(str_replace('_', ' ', $servico->status)) }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-sm text-zinc-500">{{ $servico->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @empty
                    <td><td colspan="5" class="py-6 text-center text-gray-500">Nenhum serviço cadastrado ainda.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ==================== AÇÕES RÁPIDAS ==================== --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('vendas.create') }}" class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-4 text-center hover:border-[#eab308]/40 transition group">
            <div class="w-10 h-10 mx-auto rounded-full bg-[#eab308]/10 flex items-center justify-center mb-2 group-hover:bg-[#eab308]/20 transition">
                <svg class="w-5 h-5 text-[#eab308]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </div>
            <span class="text-sm font-medium text-gray-300">Novo serviço</span>
        </a>
        <a href="{{ route('clientes.create') }}" class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-4 text-center hover:border-[#eab308]/40 transition group">
            <div class="w-10 h-10 mx-auto rounded-full bg-[#eab308]/10 flex items-center justify-center mb-2 group-hover:bg-[#eab308]/20 transition">
                <svg class="w-5 h-5 text-[#eab308]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            </div>
            <span class="text-sm font-medium text-gray-300">Novo cliente</span>
        </a>
        <a href="{{ route('faturas.create') }}" class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-4 text-center hover:border-[#eab308]/40 transition group">
            <div class="w-10 h-10 mx-auto rounded-full bg-[#eab308]/10 flex items-center justify-center mb-2 group-hover:bg-[#eab308]/20 transition">
                <svg class="w-5 h-5 text-[#eab308]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <span class="text-sm font-medium text-gray-300">Nova fatura</span>
        </a>
        <a href="{{ route('diario-caixa.index') }}" class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-4 text-center hover:border-[#eab308]/40 transition group">
            <div class="w-10 h-10 mx-auto rounded-full bg-[#eab308]/10 flex items-center justify-center mb-2 group-hover:bg-[#eab308]/20 transition">
                <svg class="w-5 h-5 text-[#eab308]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M6 7h12M6 17h12M5 4h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V5a1 1 0 011-1z"/></svg>
            </div>
            <span class="text-sm font-medium text-gray-300">Diário de caixa</span>
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const vendasMensais = @json($vendasMensais);
    if (vendasMensais.length > 0) {
        const ctx = document.getElementById('vendasChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: vendasMensais.map(item => `${item.mes}/${item.ano}`),
                datasets: [{
                    label: 'Vendas (Kz)',
                    data: vendasMensais.map(item => item.total),
                    backgroundColor: 'rgba(234, 179, 8, 0.6)',
                    borderColor: 'rgba(234, 179, 8, 1)',
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { labels: { color: '#9ca3af' } },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => `Kz ${ctx.raw.toLocaleString('pt-AO')}`
                        }
                    }
                },
                scales: {
                    y: {
                        ticks: {
                            color: '#9ca3af',
                            callback: (val) => `Kz ${val.toLocaleString('pt-AO')}`
                        },
                        grid: { color: '#1f1f24' }
                    },
                    x: { ticks: { color: '#9ca3af' }, grid: { display: false } }
                }
            }
        });
    } else {
        // Exibir mensagem de ausência de dados (já feita na view)
        const chartContainer = document.getElementById('vendasChart');
        if (chartContainer) chartContainer.style.display = 'none';
    }
</script>
@endpush