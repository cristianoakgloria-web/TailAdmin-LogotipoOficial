{{-- resources/views/layouts/sidebar.blade.php --}}
<aside class="w-64 bg-[#0a0a0c] border-r border-[#eab308]/20 flex flex-col h-full overflow-y-auto">
    <!-- Logo -->
    <div class="p-5 border-b border-[#eab308]/20">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
            <div class="logo-marca w-10 h-10 rounded-xl flex items-center justify-center transition-transform group-hover:scale-105">
                <svg width="24" height="24" viewBox="0 0 36 36" fill="currentColor" style="color: #070707;">
                    <path d="M18.845 5.825L18.645 5h-9.27v18.35h1.58v-7.85h6.315l0.185 0.85h8.975v-10.4h-7.585zM10.005 7.4h6.105l0.2 0.825h-6.305v-0.825zM10.005 10.125h6.605l0.2 0.825h-6.805v-0.825zM10.005 12.85h7.115l0.2 0.825h-7.315v-0.825zM20.175 15.375h-6.185l-0.2-0.85h6.385v0.85zM20.175 18.1h-6.485l-0.2-0.85h6.685v0.85zM22.26 10.75h-2.085v-0.85h2.085v0.85zM22.26 8.025h-2.085v-0.85h2.085v0.85zM22.26 13.475h-2.085v-0.85h2.085v0.85z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-[#eab308] font-black text-lg leading-tight">LOGOTIPO</h2>
                <p class="text-[10px] text-zinc-500 uppercase tracking-wider">Oficial</p>
            </div>
        </a>
    </div>
    
    <!-- Menu de navegação -->
    <nav class="flex-1 py-4 px-3 space-y-1">
        <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }} py-2.5 px-3 rounded-lg flex items-center gap-3 text-gray-300 hover:text-[#eab308] transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>Dashboard</span>
        </a>
        
        <a href="{{ route('profile') }}" class="sidebar-link {{ request()->routeIs('profile') ? 'active' : '' }} py-2.5 px-3 rounded-lg flex items-center gap-3 text-gray-300 hover:text-[#eab308] transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span>Meu Perfil</span>
        </a>
        
        <div class="border-t border-[#eab308]/20 my-3"></div>

        <a href="{{ route('clientes.index') }}" class="sidebar-link py-2.5 px-3 rounded-lg flex items-center gap-3 text-gray-300 hover:text-[#eab308] transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>Clientes</span>
        </a>

        <a href="{{ route('vendas.index') }}" class="sidebar-link py-2.5 px-3 rounded-lg flex items-center gap-3 text-gray-300 hover:text-[#eab308] transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>Vendas</span>
        </a>

        <div class="border-t border-[#eab308]/20 my-3"></div>
        
        @if(Auth::user()->hasRole('financeiro') || Auth::user()->isAdmin())
            <a href="{{ route('financeiro.dashboard') }}" class="sidebar-link py-2.5 px-3 rounded-lg flex items-center gap-3 text-gray-300 hover:text-[#eab308] transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Financeiro</span>
            </a>
        @endif
        
        @if(Auth::user()->hasRole('fiscal') || Auth::user()->isAdmin())
            <a href="{{ route('fiscal.index') }}" class="sidebar-link py-2.5 px-3 rounded-lg flex items-center gap-3 text-gray-300 hover:text-[#eab308] transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Fiscal</span>
            </a>
        @endif

        <div class="border-t border-[#eab308]/20 my-3"></div>
        <a href="{{ route('admin.audit-logs') }}" class="sidebar-link py-2.5 px-3 rounded-lg flex items-center gap-3 text-gray-300 hover:text-[#eab308] transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>Auditoria</span>
        </a>
    </nav>
    
    <!-- Informações do usuário -->
    <div class="p-4 border-t border-[#eab308]/20">
        <div class="mb-3 px-2">
            <p class="text-xs text-zinc-500 uppercase tracking-wider">Logado como</p>
            <p class="text-sm font-semibold text-gray-300 truncate">{{ Auth::user()->nome ?? 'Usuário' }}</p>
            <p class="text-xs text-zinc-600 truncate">{{ Auth::user()->email ?? 'email@exemplo.com' }}</p>
        </div>
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full px-4 py-2 text-sm text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-lg transition flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Sair
            </button>
        </form>
    </div>
</aside>