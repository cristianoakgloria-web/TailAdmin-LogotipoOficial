@extends('layouts.app')

@section('title', 'Detalhes do Cliente')
@section('header', 'Clientes')
@section('subheader', 'Visualizar informações do cliente')

@section('content')
<div class="max-w-4xl mx-auto animate-fadeUp">
    <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl overflow-hidden">
        <div class="flex items-center justify-between p-6 border-b border-[#eab308]/20">
            <div class="flex items-center gap-3">
                <a href="{{ route('clientes.index') }}" class="text-gray-400 hover:text-[#eab308] transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
                <h2 class="text-xl font-bold text-white">Detalhes do Cliente</h2>
            </div>
            <a href="{{ route('clientes.edit', $cliente->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 rounded-lg text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Editar
            </a>
        </div>

        <div class="p-6 space-y-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div><label class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider">ID</label><p class="mt-1 text-gray-300">{{ $cliente->id }}</p></div>
                <div><label class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider">Nome completo</label><p class="mt-1 text-gray-300">{{ $cliente->nome }}</p></div>
                <div><label class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider">BI (Cartão de Identidade)</label><p class="mt-1 text-gray-300">{{ $cliente->bi ?? '—' }}</p></div>
                <div><label class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider">NIF</label><p class="mt-1 text-gray-300">{{ $cliente->nif }}</p></div>
                <div><label class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider">E-mail</label><p class="mt-1 text-gray-300">{{ $cliente->email ?? '—' }}</p></div>
                <div><label class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider">Telefone</label><p class="mt-1 text-gray-300">{{ $cliente->telefone ?? '—' }}</p></div>
                <div><label class="block text-xs font-semibold text-zinc-500 uppercase tracking-wider">Data de cadastro</label><p class="mt-1 text-gray-300">{{ $cliente->created_at ? $cliente->created_at->format('d/m/Y H:i') : '—' }}</p></div>
            </div>

            <!-- ========================================== -->
            <!-- SECÇÃO DE CAMPANHAS / SERVIÇOS DO CLIENTE   -->
            <!-- ========================================== -->
            <div class="border-t border-[#eab308]/20 pt-5 mt-2">
                <h3 class="text-md font-semibold text-white mb-3 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#eab308]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Campanhas / Serviços
                </h3>

                @if($cliente->servicos && $cliente->servicos->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-[#0a0a0c] border-b border-[#eab308]/20">
                                <tr>
                                    <th class="text-left py-2 px-3 text-xs font-semibold text-zinc-500">Título</th>
                                    <th class="text-left py-2 px-3 text-xs font-semibold text-zinc-500">Valor (Kz)</th>
                                    <th class="text-left py-2 px-3 text-xs font-semibold text-zinc-500">Status</th>
                                    <th class="text-left py-2 px-3 text-xs font-semibold text-zinc-500">Data Prevista</th>
                                    <th class="text-left py-2 px-3 text-xs font-semibold text-zinc-500">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cliente->servicos as $servico)
                                <tr class="border-b border-[#eab308]/10 hover:bg-[#eab308]/5">
                                    <td class="py-2 px-3 text-gray-300">{{ $servico->titulo }}</td>
                                    <td class="py-2 px-3 text-gray-300">{{ $servico->valor ? 'Kz ' . number_format($servico->valor, 2) : '—' }}</td>
                                    <td class="py-2 px-3">
                                        <span class="inline-flex px-2 py-0.5 text-xs rounded-full
                                            @if($servico->status == 'proposta') bg-blue-500/20 text-blue-400
                                            @elseif($servico->status == 'negociacao') bg-purple-500/20 text-purple-400
                                            @elseif($servico->status == 'contratado') bg-green-500/20 text-green-400
                                            @elseif($servico->status == 'em_andamento') bg-yellow-500/20 text-yellow-400
                                            @elseif($servico->status == 'concluido') bg-emerald-500/20 text-emerald-400
                                            @else bg-red-500/20 text-red-400
                                            @endif">
                                            {{ ucfirst($servico->status) }}
                                        </span>
                                    </td>
                                    <td class="py-2 px-3 text-gray-300">{{ $servico->data_prevista ? $servico->data_prevista->format('d/m/Y') : '—' }}</td>
                                    <td class="py-2 px-3">
                                        <a href="{{ route('vendas.show', $servico->id) }}" class="text-green-400 hover:text-green-300 text-sm">Ver detalhes →</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-6 bg-[#0a0a0c] rounded-lg">
                        <p class="text-gray-500 text-sm">Nenhuma campanha ou serviço associado a este cliente.</p>
                        <a href="{{ route('vendas.create') }}?cliente_id={{ $cliente->id }}" class="inline-block mt-2 text-sm text-[#eab308] hover:underline">
                            + Criar primeira campanha
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="flex justify-end p-6 border-t border-[#eab308]/20 bg-[#0a0a0c]">
            <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este cliente?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-500/10 hover:bg-red-500/20 text-red-400 rounded-lg text-sm font-medium flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Excluir Cliente
                </button>
            </form>
        </div>
    </div>
</div>
@endsection