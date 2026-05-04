{{-- Mostrar Roles do usuário (múltiplas roles) --}}
@extends('layouts.app')

@section('title', 'Perfil')
@section('header', 'Perfil do Usuário')
@section('subheader', 'Gerencie suas informações pessoais e níveis de acesso')

@section('content')

<div class="mt-4">
    <label class="block text-sm font-semibold text-[#eab308]/80 mb-2 uppercase tracking-wider">
        Níveis de Acesso
    </label>
    <div class="flex flex-wrap gap-2">
        @forelse($user->roles as $role)
            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-[#eab308]/20 text-[#eab308] border border-[#eab308]/30">
                {{ $role->nome }}
            </span>
        @empty
            <span class="px-3 py-1 text-xs font-semibold rounded-full bg-zinc-800 text-zinc-400">
                Sem permissões especiais
            </span>
        @endforelse
    </div>
</div>
@endsection