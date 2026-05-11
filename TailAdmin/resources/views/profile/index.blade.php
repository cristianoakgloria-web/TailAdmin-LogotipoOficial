{{-- Mostrar Roles do usuário (múltiplas roles) --}}
@extends('layouts.app')

@section('title', 'Perfil')
@section('header', 'Perfil do Usuário')
@section('subheader', 'Gerencie suas informações pessoais e níveis de acesso')

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
                    
                    {{-- Badge de verificação (opcional - se não tiver email_verified_at, remover) --}}
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
                        @if($user->cargo)
                            <span class="text-xs px-2 py-0.5 bg-[#eab308]/10 text-[#eab308] rounded-full">
                                {{ $user->cargo }}
                            </span>
                        @endif
                    </div>
                </div>
                
                <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-[#eab308] hover:bg-[#ca8a04] text-black font-semibold rounded-xl transition-all duration-200 transform hover:scale-105">
                    Editar Perfil
                </a>
            </div>
        </div>

        {{-- Roles do Utilizador --}}
        <div class="border-t border-zinc-800 px-6 py-4">
            <label class="block text-sm font-semibold text-[#eab308]/80 mb-3 uppercase tracking-wider">
                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H4v2H2v-3l4-4-1-3.5L4 6l2-2 3.5 1 4-4z" clip-rule="evenodd"/>
                </svg>
                Níveis de Acesso
            </label>
            <div class="flex flex-wrap gap-2">
                @forelse($user->roles as $role)
                    <span class="group relative">
                        <span class="px-3 py-1.5 text-xs font-semibold rounded-full bg-[#eab308]/20 text-[#eab308] 
                                     border border-[#eab308]/30 hover:bg-[#eab308]/30 transition-all duration-200">
                            {{ $role->nome }}
                        </span>
                        @if($role->descricao)
                            <span class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-2 py-1 text-xs 
                                         bg-zinc-800 text-zinc-300 rounded opacity-0 group-hover:opacity-100 
                                         transition-opacity whitespace-nowrap pointer-events-none">
                                {{ $role->descricao }}
                            </span>
                        @endif
                    </span>
                @empty
                    <span class="px-3 py-1.5 text-xs font-semibold rounded-full bg-zinc-800 text-zinc-400">
                        Sem permissões especiais
                    </span>
                @endforelse
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
                
                <div>
                    <label class="text-xs text-zinc-500 uppercase tracking-wider">Cargo</label>
                    <p class="text-zinc-300 mt-1">{{ $user->cargo ?? 'Não informado' }}</p>
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

    {{-- Últimas Atividades --}}
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

    {{-- Botões de Ação --}}
    <div class="flex justify-end gap-3 mt-6">
        <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-zinc-800 hover:bg-zinc-700 text-zinc-300 rounded-xl transition-all duration-200">
            Alterar Senha
        </a>
        <button class="px-4 py-2 bg-red-500/20 hover:bg-red-500/30 text-red-400 rounded-xl transition-all duration-200" onclick="confirmDelete()">
            Desativar Conta
        </button>
    </div>
</div>

{{-- Modal de Confirmação para Deletar Conta --}}
<div id="deleteModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm hidden items-center justify-center z-50">
    <div class="bg-zinc-900 rounded-2xl border border-zinc-800 p-6 max-w-md mx-4">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 bg-red-500/20 rounded-full flex items-center justify-center">
                <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-white">Desativar Conta</h3>
        </div>
        <p class="text-zinc-400 mb-6">
            Tem certeza que deseja desativar sua conta? Esta ação pode ser revertida posteriormente.
        </p>
        <div class="flex gap-3 justify-end">
            <button onclick="closeDeleteModal()" class="px-4 py-2 bg-zinc-800 hover:bg-zinc-700 text-zinc-300 rounded-xl transition-all duration-200">
                Cancelar
            </button>
            <form action="{{ route('profile.destroy') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-xl transition-all duration-200">
                    Confirmar
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // JavaScript para funcionalidades interativas do perfil
    document.addEventListener('DOMContentLoaded', function() {
        // Tooltips automáticos para roles
        const roleSpans = document.querySelectorAll('.group');
        roleSpans.forEach(span => {
            span.addEventListener('mouseenter', function() {
                const innerSpan = this.querySelector('span:first-child');
                if(innerSpan) innerSpan.classList.add('scale-105');
            });
            span.addEventListener('mouseleave', function() {
                const innerSpan = this.querySelector('span:first-child');
                if(innerSpan) innerSpan.classList.remove('scale-105');
            });
        });
    });
    
    // Modal functions
    function confirmDelete() {
        const modal = document.getElementById('deleteModal');
        if(modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }
    
    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        if(modal) {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    }
    
    // Close modal on escape key
    document.addEventListener('keydown', function(event) {
        if(event.key === 'Escape') {
            closeDeleteModal();
        }
    });
    
    // Close modal on outside click
    document.getElementById('deleteModal')?.addEventListener('click', function(e) {
        if(e.target === this) {
            closeDeleteModal();
        }
    });
</script>
@endsection