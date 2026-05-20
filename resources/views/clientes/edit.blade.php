@extends('layouts.app')

@section('title', 'Editar Cliente')
@section('header', 'Clientes')
@section('subheader', 'Editar informações do cliente')

@section('content')
<div class="max-w-3xl mx-auto animate-fadeUp">
    <div class="bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl p-6">
        <div class="flex items-center gap-3 mb-6">
            <a href="{{ route('clientes.index') }}" class="text-gray-400 hover:text-[#eab308] transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
            <h2 class="text-xl font-bold text-white">Editar Cliente</h2>
        </div>

        <form method="POST" action="{{ route('clientes.update', $cliente->id) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <x-input-label for="nome" :value="__('Nome completo')" required />
                <x-text-input id="nome" type="text" name="nome" :value="old('nome', $cliente->nome)" required />
                <x-input-error :messages="$errors->get('nome')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="bi" :value="__('BI (Cartão de Identidade)')" />
                <x-text-input id="bi" type="text" name="bi" :value="old('bi', $cliente->bi)" />
                <x-input-error :messages="$errors->get('bi')" class="mt-2" />

            <div>
                <x-input-label for="nif" :value="__('NIF')" required />
                <x-text-input id="nif" type="text" name="nif" :value="old('nif', $cliente->nif)" required />
                <x-input-error :messages="$errors->get('nif')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="email" :value="__('E-mail')" />
                <x-text-input id="email" type="email" name="email" :value="old('email', $cliente->email)" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="telefone" :value="__('Telefone')" />
                <x-text-input id="telefone" type="text" name="telefone" :value="old('telefone', $cliente->telefone)" />
                <x-input-error :messages="$errors->get('telefone')" class="mt-2" />
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('clientes.index') }}" class="px-4 py-2 bg-zinc-800 hover:bg-zinc-700 text-gray-300 rounded-lg transition">Cancelar</a>
                <button type="submit" class="px-6 py-2 bg-[#eab308] hover:bg-[#d4a007] text-black font-bold rounded-lg transition">Actualizar Cliente</button>
            </div>
        </form>
    </div>
</div>
@endsection