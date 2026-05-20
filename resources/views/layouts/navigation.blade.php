{{-- resources/views/layouts/navigation.blade.php --}}
{{-- Navegação alternativa para layouts que não usam sidebar fixa --}}
<nav x-data="{ open: false }" class="bg-[#0a0a0c] border-b border-[#eab308]/20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <div class="logo-marca w-8 h-8 rounded-lg flex items-center justify-center">
                        <svg width="18" height="18" viewBox="0 0 36 36" fill="currentColor" style="color: #070707;">
                            <path d="M18.845 5.825L18.645 5h-9.27v18.35h1.58v-7.85h6.315l0.185 0.85h8.975v-10.4h-7.585zM10.005 7.4h6.105l0.2 0.825h-6.305v-0.825zM10.005 10.125h6.605l0.2 0.825h-6.805v-0.825zM10.005 12.85h7.115l0.2 0.825h-7.315v-0.825zM20.175 15.375h-6.185l-0.2-0.85h6.385v0.85zM20.175 18.1h-6.485l-0.2-0.85h6.685v0.85z"/>
                        </svg>
                    </div>
                    <span class="font-black text-[#eab308] text-lg">LOGOTIPO OFICIAL</span>
                </a>
            </div>
            
            <!-- Links Desktop -->
            <div class="hidden md:flex items-center space-x-4">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-nav-link>
                <x-nav-link :href="route('profile')" :active="request()->routeIs('profile*')">Perfil</x-nav-link>
                <x-nav-link :href="route('settings')" :active="request()->routeIs('settings*')">Configurações</x-nav-link>
            </div>
            
            <!-- Dropdown Mobile Button -->
            <div class="flex items-center md:hidden">
                <button @click="open = !open" class="text-gray-400 hover:text-[#eab308] focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- User Menu Desktop -->
            <div class="hidden md:flex items-center">
                <div x-data="{ userOpen: false }" class="relative">
                    <button @click="userOpen = !userOpen" class="flex items-center gap-2 text-gray-300 hover:text-[#eab308]">
                        <span>{{ Auth::user()->name ?? 'Usuário' }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    
                    <div x-show="userOpen" @click.away="userOpen = false" class="absolute right-0 mt-2 w-48 bg-[#0c0c0e] border border-[#eab308]/20 rounded-xl shadow-xl z-50" style="display: none;">
                        <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-[#eab308] hover:bg-[#eab308]/10">Meu Perfil</a>
                        <a href="{{ route('settings') }}" class="block px-4 py-2 text-sm text-gray-300 hover:text-[#eab308] hover:bg-[#eab308]/10">Configurações</a>
                        <div class="border-t border-[#eab308]/20"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-400 hover:text-red-300 hover:bg-red-500/10">Sair</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div x-show="open" class="md:hidden border-t border-[#eab308]/20" style="display: none;">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('profile')" :active="request()->routeIs('profile*')">Perfil</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('settings')" :active="request()->routeIs('settings*')">Configurações</x-responsive-nav-link>
            <div class="border-t border-[#eab308]/20 my-2"></div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link as="button" type="submit" class="w-full text-left text-red-400">Sair</x-responsive-nav-link>
            </form>
        </div>
    </div>
</nav>

<style>
    .logo-marca {
        background: linear-gradient(135deg, #eab308 0%, #ca9a00 100%);
    }
</style>