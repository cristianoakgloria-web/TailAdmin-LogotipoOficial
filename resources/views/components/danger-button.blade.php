{{-- Componente: Botão de perigo (vermelho) --}}
@props(['disabled' => false, 'type' => 'button'])

<button {{ $disabled ? 'disabled' : '' }} type="{{ $type }}" {{ $attributes->merge(['class' => 'px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all transform active:scale-95 disabled:opacity-50']) }}>
    {{ $slot }}
</button>