{{-- Edit Profile Page (sem cargo, sem exclusão) --}}
@extends('layouts.app')

@section('title', 'Editar Perfil')
@section('header', 'Editar Perfil')
@section('subheader', 'Atualize suas informações pessoais')

@section('content')
<div class="max-w-4xl mx-auto">
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Mensagens de Feedback --}}
        @if(session('success'))
            <div class="bg-green-500/20 border border-green-500/50 text-green-400 rounded-xl p-4 mb-6 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif 

        @if($errors->any())
            <div class="bg-red-500/20 border border-red-500/50 text-red-400 rounded-xl p-4 mb-6">
                <div class="font-semibold mb-2">Por favor, corrija os seguintes erros:</div>
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Informações Pessoais --}}
        <div class="bg-zinc-900/50 backdrop-blur-sm rounded-2xl border border-zinc-800 p-6">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-[#eab308]" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                </svg>
                Informações Pessoais
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nome" class="block text-sm font-medium text-zinc-300 mb-2">
                        Nome Completo <span class="text-red-400">*</span>
                    </label>
                    <input type="text" 
                           name="nome" 
                           id="nome" 
                           value="{{ old('nome', $user->nome) }}"
                           class="w-full bg-zinc-800/50 border border-zinc-700 rounded-xl px-4 py-2.5 text-white 
                                  focus:outline-none focus:border-[#eab308] focus:ring-1 focus:ring-[#eab308] 
                                  transition-all duration-200 @error('nome') border-red-500 @enderror"
                           required>
                    @error('nome')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-zinc-300 mb-2">
                        Email <span class="text-red-400">*</span>
                    </label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           value="{{ old('email', $user->email) }}"
                           class="w-full bg-zinc-800/50 border border-zinc-700 rounded-xl px-4 py-2.5 text-white 
                                  focus:outline-none focus:border-[#eab308] focus:ring-1 focus:ring-[#eab308] 
                                  transition-all duration-200 @error('email') border-red-500 @enderror"
                           required>
                    @error('email')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="sexo" class="block text-sm font-medium text-zinc-300 mb-2">
                        Sexo
                    </label>
                    <select name="sexo" 
                            id="sexo" 
                            class="w-full bg-zinc-800/50 border border-zinc-700 rounded-xl px-4 py-2.5 text-white 
                                   focus:outline-none focus:border-[#eab308] focus:ring-1 focus:ring-[#eab308] 
                                   transition-all duration-200">
                        <option value="M" {{ old('sexo', $user->sexo) == 'M' ? 'selected' : '' }}>Masculino</option>
                        <option value="F" {{ old('sexo', $user->sexo) == 'F' ? 'selected' : '' }}>Feminino</option>
                    </select>
                    @error('sexo')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Informações de Acesso (Senha) --}}
        <div class="bg-zinc-900/50 backdrop-blur-sm rounded-2xl border border-zinc-800 p-6">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-[#eab308]" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H4v2H2v-3l4-4-1-3.5L4 6l2-2 3.5 1 4-4z" clip-rule="evenodd"/>
                </svg>
                Segurança e Acesso
            </h3>
            
            <div class="space-y-4">
                <div>
                    <label for="current_password" class="block text-sm font-medium text-zinc-300 mb-2">
                        Senha Atual
                    </label>
                    <input type="password" 
                           name="current_password" 
                           id="current_password" 
                           class="w-full bg-zinc-800/50 border border-zinc-700 rounded-xl px-4 py-2.5 text-white 
                                  focus:outline-none focus:border-[#eab308] focus:ring-1 focus:ring-[#eab308] 
                                  transition-all duration-200"
                           placeholder="Digite sua senha atual para alterar">
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-zinc-300 mb-2">
                        Nova Senha
                    </label>
                    <input type="password" 
                           name="password" 
                           id="password" 
                           class="w-full bg-zinc-800/50 border border-zinc-700 rounded-xl px-4 py-2.5 text-white 
                                  focus:outline-none focus:border-[#eab308] focus:ring-1 focus:ring-[#eab308] 
                                  transition-all duration-200"
                           placeholder="Deixe em branco para manter a mesma">
                </div>
                
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-zinc-300 mb-2">
                        Confirmar Nova Senha
                    </label>
                    <input type="password" 
                           name="password_confirmation" 
                           id="password_confirmation" 
                           class="w-full bg-zinc-800/50 border border-zinc-700 rounded-xl px-4 py-2.5 text-white 
                                  focus:outline-none focus:border-[#eab308] focus:ring-1 focus:ring-[#eab308] 
                                  transition-all duration-200">
                </div>
                
                @if($user->last_login_at)
                    <div class="pt-2">
                        <p class="text-xs text-zinc-500">
                            Último acesso: {{ $user->last_login_at->format('d/m/Y H:i:s') }}
                        </p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Botões de Ação --}}
        <div class="flex justify-end gap-3">
            <a href="{{ route('profile.show') }}" 
               class="px-6 py-2.5 bg-zinc-800 hover:bg-zinc-700 text-zinc-300 rounded-xl transition-all duration-200">
                Cancelar
            </a>
            <button type="submit" 
                    class="px-6 py-2.5 bg-[#eab308] hover:bg-[#ca8a04] text-black font-semibold rounded-xl 
                           transition-all duration-200 transform hover:scale-105">
                Salvar Alterações
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validação de senha
        const passwordInput = document.getElementById('password');
        const passwordConfirmInput = document.getElementById('password_confirmation');
        const currentPasswordInput = document.getElementById('current_password');
        
        function validatePassword() {
            if (passwordInput.value && !currentPasswordInput.value) {
                currentPasswordInput.classList.add('border-red-500');
                currentPasswordInput.setCustomValidity('Por favor, informe sua senha atual para alterar a senha');
            } else {
                currentPasswordInput.classList.remove('border-red-500');
                currentPasswordInput.setCustomValidity('');
            }
            
            if (passwordInput.value !== passwordConfirmInput.value) {
                passwordConfirmInput.classList.add('border-red-500');
                passwordConfirmInput.setCustomValidity('As senhas não coincidem');
            } else {
                passwordConfirmInput.classList.remove('border-red-500');
                passwordConfirmInput.setCustomValidity('');
            }
        }
        
        if (passwordInput && passwordConfirmInput) {
            passwordInput.addEventListener('input', validatePassword);
            passwordConfirmInput.addEventListener('input', validatePassword);
            currentPasswordInput.addEventListener('input', validatePassword);
        }
        
        // Feedback visual nos campos
        const inputs = document.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-1', 'ring-[#eab308]/50');
            });
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-1', 'ring-[#eab308]/50');
            });
        });
        
        // Validação final antes de submeter
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                if (passwordInput.value && !currentPasswordInput.value) {
                    e.preventDefault();
                    alert('Para alterar sua senha, por favor informe sua senha atual.');
                    currentPasswordInput.focus();
                } else if (passwordInput.value !== passwordConfirmInput.value) {
                    e.preventDefault();
                    alert('As senhas não coincidem.');
                    passwordConfirmInput.focus();
                } else if (passwordInput.value && passwordInput.value.length < 6) {
                    e.preventDefault();
                    alert('A nova senha deve ter pelo menos 6 caracteres.');
                    passwordInput.focus();
                }
            });
        }
    });
</script>
@endsection