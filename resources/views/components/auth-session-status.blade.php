{{-- Componente: Status de sessão (sucesso/erro) --}}
@props(['status', 'type' => 'success'])

@if($status)
<div {{ $attributes->merge(['class' => 'feedback-message mt-3 p-3 rounded-xl text-sm font-semibold transition-all ' . ($type === 'success' ? 'bg-[#eab308]/10 border border-[#eab308]/40 text-[#eab308]' : 'bg-red-500/10 border border-red-500/40 text-red-400')]) }}>
    <span class="flex items-center gap-2">
        @if($type === 'success')
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        @else
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        @endif
        {{ $status }}
    </span>
</div>
@endif