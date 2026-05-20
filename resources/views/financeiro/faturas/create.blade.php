@extends('layouts.app')

@section('title', 'Nova Fatura')
@section('header', 'Financeiro')

@section('content')
<div class="max-w-3xl mx-auto animate-fadeUp">
    <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-6">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('faturas.index') }}" class="text-gray-400 hover:text-[#eab308] transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h2 class="text-xl font-bold text-white">Nova Fatura</h2>
        </div>

        <form method="POST" action="{{ route('faturas.store') }}" class="space-y-5">
            @csrf

            <div>
                <x-input-label for="cliente_id" value="Cliente" required />
                <select name="cliente_id" required class="mt-1 w-full rounded-lg border border-[#eab308]/20 bg-black text-gray-300 p-3 focus:border-[#eab308]">
                    <option value="">Selecione um cliente</option>
                    @foreach($clientes as $c)
                        <option value="{{ $c->id }}" {{ old('cliente_id') == $c->id ? 'selected' : '' }}>{{ $c->nome }} (NIF: {{ $c->nif }})</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('cliente_id')" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <x-input-label for="data_emissao" value="Data de Emissão" required />
                    <input type="date" name="data_emissao" value="{{ old('data_emissao', date('Y-m-d')) }}" required class="mt-1 w-full rounded-lg border border-[#eab308]/20 bg-black text-gray-300 p-3">
                    <x-input-error :messages="$errors->get('data_emissao')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="data_vencimento" value="Data de Vencimento" required />
                    <input type="date" name="data_vencimento" value="{{ old('data_vencimento', date('Y-m-d', strtotime('+15 days'))) }}" required class="mt-1 w-full rounded-lg border border-[#eab308]/20 bg-black text-gray-300 p-3">
                    <x-input-error :messages="$errors->get('data_vencimento')" class="mt-2" />
                </div>
            </div>

            <div>
                <x-input-label for="valor_total" value="Valor Total (Kz)" required />
                <input type="number" step="0.01" name="valor_total" value="{{ old('valor_total') }}" required class="mt-1 w-full rounded-lg border border-[#eab308]/20 bg-black text-gray-300 p-3">
                <x-input-error :messages="$errors->get('valor_total')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="tipo" value="Tipo" />
                <select name="tipo" class="mt-1 w-full rounded-lg border border-[#eab308]/20 bg-black text-gray-300 p-3">
                    <option value="servico">Serviço</option>
                    <option value="consultoria">Consultoria</option>
                    <option value="campanha">Campanha</option>
                    <option value="outro">Outro</option>
                </select>
            </div>

            <div>
                <x-input-label for="descricao" value="Descrição" />
                <textarea name="descricao" rows="3" class="mt-1 w-full rounded-lg border border-[#eab308]/20 bg-black text-gray-300 p-3">{{ old('descricao') }}</textarea>
                <x-input-error :messages="$errors->get('descricao')" class="mt-2" />
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('faturas.index') }}" class="px-4 py-2 bg-zinc-800 hover:bg-zinc-700 rounded-lg text-gray-300">Cancelar</a>
                <button type="submit" class="px-6 py-2 bg-[#eab308] hover:bg-[#d4a007] text-black font-bold rounded-lg">Criar Fatura</button>
            </div>
        </form>
    </div>
</div>
@endsection