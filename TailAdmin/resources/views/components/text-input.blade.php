{{-- Componente: Input de texto estilizado --}}
@props(['disabled' => false, 'error' => false])

<input
    {{ $disabled ? 'disabled' : '' }}
    {!! $attributes->merge(['class' => 'w-full input-art rounded-xl transition-all ' . ($error ? 'border-red-500' : '')]) !!}
    style="background: #0c0c0e; border: 1.5px solid rgba(234, 179, 8, 0.3); color: #f0f0f0; font-weight: 500; padding: 1rem 1.25rem;"
>