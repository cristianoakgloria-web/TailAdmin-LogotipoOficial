@extends('layouts.app')

@section('title', 'Nova Campanha')
@section('header', 'Marketing')
@section('subheader', 'Adicionar nova campanha ou serviço')

@section('content')
<div class="max-w-3xl mx-auto animate-fadeUp">
    <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-6">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('vendas.index') }}" class="text-gray-400 hover:text-[#eab308] transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h2 class="text-xl font-bold text-white">Nova Campanha / Serviço</h2>
        </div>

        <form method="POST" action="{{ route('vendas.store') }}" class="space-y-5">
            @csrf

            <div>
                <x-input-label for="cliente_id" :value="__('Cliente')" required />
                <select name="cliente_id" id="cliente_id" required 
                    class="mt-1 block w-full rounded-lg border border-[#eab308]/20 bg-black text-gray-300 focus:border-[#eab308] focus:ring-[#eab308] p-3">
                    <option value="">Selecione um cliente</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                            {{ $cliente->nome }} (NIF: {{ $cliente->nif }})
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('cliente_id')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="titulo" :value="__('Título da Campanha')" required />
                <x-text-input id="titulo" type="text" name="titulo" :value="old('titulo')" 
                    placeholder="Ex: Campanha Instagram, Consultoria SEO, Gestão de Redes Sociais, Branding, Marketing Digital" required />
                <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="descricao" :value="__('Descrição detalhada')" />
                <textarea id="descricao" name="descricao" rows="4" 
                    class="mt-1 block w-full rounded-lg border border-[#eab308]/20 bg-black text-gray-300 focus:border-[#eab308] focus:ring-[#eab308] p-3"
                    placeholder="Descreva o escopo da campanha, entregáveis, prazos, métricas, etc.">{{ old('descricao') }}</textarea>
                <x-input-error :messages="$errors->get('descricao')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <x-input-label for="valor" :value="__('Valor (Kz)')" />
                    <x-text-input id="valor" type="number" step="0.01" name="valor" :value="old('valor')" 
                        placeholder="0.00" />
                    <p class="text-xs text-gray-500 mt-1">Valor em Kwanzas (Kz)</p>
                    <x-input-error :messages="$errors->get('valor')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="data_prevista" :value="__('Data prevista')" />
                    <x-text-input id="data_prevista" type="date" name="data_prevista" :value="old('data_prevista')" />
                    <p class="text-xs text-gray-500 mt-1">Previsão de entrega ou fecho</p>
                    <x-input-error :messages="$errors->get('data_prevista')" class="mt-2" />
                </div>
            </div>

            <div>
                <x-input-label for="status" :value="__('Status inicial')" />
                <select name="status" id="status" 
                    class="mt-1 block w-full rounded-lg border border-[#eab308]/20 bg-black text-gray-300 focus:border-[#eab308] focus:ring-[#eab308] p-3">
                    <option value="proposta" {{ old('status') == 'proposta' ? 'selected' : '' }}>Proposta</option>
                    <option value="negociacao" {{ old('status') == 'negociacao' ? 'selected' : '' }}>Negociação</option>
                    <option value="contratado" {{ old('status') == 'contratado' ? 'selected' : '' }}>Contratado</option>
                </select>
                <p class="text-xs text-gray-500 mt-1">Normalmente comece com "Proposta" ou "Negociação"</p>
                <x-input-error :messages="$errors->get('status')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="observacoes" :value="__('Observações internas')" />
                <textarea id="observacoes" name="observacoes" rows="2" 
                    class="mt-1 block w-full rounded-lg border border-[#eab308]/20 bg-black text-gray-300 focus:border-[#eab308] focus:ring-[#eab308] p-3"
                    placeholder="Notas internas para a equipa...">{{ old('observacoes') }}</textarea>
                <x-input-error :messages="$errors->get('observacoes')" class="mt-2" />
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('vendas.index') }}" 
                    class="px-4 py-2 bg-zinc-800 hover:bg-zinc-700 text-gray-300 rounded-lg transition">
                    Cancelar
                </a>
                <button type="submit" 
                    class="px-6 py-2 bg-[#eab308] hover:bg-[#d4a007] text-black font-bold rounded-lg transition">
                    Criar Campanha
                </button>
            </div>
        </form>
    </div>
</div>
@endsection