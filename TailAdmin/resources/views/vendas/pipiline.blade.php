@extends('layouts.app')

@section('title', 'Pipeline de Marketing')
@section('header', 'Marketing')
@section('subheader', 'Funil de oportunidades - Kanban')

@section('content')
<div class="space-y-6 animate-fadeUp">
    @if(session('success'))
        <div class="p-4 rounded-xl bg-[#eab308]/10 border border-[#eab308]/40 text-[#eab308] text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-white">Pipeline de Marketing</h2>
            <p class="text-sm text-zinc-500 mt-1">Acompanhe o funil de vendas das campanhas</p>
        </div>
        <div>
            <button onclick="document.getElementById('modalNovaOportunidade').classList.remove('hidden')" 
                    class="inline-flex items-center gap-2 px-4 py-2 bg-[#eab308] hover:bg-[#d4a007] text-black font-bold rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nova Oportunidade
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 overflow-x-auto pb-4">
        @foreach($statusLabels as $key => $label)
        <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-lg min-w-[280px]">
            <div class="p-3 border-b border-[#eab308]/20 bg-[#0a0a0c] rounded-t-lg">
                <h3 class="font-bold text-white">{{ $label }}</h3>
                <span class="text-xs text-zinc-500">{{ isset($servicos[$key]) ? count($servicos[$key]) : 0 }} oportunidades</span>
            </div>
            <div class="p-3 space-y-3 min-h-[400px] max-h-[600px] overflow-y-auto">
                @foreach($servicos[$key] ?? [] as $servico)
                <div class="bg-[#1a1a1c] rounded-lg p-3 border border-[#eab308]/10 hover:border-[#eab308]/30 transition">
                    <div class="flex justify-between items-start mb-2">
                        <h4 class="text-white font-medium text-sm">{{ $servico->titulo }}</h4>
                        <span class="text-xs px-2 py-1 rounded bg-[#eab308]/10 text-[#eab308]">
                            Kz {{ number_format($servico->valor, 2) }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-400 mb-2">{{ $servico->cliente->nome }}</p>
                    @if($servico->data_prevista)
                    <p class="text-xs text-gray-500 mb-3">📅 {{ $servico->data_prevista->format('d/m/Y') }}</p>
                    @endif
                    <form action="{{ route('vendas.updateStatus', $servico->id) }}" method="POST" class="mt-2">
                        @csrf
                        @method('PATCH')
                        <select name="status" onchange="this.form.submit()" 
                                class="w-full text-xs bg-black border border-gray-600 rounded-lg p-1.5 text-gray-300 focus:border-[#eab308] focus:ring-[#eab308]">
                            @foreach($statusLabels as $k => $lbl)
                            <option value="{{ $k }}" {{ $servico->status == $k ? 'selected' : '' }}>{{ $lbl }}</option>
                            @endforeach
                        </select>
                    </form>
                    <div class="mt-2 flex justify-end">
                        <a href="{{ route('vendas.show', $servico->id) }}" class="text-xs text-blue-400 hover:text-blue-300">Ver detalhes →</a>
                    </div>
                </div>
                @endforeach
                
                @if(!isset($servicos[$key]) || count($servicos[$key]) == 0)
                <div class="text-center text-gray-500 text-sm py-8">
                    <svg class="w-8 h-8 mx-auto mb-2 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    Sem oportunidades
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal Nova Oportunidade -->
<div id="modalNovaOportunidade" class="hidden fixed inset-0 bg-black/70 flex items-center justify-center z-50 animate-fadeUp">
    <div class="bg-[#0c0c0e] rounded-xl w-full max-w-md border border-[#eab308]/20 shadow-2xl">
        <div class="flex justify-between items-center p-4 border-b border-[#eab308]/20">
            <h3 class="text-lg font-bold text-white">Nova Oportunidade</h3>
            <button onclick="document.getElementById('modalNovaOportunidade').classList.add('hidden')" 
                    class="text-gray-400 hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form action="{{ route('vendas.store') }}" method="POST" class="p-4 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Cliente *</label>
                <select name="cliente_id" required class="w-full rounded-lg border border-[#eab308]/20 bg-black text-gray-300 focus:border-[#eab308] focus:ring-[#eab308] p-2">
                    <option value="">Selecione</option>
                    @foreach(\App\Models\Cliente::orderBy('nome')->get() as $c)
                    <option value="{{ $c->id }}">{{ $c->nome }} (NIF: {{ $c->nif }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Título da Campanha *</label>
                <input type="text" name="titulo" required class="w-full rounded-lg border border-[#eab308]/20 bg-black text-gray-300 focus:border-[#eab308] focus:ring-[#eab308] p-2" placeholder="Ex: Campanha Redes Sociais">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Descrição</label>
                <textarea name="descricao" rows="3" class="w-full rounded-lg border border-[#eab308]/20 bg-black text-gray-300 focus:border-[#eab308] focus:ring-[#eab308] p-2" placeholder="Escopo da campanha..."></textarea>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Valor (Kz)</label>
                    <input type="number" step="0.01" name="valor" class="w-full rounded-lg border border-[#eab308]/20 bg-black text-gray-300 focus:border-[#eab308] focus:ring-[#eab308] p-2" placeholder="0.00">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Data prevista</label>
                    <input type="date" name="data_prevista" class="w-full rounded-lg border border-[#eab308]/20 bg-black text-gray-300 focus:border-[#eab308] focus:ring-[#eab308] p-2">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Status inicial</label>
                <select name="status" class="w-full rounded-lg border border-[#eab308]/20 bg-black text-gray-300 focus:border-[#eab308] focus:ring-[#eab308] p-2">
                    <option value="proposta">Proposta</option>
                    <option value="negociacao">Negociação</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Observações internas</label>
                <textarea name="observacoes" rows="2" class="w-full rounded-lg border border-[#eab308]/20 bg-black text-gray-300 focus:border-[#eab308] focus:ring-[#eab308] p-2" placeholder="Notas para a equipa..."></textarea>
            </div>
            <div class="flex justify-end gap-2 pt-4">
                <button type="button" onclick="document.getElementById('modalNovaOportunidade').classList.add('hidden')" 
                        class="px-4 py-2 bg-zinc-800 hover:bg-zinc-700 text-gray-300 rounded-lg transition">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-[#eab308] hover:bg-[#d4a007] text-black font-bold rounded-lg transition">
                    Criar Oportunidade
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            document.getElementById('modalNovaOportunidade').classList.add('hidden');
        }
    });
</script>
@endpush
@endsection