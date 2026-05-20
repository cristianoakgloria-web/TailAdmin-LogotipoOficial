{{-- resources/views/auth/passwords/reset.blade.php --}}
@extends('layouts.guest')

@section('title', 'Redefinir Senha')

@section('content')
<div class="w-full max-w-md animate-fadeUp">
    <x-application-logo subtitle="Redefinir palavra-passe" />
    
    <x-gold-card>
        <div class="text-center mb-6">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-[#eab308]/10 flex items-center justify-center">
                <svg class="w-8 h-8 text-[#eab308]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <p class="text-zinc-400 text-sm">Digite sua nova palavra-passe.</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-3 rounded-xl bg-red-500/10 border border-red-500/40 text-red-400 text-sm">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.reset') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div class="mb-5">
                <x-input-label for="email" :value="__('Endereço de e-mail')" required />
                <x-text-input id="email" 
                    type="email" 
                    name="email" 
                    :value="old('email', $email ?? '')" 
                    placeholder="seu@email.com"
                    required 
                    autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            
            <div class="mb-5">
                <x-input-label for="password" :value="__('Nova palavra-passe')" required />
                <x-text-input id="password" 
                    type="password" 
                    name="password" 
                    placeholder="••••••••"
                    required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                <p class="text-xs text-zinc-500 mt-1">Mínimo de 8 caracteres</p>
            </div>
            
            <div class="mb-6">
                <x-input-label for="password_confirmation" :value="__('Confirmar palavra-passe')" required />
                <x-text-input id="password_confirmation" 
                    type="password" 
                    name="password_confirmation" 
                    placeholder="••••••••"
                    required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
            
            <x-primary-button>
                {{ __('Redefinir palavra-passe') }}
            </x-primary-button>
            
            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="text-zinc-500 hover:text-[#eab308] text-sm transition">
                    ← Voltar para o login
                </a>
            </div>
        </form>
    </x-gold-card>
</div>
@endsection