{{-- Componente: Botão secundário (contorno dourado) --}}
@props(['disabled' => false, 'type' => 'button'])

<button
    {{ $disabled ? 'disabled' : '' }}
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'px-4 py-2 bg-transparent border-2 border-[#eab308] text-[#eab308] font-bold rounded-xl transition-all hover:bg-[#eab308]/10 transform active:scale-95 disabled:opacity-50']) }}
>
    {{ $slot }}
</button>