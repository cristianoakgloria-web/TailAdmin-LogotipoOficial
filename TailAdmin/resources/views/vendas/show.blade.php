@extends('layouts.app')

@section('title', 'Detalhes da Campanha')
@section('header', 'Marketing')
@section('subheader', 'Visualizar informações da campanha')

@section('content')
<div class="max-w-4xl mx-auto animate-fadeUp">
    <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl overflow-hidden">
        <div class="flex items-center justify-between p-6 border-b border-[#eab308]/20">
            <div class="flex items-center gap-3">
                <a href="{{ route('vendas.index') }}" class="text-gray-400 hover:text-[#eab308] transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h2 class="text-xl font-bold text-white">Detalhes da Campanha</h2>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('vendas.edit', $servico->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 rounded-lg text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Editar
                </a>
            </div>
        </div>

        <div class="p-6 space-y-6">
            <!-- Status Badge -->
            <div class="flex justify-between items-start">
                <div>
                    <span class="inline-flex px-3 py-1 text-sm rounded-full
                        @if($servico->status == 'proposta') bg-blue-500/20 text-blue-400
                        @elseif($servico->status == 'negociacao') bg-purple-500/20 text-purple-400
                        @elseif($servico->status == 'contratado') bg-green-500/20 text-green-400
                        @elseif($servico->status == 'em_andamento') bg-yellow-500/20 text-yellow-400
                        @elseif($servico->status == 'concluido') bg-emerald-500/20 text-emerald-400
                        @elseif($servico->status == 'cancelado') bg-red-500/20 text-red-400
                        @endif">
                        @if($servico->status == 'proposta') Proposta
                        @elseif($servico->status == 'negociacao') Negociação
                        @elseif($servico->status == 'contratado') Contratado
                        @elseif($servico->status == 'em_andamento') Em Andamento
                        @elseif($servico->status == 'concluido') Concluído
                        @elseif($servico->status == 'cancelado') Cancelado
                        @endif
                    </span>
                </div>
                <div class="text-right">
                    <p class="text-xs text-zinc-500">Criado em</p>
                    <p class="text-sm text-gray-300">{{ $servico->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            <!-- Informações principais -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider">ID da Campanha</label>
                    <p class="mt-1 text-gray-300">#{{ $servico->id }}</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider">Cliente</label>
                    <p class="mt-1 text-gray-300">
                        <a href="{{ route('vendas.cliente.perfil', $servico->cliente_id) }}" class="text-[#eab308] hover:underline">
                            {{ $servico->cliente->nome }}
                        </a>
                    </p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider">Campanha</label>
                    <p class="mt-1 text-gray-300 font-medium">{{ $servico->titulo }}</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider">Valor</label>
                    <p class="mt-1 text-2xl font-bold text-[#eab308]">
                        {{ $servico->valor ? 'Kz ' . number_format($servico->valor, 2) : '—' }}
                    </p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider">Data Prevista</label>
                    <p class="mt-1 text-gray-300">{{ $servico->data_prevista ? $servico->data_prevista->format('d/m/Y') : '—' }}</p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider">Responsável</label>
                    <p class="mt-1 text-gray-300">{{ $servico->responsavel->name ?? '—' }}</p>
                </div>
            </div>

            <!-- Datas de execução -->
            @if($servico->data_inicio || $servico->data_fim)
            <div class="border-t border-[#eab308]/20 pt-4">
                <h3 class="text-md font-semibold text-white mb-3">Cronograma de Execução</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-zinc-500">Data de Início</label>
                        <p class="mt-1 text-gray-300">{{ $servico->data_inicio ? $servico->data_inicio->format('d/m/Y') : '—' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-zinc-500">Data de Término</label>
                        <p class="mt-1 text-gray-300">{{ $servico->data_fim ? $servico->data_fim->format('d/m/Y') : '—' }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Descrição -->
            <div class="border-t border-[#eab308]/20 pt-4">
                <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider">Descrição da Campanha</label>
                <div class="mt-2 text-gray-300 whitespace-pre-wrap">
                    {{ $servico->descricao ?: '—' }}
                </div>
            </div>

            <!-- Observações -->
            @if($servico->observacoes)
            <div class="border-t border-[#eab308]/20 pt-4">
                <label class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider">Observações Internas</label>
                <div class="mt-2 text-gray-400 text-sm italic">
                    {{ $servico->observacoes }}
                </div>
            </div>
            @endif
        </div>

        <!-- Botões de Ação -->
        <div class="flex justify-between items-center p-6 border-t border-[#eab308]/20 bg-[#0a0a0c]">
            <div class="flex gap-2">
                @if(in_array($servico->status, ['proposta', 'negociacao']))
                    <form action="{{ route('vendas.converterPedido', $servico->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" onclick="return confirm('Confirmar a contratação deste serviço?')" 
                                class="px-4 py-2 bg-green-500/10 hover:bg-green-500/20 text-green-400 rounded-lg text-sm font-medium inline-flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Converter para Contratado
                        </button>
                    </form>
                @endif
                
                <a href="{{ route('vendas.gerarProposta', $servico->id) }}" 
                   class="px-4 py-2 bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 rounded-lg text-sm font-medium inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Gerar Proposta (PDF)
                </a>
            </div>
            
            <form action="{{ route('vendas.destroy', $servico->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta campanha?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-500/10 hover:bg-red-500/20 text-red-400 rounded-lg text-sm font-medium inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Excluir Campanha
                </button>
            </form>
        </div>
    </div>
</div>
@endsection