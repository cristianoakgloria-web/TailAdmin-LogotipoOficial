{{-- Componente: Logotipo Oficial com marca dourada --}}
<div {{ $attributes->merge(['class' => 'text-center mb-10']) }}>
    <div class="flex justify-center mb-5">
        <div class="logo-marca" style="background: linear-gradient(135deg, #eab308 0%, #ca9a00 100%); width: 90px; height: 90px; display: flex; align-items: center; justify-content: center; box-shadow: 0 20px 35px -12px rgba(234,179,8,0.3); position: relative;">
            <svg width="55" height="55" viewBox="0 0 36 36" fill="currentColor" style="color: #070707;" xmlns="http://www.w3.org/2000/svg">
                <path d="M18.845 5.825L18.645 5h-9.27v18.35h1.58v-7.85h6.315l0.185 0.85h8.975v-10.4h-7.585zM10.005 7.4h6.105l0.2 0.825h-6.305v-0.825zM10.005 10.125h6.605l0.2 0.825h-6.805v-0.825zM10.005 12.85h7.115l0.2 0.825h-7.315v-0.825zM20.175 15.375h-6.185l-0.2-0.85h6.385v0.85zM20.175 18.1h-6.485l-0.2-0.85h6.685v0.85zM22.26 10.75h-2.085v-0.85h2.085v0.85zM22.26 8.025h-2.085v-0.85h2.085v0.85zM22.26 13.475h-2.085v-0.85h2.085v0.85z"/>
            </svg>
            <div style="position: absolute; inset: -3px; border: 1px solid rgba(234,179,8,0.5); pointer-events: none;"></div>
        </div>
    </div>
    <h1 class="text-5xl sm:text-6xl font-black uppercase tracking-tighter leading-[1.1]" style="background: linear-gradient(135deg, #f5cd2d 0%, #eab308 40%, #ca9a00 100%); -webkit-background-clip: text; background-clip: text; color: transparent;">
        LOGOTIPO<br>OFICIAL
    </h1>
    <div class="w-16 h-[2px] bg-gradient-to-r from-transparent via-[#eab308] to-transparent mx-auto mt-4"></div>
    <p class="text-zinc-500 text-xs uppercase tracking-[0.2em] mt-3 font-semibold">{{ $subtitle ?? 'plataforma segura' }}</p>
</div>