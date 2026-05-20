@extends('layouts.app')

@section('title', 'Campanhas / Serviços')
@section('header', 'Marketing')
@section('subheader', 'Gestão de campanhas e serviços de marketing')

@section('content')
<div class="space-y-6 animate-fadeUp">
    @if(session('success'))
        <div class="p-4 rounded-xl bg-[#eab308]/10 border border-[#eab308]/40 text-[#eab308] text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 rounded-xl bg-red-500/10 border border-red-500/40 text-red-400 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-white">Campanhas & Serviços</h2>
            <p class="text-sm text-zinc-500 mt-1">Gerencie todas as campanhas, consultorias e projetos</p>
        </div>
        <div>
            <a href="{{ route('vendas.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-[#eab308] hover:bg-[#d4a007] text-black font-bold rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nova Campanha
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-4">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('vendas.index') }}" 
               class="px-3 py-1 rounded-lg text-sm {{ $status == 'todos' ? 'bg-[#eab308] text-black' : 'bg-zinc-800 text-gray-300 hover:bg-zinc-700' }} transition">
                Todos
            </a>
            <a href="{{ route('vendas.index', ['status' => 'proposta']) }}" 
               class="px-3 py-1 rounded-lg text-sm {{ $status == 'proposta' ? 'bg-[#eab308] text-black' : 'bg-zinc-800 text-gray-300 hover:bg-zinc-700' }} transition">
                Propostas
            </a>
            <a href="{{ route('vendas.index', ['status' => 'negociacao']) }}" 
               class="px-3 py-1 rounded-lg text-sm {{ $status == 'negociacao' ? 'bg-[#eab308] text-black' : 'bg-zinc-800 text-gray-300 hover:bg-zinc-700' }} transition">
                Negociações
            </a>
            <a href="{{ route('vendas.index', ['status' => 'contratado']) }}" 
               class="px-3 py-1 rounded-lg text-sm {{ $status == 'contratado' ? 'bg-[#eab308] text-black' : 'bg-zinc-800 text-gray-300 hover:bg-zinc-700' }} transition">
                Contratados
            </a>
            <a href="{{ route('vendas.index', ['status' => 'em_andamento']) }}" 
               class="px-3 py-1 rounded-lg text-sm {{ $status == 'em_andamento' ? 'bg-[#eab308] text-black' : 'bg-zinc-800 text-gray-300 hover:bg-zinc-700' }} transition">
                Em Andamento
            </a>
            <a href="{{ route('vendas.index', ['status' => 'concluido']) }}" 
               class="px-3 py-1 rounded-lg text-sm {{ $status == 'concluido' ? 'bg-[#eab308] text-black' : 'bg-zinc-800 text-gray-300 hover:bg-zinc-700' }} transition">
                Concluídos
            </a>
            <a href="{{ route('vendas.index', ['status' => 'cancelado']) }}" 
               class="px-3 py-1 rounded-lg text-sm {{ $status == 'cancelado' ? 'bg-[#eab308] text-black' : 'bg-zinc-800 text-gray-300 hover:bg-zinc-700' }} transition">
                Cancelados
            </a>
        </div>
    </div>

    <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#0a0a0c] border-b border-[#eab308]/20">
                    <tr>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-zinc-500 uppercase tracking-wider">ID</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Cliente</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Campanha</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Valor (Kz)</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Status</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Data Prevista</th>
                        <th class="text-left py-3 px-4 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($servicos as $servico)
                        <tr class="border-b border-[#eab308]/10 hover:bg-[#eab308]/5 transition">
                            <td class="py-3 px-4 text-sm text-gray-300">{{ $servico->id }}</td>
                            <td class="py-3 px-4 text-sm text-gray-300">{{ $servico->cliente->nome }}</td>
                            <td class="py-3 px-4 text-sm text-gray-300">{{ $servico->titulo }}</td>
                            <td class="py-3 px-4 text-sm text-gray-300">
                                {{ $servico->valor ? 'Kz ' . number_format($servico->valor, 2) : '—' }}
                            </td>
                            <td class="py-3 px-4">
                                <span class="inline-flex px-2 py-1 text-xs rounded-full
                                    @if($servico->status == 'proposta') bg-blue-500/20 text-blue-400
                                    @elseif($servico->status == 'negociacao') bg-purple-500/20 text-purple-400
                                    @elseif($servico->status == 'contratado') bg-green-500/20 text-green-400
                                    @elseif($servico->status == 'em_andamento') bg-yellow-500/20 text-yellow-400
                                    @elseif($servico->status == 'concluido') bg-emerald-500/20 text-emerald-400
                                    @elseif($servico->status == 'cancelado') bg-red-500/20 text-red-400
                                    @endif">
                                    {{ ucfirst($servico->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-300">
                                {{ $servico->data_prevista ? $servico->data_prevista->format('d/m/Y') : '—' }}
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('vendas.show', $servico->id) }}" 
                                       class="inline-flex items-center gap-1 px-3 py-1.5 bg-green-500/10 hover:bg-green-500/20 text-green-400 rounded-lg text-sm font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Ver
                                    </a>
                                    <a href="{{ route('vendas.edit', $servico->id) }}" 
                                       class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 rounded-lg text-sm font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Editar
                                    </a>
                                    <form action="{{ route('vendas.destroy', $servico->id) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta campanha?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-500/10 hover:bg-red-500/20 text-red-400 rounded-lg text-sm font-medium">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Excluir
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <svg class="w-16 h-16 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <p class="text-gray-400">Nenhuma campanha encontrada</p>
                                    <a href="{{ route('vendas.create') }}" class="mt-2 inline-flex items-center gap-2 px-4 py-2 bg-[#eab308] hover:bg-[#d4a007] text-black font-bold rounded-lg transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Criar primeira campanha
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if(isset($servicos) && method_exists($servicos, 'links'))
        <div class="mt-4">
            {{ $servicos->links() }}
        </div>
    @endif
</div>
@endsection