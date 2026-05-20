{{-- resources/views/layouts/header.blade.php --}}
{{-- Header superior para o dashboard autenticado --}}
<header class="bg-[#0a0a0c]/80 backdrop-blur-sm border-b border-[#eab308]/20 sticky top-0 z-40">
    <div class="px-8 py-4 flex items-center justify-between">
        <!-- Título da página -->
        <div>
            <h1 class="text-2xl font-bold text-white">@yield('header', 'Dashboard')</h1>
            <p class="text-sm text-zinc-500">@yield('subheader', 'Visão geral do sistema')</p>
        </div>
        
        <!-- Ações do header -->
        <div class="flex items-center gap-4">            
            <!-- Dropdown do usuário -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center gap-3 p-2 rounded-lg hover:bg-[#eab308]/10 transition">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-[#eab308] to-[#ca9a00] flex items-center justify-center">
                        <span class="text-black font-bold text-sm">
                            {{ substr(Auth::user()->nome ?? 'U', 0, 1) }}
                        </span>
                    </div>
                    <span class="text-sm font-medium text-gray-300 hidden md:inline">
                        {{ Auth::user()->nome ?? 'Usuário' }}
                    </span>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                
                <!-- Dropdown menu -->
                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl shadow-xl z-50" style="display: none;">
                    <div class="py-1">
                        <!-- Perfil -->
                        <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-[#eab308] hover:bg-[#eab308]/10 transition">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Meu Perfil
                            </div>
                        </a>
                        
                        <!-- Divisor -->
                        <div class="border-t border-[#eab308]/20 my-1"></div>
                        
                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-400 hover:text-red-300 hover:bg-red-500/10 transition">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                    Sair
                                </div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>