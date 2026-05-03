{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="w-full max-w-md animate-fadeUp">
    <x-application-logo subtitle="Área restrita" />
    
    <x-gold-card>
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

        <form method="POST" action="{{ route('login') }}">
            @csrf
            
            <div class="mb-5">
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
            
            <div class="mb-5">
                <x-input-label for="password" :value="__('Palavra-passe')" required />
                <x-password-input name="password" id="password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            
            <div class="flex justify-between items-center mb-6">
                <label class="flex items-center gap-2 cursor-pointer group">
                    <input type="checkbox" name="remember" class="checkbox-art rounded" style="appearance: none; width: 1.2rem; height: 1.2rem; background: #0c0c0e; border: 1.5px solid rgba(234, 179, 8, 0.5); cursor: pointer;
                    &:checked {
                        background: #eab308;
                        position: relative;
                    }
                    &:checked::after {
                        content: '✓';
                        position: absolute;
                        color: black;
                        font-size: 0.8rem;
                        top: 50%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                    }">
                    <span class="text-gray-300 text-sm font-medium select-none group-hover:text-[#eab308] transition">Lembrar-me</span>
                </label>
                
                @if(Route::has('password.email'))
                    <a href="{{ route('password.email') }}" class="text-[#eab308] hover:text-[#facc15] text-sm font-semibold transition underline decoration-1">
                        Esqueceu a palavra-passe?
                    </a>
                @else
                    <a href="#" class="text-[#eab308] hover:text-[#facc15] text-sm font-semibold transition underline decoration-1" onclick="alert('Contacte o administrador para recuperar a sua palavra-passe.')">
                        Esqueceu a palavra-passe?
                    </a>
                @endif
            </div>
            
            <x-primary-button>
                {{ __('Iniciar sessão') }}
            </x-primary-button>
        </form>
    </x-gold-card>
</div>
@endsection