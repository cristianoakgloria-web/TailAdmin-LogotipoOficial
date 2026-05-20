{{-- Componente: Link dentro de dropdown --}}
<a {{ $attributes->merge(['class' => 'block w-full px-4 py-2 text-left text-sm leading-5 text-gray-300 hover:text-[#eab308] transition duration-150 ease-in-out']) }}>
    {{ $slot }}
</a>