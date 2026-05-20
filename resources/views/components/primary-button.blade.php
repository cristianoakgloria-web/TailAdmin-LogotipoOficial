{{-- resources/views/components/primary-button.blade.php --}}
@props(['disabled' => false, 'type' => 'submit', 'fullWidth' => true])

<button
    {{ $disabled ? 'disabled' : '' }}
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'btn-art ' . ($fullWidth ? 'w-full' : '') . ' py-3.5 rounded-xl text-black font-extrabold text-lg uppercase tracking-wider transition-all flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed']) }}
    style="background: linear-gradient(100deg, #eab308 0%, #d4a006 100%);"
>
    {{ $slot }}
    <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" />
    </svg>
</button>