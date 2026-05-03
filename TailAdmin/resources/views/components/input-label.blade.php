{{-- resources/views/components/input-label.blade.php --}}
@props(['value', 'required' => false])

<label {{ $attributes->merge(['class' => 'block text-sm font-semibold text-[#eab308]/80 mb-2 uppercase tracking-wider']) }}>
    {{ $value ?? $slot }}
    @if($required)
        <span class="text-red-400 ml-1">*</span>
    @endif
</label>