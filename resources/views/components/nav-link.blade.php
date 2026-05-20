{{-- Componente: Link de navegação --}}
@props(['active' => false])

@php
$classes = ($active ?? false)
    ? 'inline-flex items-center px-1 pt-1 border-b-2 border-[#eab308] text-sm font-medium leading-5 text-[#eab308] focus:outline-none focus:border-[#eab308] transition duration-150 ease-in-out'
    : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-400 hover:text-[#eab308] hover:border-[#eab308]/50 focus:outline-none focus:text-[#eab308] focus:border-[#eab308]/50 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>