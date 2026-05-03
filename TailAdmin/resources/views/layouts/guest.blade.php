{{-- resources/views/layouts/guest.blade.php --}}
{{-- Layout para páginas públicas (login, registro, recuperar senha) --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Logotipo Oficial') }} - @yield('title', 'Acesso')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800;14..32,900&family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* Estilos base para páginas públicas */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: #070707;
            font-family: 'Inter', 'Sora', system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        
        /* Elementos decorativos */
        .bg-orb-1 {
            position: fixed;
            top: -20%;
            right: -10%;
            width: 60%;
            height: 60%;
            background: radial-gradient(circle, rgba(234,179,8,0.08) 0%, rgba(234,179,8,0) 70%);
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }
        
        .bg-orb-2 {
            position: fixed;
            bottom: -15%;
            left: -15%;
            width: 55%;
            height: 55%;
            background: radial-gradient(circle, rgba(234,179,8,0.05) 0%, rgba(234,179,8,0) 70%);
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }
        
        .bg-lines {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: repeating-linear-gradient(90deg, rgba(234,179,8,0.02) 0px, rgba(234,179,8,0.02) 1px, transparent 1px, transparent 80px);
            pointer-events: none;
            z-index: 0;
        }
        
        /* Card principal */
        .art-card {
            background: rgba(10, 10, 12, 0.92);
            backdrop-filter: blur(2px);
            border: 1px solid rgba(234, 179, 8, 0.25);
            transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            position: relative;
            overflow: hidden;
        }
        
        .art-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent, #eab308, #facc15, #eab308, transparent);
            animation: shimmer 8s infinite;
        }
        
        @keyframes shimmer {
            0% { left: -100%; }
            50% { left: 100%; }
            100% { left: 100%; }
        }
        
        /* Inputs estilizados */
        .input-art {
            background: #0c0c0e;
            border: 1.5px solid rgba(234, 179, 8, 0.3);
            color: #f0f0f0;
            font-weight: 500;
            transition: all 0.25s ease;
            padding: 1rem 1.25rem;
        }
        
        .input-art:focus {
            border-color: #eab308;
            box-shadow: 0 0 0 3px rgba(234, 179, 8, 0.15);
            outline: none;
            background: #0a0a0c;
        }
        
        .input-art::placeholder {
            color: #4a4a50;
            font-weight: 400;
        }
        
        /* Botão primário */
        .btn-art {
            background: linear-gradient(100deg, #eab308 0%, #d4a006 100%);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .btn-art::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .btn-art:hover::before {
            left: 100%;
        }
        
        .btn-art:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px -10px rgba(234,179,8,0.5);
        }
        
        /* Animações */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fadeUp {
            animation: fadeUp 0.7s ease-out forwards;
        }
        
        /* Logo marca */
        .logo-marca {
            background: linear-gradient(135deg, #eab308 0%, #ca9a00 100%);
            box-shadow: 0 20px 35px -12px rgba(234,179,8,0.3);
            transition: all 0.3s ease;
        }
        
        .logo-marca:hover {
            transform: scale(1.02);
        }
        
        /* Título com gradiente */
        .title-primary {
            font-family: 'Sora', 'Inter', sans-serif;
            font-weight: 800;
            letter-spacing: -0.02em;
            background: linear-gradient(135deg, #f5cd2d 0%, #eab308 40%, #ca9a00 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Elementos decorativos -->
    <div class="bg-orb-1"></div>
    <div class="bg-orb-2"></div>
    <div class="bg-lines"></div>
    
    <!-- Conteúdo principal -->
    <div class="relative z-10 min-h-screen flex items-center justify-center p-4">
        @yield('content')
    </div>
    
    @stack('scripts')
</body>
</html>