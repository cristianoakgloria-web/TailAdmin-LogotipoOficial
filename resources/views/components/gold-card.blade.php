{{-- Componente: Card padrão dourado --}}
@props(['padding' => 'p-8 sm:p-10'])

<div {{ $attributes->merge(['class' => 'art-card rounded-2xl ' . $padding . ' animate-fadeUp delay-100']) }}
     style="background: rgba(10, 10, 12, 0.92); backdrop-filter: blur(2px); border: 1px solid rgba(234, 179, 8, 0.25);">
    {{ $slot }}
</div>