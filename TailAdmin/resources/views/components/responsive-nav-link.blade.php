{{-- Componente: Link de navegação responsivo (mobile) --}}
@props(['active' => false])

@php
$classes = ($active ?? false)
    ? 'block w-full pl-3 pr-4 py-2 border-l-4 border-[#eab308] text-left text-base font-medium text-[#eab308] bg-[#eab308]/10 focus:outline-none focus:text-[#eab308] focus:bg-[#eab308]/10 focus:border-[#eab308] transition duration-150 ease-in-out'
    : 'block w-full pl-3 pr-4 py-2 border-l-4 border-transparent text-left text-base font-medium text-gray-400 hover:text-[#eab308] hover:bg-[#eab308]/5 hover:border-[#eab308]/50 focus:outline-none focus:text-[#eab308] focus:bg-[#eab308]/5 focus:border-[#eab308]/50 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>