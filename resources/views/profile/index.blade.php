{{-- Mostrar perfil do usuário (sem roles, sem exclusão) --}}
@extends('layouts.app')

@section('title', 'Perfil')
@section('header', 'Perfil do Usuário')
@section('subheader', 'Gerencie suas informações pessoais')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Card Principal do Perfil --}}
    <div class="bg-zinc-900/50 backdrop-blur-sm rounded-2xl border border-zinc-800 overflow-hidden">
        
        {{-- Cabeçalho com Avatar --}}
        <div class="relative h-32 bg-gradient-to-r from-[#eab308]/20 to-[#eab308]/5">
            <div class="absolute -bottom-12 left-6">
                <div class="relative">
                    @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" alt="Avatar" 
                             class="w-24 h-24 rounded-2xl border-4 border-zinc-900 object-cover">
                    @else
                        <div class="w-24 h-24 rounded-2xl border-4 border-zinc-900 bg-gradient-to-br from-[#eab308] to-[#ca8a04] 
                                    flex items-center justify-center text-white text-3xl font-bold">
                            {{ strtoupper(substr($user->nome, 0, 2)) }}
                        </div>
                    @endif
                    
                    {{-- Badge de verificação (opcional) --}}
                    @if(isset($user->email_verified_at) && $user->email_verified_at)
                        <div class="absolute -bottom-1 -right-1 bg-green-500 rounded-full p-1">
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Informações do Utilizador --}}
        <div class="pt-14 pb-6 px-6">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-2xl font-bold text-white">{{ $user->nome }}</h2>
                    <p class="text-zinc-400 mt-1">{{ $user->email }}</p>
                    <div class="flex items-center gap-2 mt-1">
                        <p class="text-xs text-zinc-500">
                            Membro desde {{ $user->created_at->format('F Y') }}
                        </p>
                    </div>
                </div>
                
                <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-[#eab308] hover:bg-[#ca8a04] text-black font-semibold rounded-xl transition-all duration-200 transform hover:scale-105">
                    Editar Perfil
                </a>
            </div>
        </div>
    </div>

    {{-- Informações Adicionais --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
        {{-- Dados Pessoais --}}
        <div class="bg-zinc-900/50 backdrop-blur-sm rounded-2xl border border-zinc-800 p-6">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-[#eab308]" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                </svg>
                Informações Pessoais
            </h3>
            
            <div class="space-y-3">
                <div>
                    <label class="text-xs text-zinc-500 uppercase tracking-wider">Nome Completo</label>
                    <p class="text-zinc-300 mt-1">{{ $user->nome ?? 'Não informado' }}</p>
                </div>
                
                <div>
                    <label class="text-xs text-zinc-500 uppercase tracking-wider">Email</label>
                    <p class="text-zinc-300 mt-1">{{ $user->email }}</p>
                </div>
                
                <div>
                    <label class="text-xs text-zinc-500 uppercase tracking-wider">Sexo</label>
                    <p class="text-zinc-300 mt-1">
                        @if($user->sexo == 'M')
                            Masculino
                        @elseif($user->sexo == 'F')
                            Feminino
                        @else
                            Não informado
                        @endif
                    </p>
                </div>
            </div>
        </div>

        {{-- Estatísticas e Atividade --}}
        <div class="bg-zinc-900/50 backdrop-blur-sm rounded-2xl border border-zinc-800 p-6">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-[#eab308]" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"/>
                    <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"/>
                </svg>
                Estatísticas
            </h3>
            
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-zinc-800/50 rounded-xl p-3 text-center">
                    <div class="text-2xl font-bold text-[#eab308]">{{ $user->posts_count ?? 0 }}</div>
                    <div class="text-xs text-zinc-400 mt-1">Publicações</div>
                </div>
                
                <div class="bg-zinc-800/50 rounded-xl p-3 text-center">
                    <div class="text-2xl font-bold text-[#eab308]">{{ $user->comments_count ?? 0 }}</div>
                    <div class="text-xs text-zinc-400 mt-1">Comentários</div>
                </div>
                
                <div class="bg-zinc-800/50 rounded-xl p-3 text-center">
                    <div class="text-2xl font-bold text-[#eab308]">
                        @if($user->last_login_at)
                            {{ \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() }}
                        @else
                            Nunca
                        @endif
                    </div>
                    <div class="text-xs text-zinc-400 mt-1">Último Acesso</div>
                </div>
                
                <div class="bg-zinc-800/50 rounded-xl p-3 text-center">
                    <div class="text-2xl font-bold text-[#eab308]">{{ $user->total_views ?? 0 }}</div>
                    <div class="text-xs text-zinc-400 mt-1">Total Visualizações</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Últimas Atividades (opcional) --}}
    <div class="bg-zinc-900/50 backdrop-blur-sm rounded-2xl border border-zinc-800 p-6 mt-6">
        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-[#eab308]" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
            </svg>
            Últimas Atividades
        </h3>
        
        @if(isset($user->recentActivities) && $user->recentActivities && $user->recentActivities->count())
            <div class="space-y-3">
                @foreach($user->recentActivities as $activity)
                    <div class="flex items-center justify-between py-2 border-b border-zinc-800 last:border-0">
                        <div>
                            <p class="text-zinc-300">{{ $activity->description }}</p>
                            <p class="text-xs text-zinc-500 mt-1">{{ $activity->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="text-xs px-2 py-1 bg-zinc-800 rounded-full text-zinc-400">
                            {{ $activity->type }}
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-zinc-500 text-center py-4">Nenhuma atividade recente</p>
        @endif
    </div>

    {{-- Informações da Conta --}}
    <div class="bg-zinc-900/50 backdrop-blur-sm rounded-2xl border border-zinc-800 p-6 mt-6">
        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-[#eab308]" fill="currentColor" viewBox="0 0 20 20">
                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
            </svg>
            Informações da Conta
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-xs text-zinc-500">Data de Registro</p>
                <p class="text-sm text-zinc-300 mt-1">{{ $user->created_at ? $user->created_at->format('d/m/Y H:i:s') : 'Não disponível' }}</p>
            </div>
            
            <div>
                <p class="text-xs text-zinc-500">Última Atualização</p>
                <p class="text-sm text-zinc-300 mt-1">{{ $user->updated_at ? $user->updated_at->format('d/m/Y H:i:s') : 'Não disponível' }}</p>
            </div>
            
            @if($user->last_login_at)
            <div>
                <p class="text-xs text-zinc-500">Último Login</p>
                <p class="text-sm text-zinc-300 mt-1">{{ \Carbon\Carbon::parse($user->last_login_at)->format('d/m/Y H:i:s') }}</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Botões de Ação (apenas edição, sem exclusão) --}}
    <div class="flex justify-end gap-3 mt-6">
        <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-zinc-800 hover:bg-zinc-700 text-zinc-300 rounded-xl transition-all duration-200">
            Alterar Senha
        </a>
    </div>
</div>
@endsection