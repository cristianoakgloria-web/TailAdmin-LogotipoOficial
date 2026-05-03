{{-- resources/views/auth/passwords/email.blade.php --}}
@extends('layouts.guest')

@section('title', 'Recuperar Senha')

@section('content')
<div class="w-full max-w-md animate-fadeUp">
    <x-application-logo subtitle="Recuperação de acesso" />
    
    <x-gold-card>
        <div class="text-center mb-6">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-[#eab308]/10 flex items-center justify-center">
                <svg class="w-8 h-8 text-[#eab308]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7.5a2.25 2.25 0 0 1 2.25 2.25M15 12a2.25 2.25 0 0 1-2.25 2.25M12 12a2.25 2.25 0 0 1-2.25 2.25M8.25 12a2.25 2.25 0 0 1-2.25-2.25M8.25 7.5a2.25 2.25 0 0 1 2.25 2.25m-6 4.5h15m-6 0v3m-6-3v3" />
                </svg>
            </div>
            <p class="text-zinc-400 text-sm">Digite seu e-mail e enviaremos um link para redefinir sua senha.</p>
        </div>

        @if (session('status'))
            <div class="mb-4 p-3 rounded-xl bg-[#eab308]/10 border border-[#eab308]/40 text-[#eab308] text-sm">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-3 rounded-xl bg-red-500/10 border border-red-500/40 text-red-400 text-sm">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            
            <div class="mb-6">
                <x-input-label for="email" :value="__('Endereço de e-mail')" required />
                <x-text-input id="email" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    placeholder="seu@email.com"
                    required 
                    autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            
            <x-primary-button>
                {{ __('Enviar link de recuperação') }}
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