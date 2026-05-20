{{-- resources/views/components/password-input.blade.php --}}
@props(['disabled' => false, 'error' => false, 'name', 'id' => null, 'placeholder' => '••••••••', 'required' => true])

@php
    $inputId = $id ?? 'password_' . rand(1000, 9999);
@endphp

<div class="relative">
    <input
        {{ $disabled ? 'disabled' : '' }}
        type="password"
        name="{{ $name }}"
        id="{{ $inputId }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'w-full input-art rounded-xl transition-all pr-12 ' . ($error ? 'border-red-500' : '')]) }}
        style="background: #0c0c0e; border: 1.5px solid rgba(234, 179, 8, 0.3); color: #f0f0f0; font-weight: 500; padding: 1rem 1.25rem;"
    >
    
    <button 
        type="button" 
        onclick="togglePasswordVisibility('{{ $inputId }}')"
        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-[#eab308] transition focus:outline-none z-10"
        style="background: transparent; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center;"
    >
        <!-- Ícone Olho Aberto (mostrar senha) -->
        <svg id="eye-open-{{ $inputId }}" class="w-5 h-5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
        </svg>
        
        <!-- Ícone Olho Fechado (esconder senha) -->
        <svg id="eye-closed-{{ $inputId }}" class="w-5 h-5 eye-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
        </svg>
    </button>
</div>

<script>
    function togglePasswordVisibility(inputId) {
        const input = document.getElementById(inputId);
        const eyeOpen = document.getElementById(`eye-open-${inputId}`);
        const eyeClosed = document.getElementById(`eye-closed-${inputId}`);
        
        if (input.type === 'password') {
            input.type = 'text';
            eyeOpen.classList.add('hidden');
            eyeClosed.classList.remove('hidden');
        } else {
            input.type = 'password';
            eyeOpen.classList.remove('hidden');
            eyeClosed.classList.add('hidden');
        }
    }
</script>