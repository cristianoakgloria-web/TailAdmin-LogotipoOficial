@extends('layouts.app')

@section('title', 'Diário de Caixa')
@section('header', 'Diário de Caixa')
@section('subheader', 'Gestão inteligente de fluxo financeiro')

@section('content')
<div class="space-y-6 animate-fadeUp">

    {{-- ==================== CARDS DE RESUMO (só se houver diário selecionado) ==================== --}}
    @if($arquivoAtual)
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-[#111114] to-[#0c0c0e] border border-white/5 rounded-2xl p-5 shadow-2xl hover:border-[#eab308]/30 transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <p class="text-zinc-500 text-sm">Saldo Atual</p>
                <div class="w-10 h-10 rounded-xl bg-[#eab308]/10 flex items-center justify-center">💰</div>
            </div>
            <h2 class="text-2xl font-bold {{ $saldoAtual >= 0 ? 'text-[#eab308]' : 'text-red-400' }}">
                {{ number_format($saldoAtual, 2, ',', '.') }} {{ $arquivoAtual->moeda }}
            </h2>
            <p class="text-xs text-zinc-600 mt-1">{{ $arquivoAtual->nome }}</p>
        </div>

        <div class="bg-gradient-to-br from-[#111114] to-[#0c0c0e] border border-green-500/10 rounded-2xl p-5 shadow-2xl hover:border-green-500/30 transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <p class="text-zinc-500 text-sm">Entradas</p>
                <div class="w-10 h-10 rounded-xl bg-green-500/10 flex items-center justify-center">📈</div>
            </div>
            <h2 class="text-2xl font-bold text-green-400">{{ number_format($totalEntradas, 2, ',', '.') }} {{ $arquivoAtual->moeda }}</h2>
        </div>

        <div class="bg-gradient-to-br from-[#111114] to-[#0c0c0e] border border-red-500/10 rounded-2xl p-5 shadow-2xl hover:border-red-500/30 transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <p class="text-zinc-500 text-sm">Saídas</p>
                <div class="w-10 h-10 rounded-xl bg-red-500/10 flex items-center justify-center">📉</div>
            </div>
            <h2 class="text-2xl font-bold text-red-400">{{ number_format($totalSaidas, 2, ',', '.') }} {{ $arquivoAtual->moeda }}</h2>
        </div>

        <div class="bg-gradient-to-br from-[#111114] to-[#0c0c0e] border border-blue-500/10 rounded-2xl p-5 shadow-2xl hover:border-blue-500/30 transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <p class="text-zinc-500 text-sm">Transações</p>
                <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center">📄</div>
            </div>
            <h2 class="text-2xl font-bold text-blue-400">{{ $transacoes->count() }}</h2>
        </div>
    </div>

    {{-- BARRA DO DIÁRIO ATUAL --}}
    <div class="bg-gradient-to-r from-[#121216] to-[#0d0d10] border border-[#eab308]/20 rounded-2xl p-5 flex flex-col md:flex-row md:items-center md:justify-between gap-4 shadow-xl">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-xl bg-[#eab308]/10 flex items-center justify-center text-xl">📂</div>
            <div>
                <h2 class="text-lg font-bold text-white">{{ $arquivoAtual->nome }}</h2>
                <p class="text-sm text-zinc-500">{{ $arquivoAtual->mes }}/{{ $arquivoAtual->ano }} • {{ $arquivoAtual->moeda }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $arquivoAtual->status === 'rascunho' ? 'bg-yellow-500/10 text-yellow-400' : 'bg-green-500/10 text-green-400' }}">
                {{ ucfirst($arquivoAtual->status) }}
            </span>
            <a href="{{ route('diario-caixa.index') }}" class="px-4 py-2 rounded-xl bg-white/5 hover:bg-white/10 text-zinc-300 transition-all duration-300 text-sm">
                ← Voltar à lista
            </a>
            <form action="{{ route('diario-caixa.exportar') }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="ano" value="{{ $arquivoAtual->ano }}">
                <input type="hidden" name="mes" value="{{ $arquivoAtual->mes }}">
                <input type="hidden" name="moeda" value="{{ $arquivoAtual->moeda }}">
                <input type="hidden" name="saldo_anterior" value="{{ $arquivoAtual->saldo_anterior }}">
                <input type="hidden" name="despesa_anterior" value="{{ $arquivoAtual->despesa_anterior }}">
                <input type="hidden" name="arquivo_id" value="{{ $arquivoAtual->id }}">
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-green-600 hover:bg-green-500 text-white font-semibold transition-all duration-300 text-sm">
                    📥 Exportar Excel
                </button>
            </form>
        </div>
    </div>
    @endif

    {{-- ==================== GESTÃO DE DIÁRIOS ==================== --}}
    <div class="bg-gradient-to-b from-[#111114] to-[#0b0b0d] border border-white/5 rounded-2xl overflow-hidden shadow-2xl">
        <div class="border-b border-white/5 px-6 py-5 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-white">
                    @if($arquivoAtual)
                        Diários de Caixa
                    @else
                        📁 Diários de Caixa
                    @endif
                </h2>
                <p class="text-sm text-zinc-500 mt-1">
                    @if($arquivoAtual)
                        Selecione outro diário ou crie um novo.
                    @else
                        Selecione ou crie um diário para começar a registar transações.
                    @endif
                </p>
            </div>
            <button onclick="abrirModalDiario()" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-[#eab308] hover:bg-[#d4a007] text-black font-bold transition-all duration-300 hover:scale-[1.02] shadow-lg">
                <span class="text-lg">+</span> Novo Diário
            </button>
        </div>

        <div class="divide-y divide-white/5">
            @forelse($arquivos as $arquivo)
            <div class="p-5 hover:bg-white/[0.02] transition-all duration-300 {{ request('arquivo_id') == $arquivo->id ? 'bg-[#eab308]/5 border-l-2 border-l-[#eab308]' : '' }}">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl {{ request('arquivo_id') == $arquivo->id ? 'bg-[#eab308]/20' : 'bg-[#eab308]/10' }} flex items-center justify-center text-2xl">
                            {{ request('arquivo_id') == $arquivo->id ? '📂' : '📁' }}
                        </div>
                        <div>
                            <h3 class="text-white font-semibold text-lg">
                                <a href="?arquivo_id={{ $arquivo->id }}" class="hover:text-[#eab308] transition">
                                    {{ $arquivo->nome }}
                                </a>
                                @if(request('arquivo_id') == $arquivo->id)
                                    <span class="text-xs text-[#eab308] ml-2">✓ Atual</span>
                                @endif
                            </h3>
                            <div class="flex items-center gap-3 mt-1 flex-wrap">
                                <span class="text-sm text-zinc-500">{{ $arquivo->mes }}/{{ $arquivo->ano }}</span>
                                <span class="text-sm text-zinc-600">•</span>
                                <span class="text-sm text-zinc-500">{{ $arquivo->moeda }}</span>
                                <span class="text-sm text-zinc-600">•</span>
                                <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $arquivo->status === 'rascunho' ? 'bg-yellow-500/10 text-yellow-400' : 'bg-green-500/10 text-green-400' }}">
                                    {{ ucfirst($arquivo->status) }}
                                </span>
                                @php
                                    $countTransacoes = \App\Models\Transacao::where('arquivo_caixa_id', $arquivo->id)->count();
                                @endphp
                                <span class="text-sm text-zinc-600">•</span>
                                <span class="text-sm text-zinc-500">{{ $countTransacoes }} transações</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 flex-wrap">
                        @if(request('arquivo_id') != $arquivo->id)
                            <a href="?arquivo_id={{ $arquivo->id }}" class="px-4 py-2 rounded-xl bg-[#eab308]/10 hover:bg-[#eab308]/20 text-[#eab308] font-semibold transition-all duration-300">Abrir</a>
                        @endif
                        @if($arquivo->arquivo_path)
                        <a href="{{ asset('storage/' . $arquivo->arquivo_path) }}" class="px-4 py-2 rounded-xl bg-green-500/10 hover:bg-green-500/20 text-green-400 font-semibold transition-all duration-300">📥</a>
                        @endif
                        <form action="{{ route('diario-caixa.arquivos.destroy', $arquivo->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Excluir este diário permanentemente?')" class="px-4 py-2 rounded-xl bg-red-500/10 hover:bg-red-500/20 text-red-400 font-semibold transition-all duration-300">🗑️</button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="py-20 px-6 text-center">
                <div class="max-w-md mx-auto">
                    <div class="w-24 h-24 rounded-3xl bg-[#eab308]/10 flex items-center justify-center text-5xl mx-auto mb-6">📂</div>
                    <h3 class="text-2xl font-bold text-white mb-3">Nenhum diário encontrado</h3>
                    <p class="text-zinc-500 mb-8 leading-relaxed">Crie o primeiro diário de caixa para começar a controlar entradas, saídas e relatórios financeiros.</p>
                    <button onclick="abrirModalDiario()" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-[#eab308] hover:bg-[#d4a007] text-black font-bold transition-all duration-300 shadow-lg hover:scale-[1.02]">+ Criar Primeiro Diário</button>
                </div>
            </div>
            @endforelse
        </div>
    </div>

    {{-- ==================== TRANSAÇÕES (só se houver diário selecionado) ==================== --}}
    @if($arquivoAtual)
    <div class="bg-gradient-to-b from-[#111114] to-[#0b0b0d] border border-white/5 rounded-2xl overflow-hidden shadow-2xl">
        <div class="border-b border-white/5 px-6 py-5 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-white">Transações</h2>
                <p class="text-sm text-zinc-500 mt-1">{{ $transacoes->count() }} registos em <span class="text-[#eab308]">{{ $arquivoAtual->nome }}</span></p>
            </div>
            <button onclick="abrirModalTransacao()" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-[#eab308] hover:bg-[#d4a007] text-black font-bold transition-all duration-300 hover:scale-[1.02] shadow-lg">
                + Nova Transação
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#0a0a0c] border-b border-white/5">
                    <tr>
                        <th class="text-left px-5 py-4 text-xs uppercase tracking-wider text-zinc-500">Data</th>
                        <th class="text-left px-5 py-4 text-xs uppercase tracking-wider text-zinc-500">Descrição</th>
                        <th class="text-left px-5 py-4 text-xs uppercase tracking-wider text-zinc-500 hidden md:table-cell">Categoria</th>
                        <th class="text-left px-5 py-4 text-xs uppercase tracking-wider text-zinc-500">Tipo</th>
                        <th class="text-right px-5 py-4 text-xs uppercase tracking-wider text-zinc-500">Valor</th>
                        <th class="text-center px-5 py-4 text-xs uppercase tracking-wider text-zinc-500">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transacoes as $t)
                    <tr class="border-b border-white/5 hover:bg-white/[0.02] transition-all duration-300 group">
                        <td class="px-5 py-4 text-sm text-zinc-300 whitespace-nowrap">{{ \Carbon\Carbon::parse($t->data_vencimento)->format('d/m/Y') }}</td>
                        <td class="px-5 py-4 text-sm text-white font-medium max-w-xs truncate">{{ $t->descricao }}</td>
                        <td class="px-5 py-4 text-sm text-zinc-500 hidden md:table-cell">{{ $t->categoria ?? 'Geral' }}</td>
                        <td class="px-5 py-4">
                            @if($t->tipo === 'entrada')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-500/10 text-green-400">Entrada</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-500/10 text-red-400">Saída</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-right font-bold whitespace-nowrap {{ $t->tipo === 'entrada' ? 'text-green-400' : 'text-red-400' }}">
                            {{ $t->tipo === 'saida' ? '−' : '+' }}{{ number_format($t->valor, 2, ',', '.') }} {{ $arquivoAtual->moeda }}
                        </td>
                        <td class="px-5 py-4 text-center">
                            <button onclick="excluirTransacao({{ $t->id }})" class="px-4 py-2 rounded-xl bg-red-500/10 hover:bg-red-500/20 text-red-400 text-sm font-semibold transition-all duration-300 opacity-0 group-hover:opacity-100">Excluir</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-20 text-center">
                            <div class="max-w-md mx-auto">
                                <div class="w-24 h-24 rounded-3xl bg-white/5 flex items-center justify-center text-5xl mx-auto mb-6">📄</div>
                                <h3 class="text-2xl font-bold text-white mb-3">Nenhuma transação</h3>
                                <p class="text-zinc-500 mb-6 leading-relaxed">O diário <strong class="text-[#eab308]">{{ $arquivoAtual->nome }}</strong> ainda não tem transações.</p>
                                <button onclick="abrirModalTransacao()" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-[#eab308] hover:bg-[#d4a007] text-black font-bold transition-all duration-300 shadow-lg">+ Adicionar Primeira Transação</button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @else
    {{-- Sem diário selecionado: mensagem amigável --}}
    <div class="bg-gradient-to-b from-[#111114] to-[#0b0b0d] border border-white/5 rounded-2xl overflow-hidden shadow-2xl">
        <div class="py-20 px-6 text-center">
            <div class="max-w-md mx-auto">
                <div class="w-24 h-24 rounded-3xl bg-[#eab308]/10 flex items-center justify-center text-5xl mx-auto mb-6">📋</div>
                <h3 class="text-2xl font-bold text-white mb-3">Selecione um diário</h3>
                <p class="text-zinc-500 mb-8 leading-relaxed">Escolha um diário existente ou crie um novo para visualizar e gerir as transações.</p>
                <button onclick="abrirModalDiario()" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-[#eab308] hover:bg-[#d4a007] text-black font-bold transition-all duration-300 shadow-lg hover:scale-[1.02]">+ Criar Diário</button>
            </div>
        </div>
    </div>
    @endif

</div>

{{-- ==================== MODAL: NOVA TRANSAÇÃO ==================== --}}
<div id="modalTransacao" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="w-full max-w-lg bg-[#111114] border border-white/10 rounded-3xl shadow-2xl overflow-hidden animate-fadeUp">
        <div class="px-6 py-5 border-b border-white/5 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-white">Nova Transação</h2>
                <p class="text-sm text-zinc-500 mt-1">Diário: <span class="text-[#eab308]">{{ $arquivoAtual->nome ?? '—' }}</span></p>
            </div>
            <button onclick="fecharModalTransacao()" class="w-10 h-10 rounded-xl bg-white/5 hover:bg-white/10 text-zinc-400 transition-all duration-300 flex items-center justify-center">✕</button>
        </div>
        <form action="{{ route('diario-caixa.store') }}" method="POST" class="p-6 space-y-4">
            @csrf
            @if($arquivoAtual)
                <input type="hidden" name="arquivo_caixa_id" value="{{ $arquivoAtual->id }}">
                <input type="hidden" name="redirect_to_arquivo" value="1">
            @endif
            <div>
                <label class="block text-sm text-zinc-400 mb-1">Data <span class="text-[#eab308]">*</span></label>
                <input type="date" name="data_vencimento" value="{{ date('Y-m-d') }}" required
                       class="w-full bg-[#0a0a0c] border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#eab308] transition-all duration-300">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-zinc-400 mb-1">Tipo <span class="text-[#eab308]">*</span></label>
                    <select name="tipo" required class="w-full bg-[#0a0a0c] border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#eab308] transition-all duration-300">
                        <option value="entrada">💰 Entrada (+)</option>
                        <option value="saida">💸 Saída (−)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm text-zinc-400 mb-1">Valor <span class="text-[#eab308]">*</span></label>
                    <input type="number" name="valor" placeholder="0,00" step="0.01" min="0.01" required
                           class="w-full bg-[#0a0a0c] border border-white/10 rounded-xl px-4 py-3 text-white placeholder:text-zinc-600 focus:outline-none focus:border-[#eab308] transition-all duration-300">
                </div>
            </div>
            <div>
                <label class="block text-sm text-zinc-400 mb-1">Categoria</label>
                <select name="categoria" class="w-full bg-[#0a0a0c] border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#eab308] transition-all duration-300">
                    <option value="">Geral</option>
                    <option value="Caixa">🏦 Caixa</option>
                    <option value="Vendas">🛒 Vendas</option>
                    <option value="Serviços">🔧 Serviços</option>
                    <option value="Material">📦 Material</option>
                    <option value="Utilidades">💡 Utilidades</option>
                    <option value="Salários">👥 Salários</option>
                    <option value="Impostos">📋 Impostos</option>
                    <option value="Marketing">📢 Marketing</option>
                    <option value="Outros">📌 Outros</option>
                </select>
            </div>
            <div>
                <label class="block text-sm text-zinc-400 mb-1">Designação <span class="text-[#eab308]">*</span></label>
                <input type="text" name="descricao" placeholder="Descreva a transação..." required
                       class="w-full bg-[#0a0a0c] border border-white/10 rounded-xl px-4 py-3 text-white placeholder:text-zinc-600 focus:outline-none focus:border-[#eab308] transition-all duration-300">
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="fecharModalTransacao()" class="px-5 py-3 rounded-xl border border-white/10 text-zinc-300 hover:bg-white/5 transition-all duration-300">Cancelar</button>
                <button type="submit" class="px-5 py-3 rounded-xl bg-[#eab308] hover:bg-[#d4a007] text-black font-bold transition-all duration-300 shadow-lg hover:scale-[1.02]">✅ Adicionar</button>
            </div>
        </form>
    </div>
</div>

{{-- ==================== MODAL: NOVO DIÁRIO ==================== --}}
<div id="modalDiario" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="w-full max-w-2xl bg-[#111114] border border-white/10 rounded-3xl shadow-2xl overflow-hidden animate-fadeUp">
        <div class="px-6 py-5 border-b border-white/5 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-white">Criar Novo Diário</h2>
                <p class="text-sm text-zinc-500 mt-1">Configure um novo período financeiro.</p>
            </div>
            <button onclick="fecharModalDiario()" class="w-10 h-10 rounded-xl bg-white/5 hover:bg-white/10 text-zinc-400 transition-all duration-300 flex items-center justify-center">✕</button>
        </div>
        <form action="{{ route('diario-caixa.arquivos.store') }}" method="POST" class="p-6 space-y-5">
            @csrf
            <div>
                <label class="block text-sm text-zinc-400 mb-2">Nome do Diário <span class="text-[#eab308]">*</span></label>
                <input type="text" name="nome" placeholder="Ex: Diário Maio 2026" required
                       class="w-full bg-[#0a0a0c] border border-white/10 rounded-xl px-4 py-3 text-white placeholder:text-zinc-600 focus:outline-none focus:border-[#eab308] transition-all duration-300">
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Mês <span class="text-[#eab308]">*</span></label>
                    <select name="mes" required class="w-full bg-[#0a0a0c] border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#eab308] transition-all duration-300">
                        @foreach(['JANEIRO', 'FEVEREIRO', 'MARÇO', 'ABRIL', 'MAIO', 'JUNHO', 'JULHO', 'AGOSTO', 'SETEMBRO', 'OUTUBRO', 'NOVEMBRO', 'DEZEMBRO'] as $i => $nome)
                            <option value="{{ $nome }}" {{ $i + 1 == date('m') ? 'selected' : '' }}>{{ $nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Ano <span class="text-[#eab308]">*</span></label>
                    <input type="number" name="ano" value="{{ date('Y') }}" required min="2000" max="2099"
                           class="w-full bg-[#0a0a0c] border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#eab308] transition-all duration-300">
                </div>
                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Moeda</label>
                    <select name="moeda" class="w-full bg-[#0a0a0c] border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#eab308] transition-all duration-300">
                        <option value="AKZ">🇦🇴 AKZ — Kwanza</option>
                        <option value="USD">🇺🇸 USD — Dólar</option>
                        <option value="EUR">🇪🇺 EUR — Euro</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Saldo Mês Anterior</label>
                    <input type="number" name="saldo_anterior" value="0" step="0.01"
                           class="w-full bg-[#0a0a0c] border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#eab308] transition-all duration-300">
                </div>
                <div>
                    <label class="block text-sm text-zinc-400 mb-2">Despesa Mês Anterior</label>
                    <input type="number" name="despesa_anterior" value="0" step="0.01"
                           class="w-full bg-[#0a0a0c] border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#eab308] transition-all duration-300">
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="fecharModalDiario()" class="px-5 py-3 rounded-xl border border-white/10 text-zinc-300 hover:bg-white/5 transition-all duration-300">Cancelar</button>
                <button type="submit" class="px-5 py-3 rounded-xl bg-[#eab308] hover:bg-[#d4a007] text-black font-bold transition-all duration-300 shadow-lg hover:scale-[1.02]">✅ Criar Diário</button>
            </div>
        </form>
    </div>
</div>

{{-- ==================== TOAST ==================== --}}
@if(session('success'))
<div id="toast" class="fixed top-5 right-5 bg-green-500/95 text-white px-5 py-4 rounded-2xl shadow-2xl z-50 animate-fadeUp flex items-center gap-3">
    <span class="text-xl">✅</span> {{ session('success') }}
</div>
@endif

@if(session('error'))
<div id="toast" class="fixed top-5 right-5 bg-red-500/95 text-white px-5 py-4 rounded-2xl shadow-2xl z-50 animate-fadeUp flex items-center gap-3">
    <span class="text-xl">⚠️</span> {{ session('error') }}
</div>
@endif

{{-- ==================== SCRIPTS ==================== --}}
<script>
// Modais
function abrirModalTransacao() {
    document.getElementById('modalTransacao').classList.remove('hidden');
    document.getElementById('modalTransacao').classList.add('flex');
}
function fecharModalTransacao() {
    document.getElementById('modalTransacao').classList.add('hidden');
    document.getElementById('modalTransacao').classList.remove('flex');
}
function abrirModalDiario() {
    document.getElementById('modalDiario').classList.remove('hidden');
    document.getElementById('modalDiario').classList.add('flex');
}
function fecharModalDiario() {
    document.getElementById('modalDiario').classList.add('hidden');
    document.getElementById('modalDiario').classList.remove('flex');
}

// Fechar modais ao clicar fora
document.addEventListener('click', function(e) {
    if (e.target.id === 'modalTransacao') fecharModalTransacao();
    if (e.target.id === 'modalDiario') fecharModalDiario();
});

// Fechar com ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        fecharModalTransacao();
        fecharModalDiario();
    }
});

// Toast
setTimeout(() => {
    const toast = document.getElementById('toast');
    if (toast) {
        toast.style.opacity = '0';
        toast.style.transition = 'opacity 0.5s';
        setTimeout(() => toast?.remove(), 500);
    }
}, 4000);

// Excluir transação
async function excluirTransacao(id) {
    if (!confirm('Tem certeza que deseja excluir esta transação?')) return;
    
    try {
        const response = await fetch(`/diario-caixa/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        });
        
        if (response.ok) {
            location.reload();
        } else {
            alert('Erro ao excluir transação.');
        }
    } catch (error) {
        alert('Erro: ' + error.message);
    }
}
</script>
@endsection