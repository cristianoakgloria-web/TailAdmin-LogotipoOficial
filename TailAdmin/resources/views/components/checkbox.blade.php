{{-- Componente: Checkbox personalizado --}}
@props(['checked' => false, 'label' => null])

<label class="flex items-center gap-2 cursor-pointer group">
    <input type="checkbox" {{ $checked ? 'checked' : '' }} {{ $attributes->merge(['class' => 'checkbox-art rounded']) }}
           style="appearance: none; width: 1.2rem; height: 1.2rem; background: #0c0c0e; border: 1.5px solid rgba(234, 179, 8, 0.5); cursor: pointer;">
    @if($label)
        <span class="text-gray-300 text-sm font-medium select-none group-hover:text-[#eab308] transition">{{ $label }}</span>
    @endif
    {{ $slot }}
</label>