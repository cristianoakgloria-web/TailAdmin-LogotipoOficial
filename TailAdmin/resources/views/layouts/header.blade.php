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
            <!-- Notificações -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="relative p-2 text-gray-400 hover:text-[#eab308] transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    @if(isset($notificationsCount) && $notificationsCount > 0)
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    @endif
                </button>
                
                <!-- Dropdown de notificações -->
                <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-80 bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl shadow-xl z-50" style="display: none;">
                    <div class="p-3 border-b border-[#eab308]/20">
                        <h3 class="text-sm font-semibold text-white">Notificações</h3>
                    </div>
                    <div class="max-h-96 overflow-y-auto">
                        <p class="text-center text-sm text-gray-500 py-8">Nenhuma notificação nova</p>
                    </div>
                </div>
            </div>
            
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
                        <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-[#eab308] hover:bg-[#eab308]/10 transition">
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